<?php

namespace Tests\Feature;

use App\Admin;
use App\User;
use App\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_database()
    {
        // test database for user
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_database()
    {
        // test database for admin
        factory(Admin::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_vacancy_database()
    {
        // test database for vacancies
        factory(Vacancy::class, 10)->create();
    }
}
