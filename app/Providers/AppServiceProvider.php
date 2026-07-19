<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\Storage\CloudinaryStorageService::class);
        $this->app->singleton(\App\Services\Storage\GoogleDriveStorageService::class);
        $this->app->singleton(\App\Services\Storage\LocalDocumentStorageService::class);
        $this->app->singleton(\App\Services\Storage\StorageManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Mail\Events\MessageSending::class,
            [\App\Listeners\MailMessageListener::class, 'handleSending']
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Mail\Events\MessageSent::class,
            [\App\Listeners\MailMessageListener::class, 'handleSent']
        );
    }
}
