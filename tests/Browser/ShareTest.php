<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShareTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testSharingFunctionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    // Verify share section exists
                    ->assertSee('Share with Friends')
                    ->assertSee('Challenge your friends to beat your score!')

                    // Verify all share buttons are present
                    ->assertPresent('button[onclick="shareOnTwitter()"]')
                    ->assertPresent('button[onclick="shareOnFacebook()"]')
                    ->assertPresent('button[onclick="copyLink()"]');

            // Test copy link functionality
            $browser->click('button[onclick="copyLink()"]')
                    ->waitFor('.toast')  // Wait for toast notification
                    ->assertSee('Link copied to clipboard!')
                    ->pause(1000);  // Wait for toast animation

            // Verify share buttons have correct content
            $browser->assertPresent('button[onclick="shareOnTwitter()"] svg')
                    ->assertPresent('button[onclick="shareOnFacebook()"] svg')
                    ->assertPresent('button[onclick="copyLink()"] svg');

            // Verify the share text content
            $browser->assertScript(
                'return document.querySelector("button[onclick=\'shareOnTwitter()\']").closest("section").textContent.includes("Challenge your friends")'
            );
        });
    }

    public function testShareButtonsResponsiveness()
    {
        $this->browse(function (Browser $browser) {
            // Test on desktop view
            $browser->resize(1920, 1080)
                    ->visit('/')
                    ->assertVisible('button[onclick="shareOnTwitter()"] span.sm\\:inline')
                    ->assertVisible('button[onclick="shareOnFacebook()"] span.sm\\:inline')
                    ->assertVisible('button[onclick="copyLink()"] span.sm\\:inline');

            // Test on mobile view
            $browser->resize(375, 812)
                    ->refresh()
                    ->assertMissing('button[onclick="shareOnTwitter()"] span.sm\\:inline')
                    ->assertMissing('button[onclick="shareOnFacebook()"] span.sm\\:inline')
                    ->assertMissing('button[onclick="copyLink()"] span.sm\\:inline')
                    // Verify icons are still visible on mobile
                    ->assertVisible('button[onclick="shareOnTwitter()"] svg')
                    ->assertVisible('button[onclick="shareOnFacebook()"] svg')
                    ->assertVisible('button[onclick="copyLink()"] svg');
        });
    }
}
