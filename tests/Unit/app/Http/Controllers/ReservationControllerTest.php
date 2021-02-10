<?php

namespace Tests\Unit\app\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_a_new_reservation()
    {
        User::factory()->create(['is_available' => True]);
        $response = $this->json('POST', route('reservation.store' ,[
            'user_id' => 1,
        ]));

        $response->assertRedirect(route('reservation.show', Reservation::where('id', 1)->first()->slug));
    }

    public function test_user_cannot_create_a_new_reservation()
    {
        $this->actingAs(User::factory()->make());

        User::factory()->create([
            'role' => 'specialist',
            'is_available' => True
        ]);

        $response = $this->json('POST', route('reservation.store' ,[
            'user_id' => 1,
        ]));

        $response->assertRedirect(route('home'));
    }
}
