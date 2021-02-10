<?php

namespace Tests\Unit\app\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DisplayControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make ajax GET request
     */
    private function ajaxGet($uri, array $data = [])
    {
        return $this->get($uri, array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    }

    public function test_guest_is_redirected_from_display_to_login()
    {
        $response = $this->get(route('display.show'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_from_display_home_to_login()
    {
        $response = $this->get(route('display.home'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_to_login_when_trying_to_fetch_data_via_ajax_request()
    {
        $response = $this->ajaxGet(route('display.show'));
        $response->assertRedirect(route('login'));
    }

    public function test_specialist_is_redirected_from_display_to_home()
    {
        $this->actingAs(User::factory()->make(['role' => 'specialist']));

        $response = $this->get(route('display.show'));
        $response->assertRedirect(route('home'));

    }

    public function test_specialist_is_redirected_from_display_home_to_home()
    {
        $this->actingAs(User::factory()->make(['role' => 'specialist']));

        $response = $this->get(route('display.home'));
        $response->assertRedirect(route('home'));
    }

    public function test_specialist_is_redirected_home_when_trying_to_fetch_data_via_ajax_request()
    {
        $this->actingAs(User::factory()->make(['role' => 'specialist']));

        $response = $this->ajaxGet(route('display.show'));
        $response->assertRedirect(route('home'));
    }

    public function test_display_user_is_allowed_to_view_display()
    {
        $this->actingAs(User::factory()->make(['role' => 'display']));

        $response = $this->get(route('display.show'));
        $response->assertOk();
    }

    public function test_display_user_is_allowed_to_view_display_home()
    {
        $this->actingAs(User::factory()->make(['role' => 'display']));

        $response = $this->get(route('display.home'));
        $response->assertOk();
    }

    public function test_display_user_is_allowed_to_fetch_data_via_ajax_request()
    {
        $this->actingAs(User::factory()->make(['role' => 'display']));

        $response = $this->ajaxGet(route('display.show'));
        $response->assertOk();
    }

    public function test_ajax_display_data_request_returns_only_active_reservations()
    {
        $this->actingAs(User::factory()->make(['role' => 'display']));

        User::factory()->count(2)->create(['role' => 'specialist', 'is_available' => True]);
        Reservation::factory()->count(2)->create(['status' => 'received']);
        Reservation::factory()->count(2)->create(['status' => 'in progress']);
        Reservation::factory()->count(2)->create(['status' => 'finished']);
        Reservation::factory()->count(2)->create(['status' => 'cancelled']);

        $response = $this->ajaxGet(route('display.show'));

        $reservationsReceived = json_decode($response->getContent(), True)['reservationsReceived'];
        $reservationsInProgress = json_decode($response->getContent(), True)['reservationsInProgress'];
        $this->assertTrue(count($reservationsReceived) === 2);
        $this->assertTrue(count($reservationsInProgress) === 2);

        for ($i = 0; $i<2; $i++) {
            $this->assertTrue($reservationsReceived[$i]['status'] === 'received');
            $this->assertTrue($reservationsInProgress[$i]['status'] === 'in progress');
        }
    }
}
