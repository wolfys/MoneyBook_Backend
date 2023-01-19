<?php

namespace Http\Controllers\Api;

use App\Models\ExpendCategories;
use App\Models\IncomeCategories;
use Tests\TestCase;

class IncomeCategoriesControllerTest extends TestCase
{

    protected string $token;


    public function __construct($token = null)
    {
        parent::__construct($token);
        $this->token = 'Bearer 1|CFsX5BELU48axCJlD4z9tqysc1hu4LSuniv5T2rA';

    }

    public function testIndex()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson('/api/income/categories');

        $response->assertStatus(200);
    }

    public function testIndexUserCategory()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson('/api/income/active/categories');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $arr = [
            'name' => 'Ивент'
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/income/categories', $arr);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $id = ExpendCategories::orderBy('id', 'desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson("/api/income/categories/{$id}");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $id = IncomeCategories::orderBy('id', 'desc')->first()->id;

        $arr = [
            'name' => 'Премия'
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson("/api/income/categories/{$id}", $arr);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $id = IncomeCategories::orderBy('id', 'desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->deleteJson("/api/income/categories/{$id}");

        $response->assertStatus(200);
    }
}
