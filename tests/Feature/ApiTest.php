<?php

namespace Tests\Feature;

use App\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_response()
    {
        $response = $this->withHeaders([
            'Authorization' => '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
            'content-type' => 'application/json'
        ])->json('GET', '/api/vacancies');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_by_id_response()
    {
        $vacancy_id =  factory(Vacancy::class)->create()->id;
        $response = $this->withHeaders([
            'Authorization' => '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
            'content-type' => 'application/json'
        ])->json('GET', '/api/vacancy/' . $vacancy_id);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_response()
    {
        $response = $this->withHeaders([
            'Authorization' => '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
            'content-type' => 'application/json'
        ])->json('POST', '/api/vacancy', [
            'name' => $this->faker->realText(10),
            'company' => $this->faker->company,
            'description' => $this->faker->realText(500),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_put_response()
    {
        $vacancy_id =  factory(Vacancy::class)->create()->id;
        $response = $this->withHeaders([
            'Authorization' => '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
            'content-type' => 'application/json'
        ])->json('PUT', '/api/vacancy', [
            'vacancy_id' => $vacancy_id,
            'name' => $this->faker->realText(10),
            'company' => $this->faker->company,
            'description' => $this->faker->realText(500),
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_response()
    {
        $vacancy_id =  factory(Vacancy::class)->create()->id;
        $response = $this->withHeaders([
            'Authorization' => '6H1H7W80jqXhBa4XTC81wgqkpsgWQfld3RqvgEzFy0awDSPACxpfYkfj6nUGULv3',
            'content-type' => 'application/json'
        ])->json('DELETE', '/api/vacancy/' . $vacancy_id);

        $response->assertStatus(Response::HTTP_OK);
    }
}
