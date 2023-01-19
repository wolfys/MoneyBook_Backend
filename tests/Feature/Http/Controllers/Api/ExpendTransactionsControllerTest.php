<?php

namespace Http\Controllers\Api;

use App\Models\ExpendTransactions;
use Carbon\Carbon;
use Tests\TestCase;

class ExpendTransactionsControllerTest extends TestCase
{

    protected string $token;


    public function __construct($token = null)
    {
        parent::__construct($token);
        $this->token = 'Bearer 1|CFsX5BELU48axCJlD4z9tqysc1hu4LSuniv5T2rA';

    }

    public function testIndex()
    {
        $start = Carbon::now()->startOfMonth()->format('d.m.Y');

        $end = Carbon::now()->endOfMonth()->format('d.m.Y');

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson("/api/expend/transactions?start_date={$start}&end_date={$end}");

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $arr = [
            'category_id' => 1,
            'money' => 322,
            'date_transaction' => '13.01.2023',
            'comment' => 'Доход от просмотра рекламы.',
            'credit' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->postJson('/api/expend/transactions', $arr);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $id = ExpendTransactions::orderBy('id','desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson("/api/expend/transactions/{$id}");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $id = ExpendTransactions::orderBy('id','desc')->first()->id;

        $arr = [
            'category_id' => 1,
            'money' => 666,
            'date_transaction' => '13.01.2023',
            'comment' => 'Доход от просмотра рекламы.',
            'credit' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson("/api/expend/transactions/{$id}", $arr);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $id = ExpendTransactions::orderBy('id','desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->deleteJson("/api/expend/transactions/{$id}");

        $response->assertStatus(200);
    }
}
