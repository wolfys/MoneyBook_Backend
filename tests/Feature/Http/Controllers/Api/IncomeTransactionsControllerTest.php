<?php

namespace Http\Controllers\Api;

use App\Models\ExpendTransactions;
use App\Models\IncomeTransactions;
use Carbon\Carbon;
use Tests\TestCase;

class IncomeTransactionsControllerTest extends TestCase
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
        ])->getJson("/api/income/transactions?start_date={$start}&end_date={$end}");

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
        ])->postJson('/api/income/transactions', $arr);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $id = IncomeTransactions::orderBy('id','desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson("/api/income/transactions/{$id}");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $id = IncomeTransactions::orderBy('id','desc')->first()->id;

        $arr = [
            'category_id' => 1,
            'money' => 666,
            'date_transaction' => '13.01.2023',
            'comment' => 'Доход от просмотра рекламы.',
            'credit' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->putJson("/api/income/transactions/{$id}", $arr);

        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $id = IncomeTransactions::orderBy('id','desc')->first()->id;

        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->deleteJson("/api/income/transactions/{$id}");

        $response->assertStatus(200);
    }
}
