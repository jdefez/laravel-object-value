<?php

namespace Tests\Feature;

use App\Enums\TimeCutting;
use App\Models\User;
use App\Values\UserConfigValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserConfigValueTest extends TestCase
{
    use RefreshDatabase;

    // todo: fails when (value instanciation or value.set):
    //  - Value is not conforming to setting.values
    //  - Or setting name does not exists

    /** @test */
    public function user_config_casts_as_user_config_value()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(UserConfigValue::class, $user->config);
    }

    /** @test */
    public function user_config_casts_correctly_when_stored()
    {
        $user = User::factory()->create(['config' => [
            'time_cutting' => TimeCutting::HOUR,
        ]]);
        $user = $user->fresh();

        $this->assertEquals(TimeCutting::HOUR, $user->config->get('time_cutting'));
    }

    /** @test */
    public function user_config_casts_correctly_when_updated()
    {
        $user = User::factory()->create(['config' => [
            'time_cutting' => TimeCutting::HOUR,
        ]]);

        $user->config->set('time_cutting', TimeCutting::MINUTE);
        $user->save();
        $user = $user->fresh();

        $this->assertEquals(TimeCutting::MINUTE, $user->config->get('time_cutting'));
    }

    /** @test */
    public function user_inherits_default_settings_if_his_config_is_empty()
    {
        $user = User::factory()->create();

        collect(config('user.settings'))
            ->each(function ($value, $key) use ($user) {
                $this->assertTrue($user->config->is($key, $value['default']));
            });
    }
}
