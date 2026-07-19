<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\NotificationPreference;
use App\Models\EmailLog;
use App\Models\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailNotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed Spatie roles
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'job_seeker']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employer']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    }

    public function test_user_registration_creates_default_preferences_and_queues_welcome_email()
    {
        Mail::fake();

        $response = $this->post('/register', [
            'role' => 'job_seeker',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'headline' => 'Software Engineer',
        ]);

        $response->assertRedirect('/dashboard');

        // Assert Notification Preference was created with defaults
        $user = User::where('email', 'john.doe@example.com')->first();
        $this->assertNotNull($user);
        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $user->id,
            'email_enabled' => true,
            'in_app_enabled' => true,
            'application_updates' => true,
        ]);

        // Assert WelcomeMail was queued to the registered email address
        Mail::assertQueued(WelcomeMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->user->id === $user->id;
        });
    }

    public function test_updating_notification_preferences()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');

        $response = $this->actingAs($user)->put('/profile/notifications', [
            'email_enabled' => '1',
            'in_app_enabled' => '1',
            'application_updates' => '1',
        ]);

        $response->assertRedirect('/profile/notifications');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $user->id,
            'email_enabled' => true,
            'push_enabled' => false,
            'in_app_enabled' => true,
            'job_alerts' => false,
            'application_updates' => true,
            'marketing_emails' => false,
        ]);
    }

    public function test_sent_mail_triggers_automatic_logging_in_database()
    {
        // Fire mail directly to test our AppServiceProvider dynamic listeners
        Mail::to('test@example.com')->send(new WelcomeMail(User::factory()->create()));

        // Assert that the email log was recorded
        $this->assertDatabaseHas('email_logs', [
            'recipient' => 'test@example.com',
            'subject' => 'Welcome to JOBZ IN CANADA',
            'status' => 'sent',
        ]);
    }

    public function test_in_app_notifications_interactions()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $user->assignRole('job_seeker');

        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => 'Test Alert',
            'body' => 'Test Alert message',
            'type' => 'test',
            'is_read' => false,
        ]);

        // Mark as Read
        $responseRead = $this->actingAs($user)->patch("/notifications/{$notification->id}/read");
        $responseRead->assertRedirect();
        $this->assertTrue((bool)$notification->fresh()->is_read);

        // Delete Notification
        $responseDelete = $this->actingAs($user)->delete("/notifications/{$notification->id}");
        $responseDelete->assertRedirect();
        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }
}
