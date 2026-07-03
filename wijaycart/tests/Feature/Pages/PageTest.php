<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_pages_are_accessible(): void
    {
        $this->get(route('pages.about'))->assertOk();
        $this->get(route('pages.help'))->assertOk();
        $this->get(route('pages.privacy'))->assertOk();
        $this->get(route('pages.terms'))->assertOk();
        $this->get(route('pages.contact'))->assertOk();
    }
}
