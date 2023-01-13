<?php

namespace Database\Factories;

use App\Models\IncomeTransactions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IncomeTransactions>
 */
class IncomeTransactionsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'income_category_id' => fake()->numberBetween(1, 8),
            'money' => fake()->numberBetween(50, 5000),
            'date_transaction' => now(),
            'comment' => fake()->sentence(),
            'credit' => fake()->numberBetween(0, 1),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
