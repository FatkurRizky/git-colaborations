<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RekonKasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $opening = fake()->numberBetween(100000, 500000);
        $income = fake()->numberBetween(1000000, 5000000);
        $operational = fake()->numberBetween(5000, 20000);

        $expected = $opening - $operational;

        $actual = fake() -> randomElement([$expected, $expected - 5000, $expected + 2000]);
        $difference = $actual - $expected;
        return [
            'rekon_date' => now(),
            'opening_cash' => $opening,
            'cash_income' => $income,
            'non_cash_income' => fake()->numberBetween(10000, 100000),
            'operational_cash' => $operational,
            'cash_expected' => $expected,
            'actual_cash' => $actual,
            'difference' => $difference,
            'status' => $difference == 0? 'match': ($difference < 0 ? 'selisih kurang' : 'selisih lebih'),
            'notes' => fake()->sentence(),
            'created_by' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
