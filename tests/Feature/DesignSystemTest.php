<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignSystemTest extends TestCase
{
    public function test_design_system_page_can_be_rendered()
    {
        $response = $this->get(route('design-system'));

        $response->assertStatus(200);
        $response->assertSee('Design System Showcase');
        $response->assertSee('Color System and Typography');
    }
}
