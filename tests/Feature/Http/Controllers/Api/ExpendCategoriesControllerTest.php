<?php

namespace Http\Controllers\Api;

use App\Models\ExpendCategories;
use Tests\TestCase;

class ExpendCategoriesControllerTest extends TestCase
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
        ])->getJson('/api/expend/categories');

        $response->assertStatus(200);
    }

    public function testIndexUserCategory()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson('/api/expend/active/categories');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $arr = [
            'name' => 'Шоколадки'
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/expend/categories', $arr);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $id = ExpendCategories::orderBy('id', 'desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson("/api/expend/categories/{$id}");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $id = ExpendCategories::orderBy('id', 'desc')->first()->id;

        $arr = [
            'name' => 'Мороженько'
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson("/api/expend/categories/{$id}", $arr);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $id = ExpendCategories::orderBy('id', 'desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->deleteJson("/api/expend/categories/{$id}");

        $response->assertStatus(200);
    }
}
