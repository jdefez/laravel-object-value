<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Values\DaysValue;
use App\Models\User;
use Tests\TestCase;

class UserDaysObjectValueTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @var User */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'days' => [
                [
                    'start_at' => '2021-06-01 00:00:00',
                    'end_at' => '2021-06-01 01:33:00'
                ],
                [
                    'start_at' => '2021-06-02 16:00:00',
                    'end_at' => '2021-06-02 17:40:00'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_casts_user_days_as_days_value()
    {

        $this->assertInstanceOf(DaysValue::class, $this->user->days);
    }

    /** @test */
    public function it_can_update_user_days_and_store_it()
    {
        $this->user->days->first()->start_at->addHour();
        $this->user->days->first()->end_at->addHour();
        $this->user->save();

        $fresh = $this->user->fresh();
        $days = $fresh->days;
        $this->assertTrue($this->user->days->first()->start_at->eq($days->first()->start_at));
        $this->assertTrue($this->user->days->last()->start_at->eq($days->last()->start_at));
    }
}
