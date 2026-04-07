<?php

namespace Database\Factories;

use App\Models\RekonKas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RekonKas>
 */
class RekonKasFactory extends Factory
{
    protected $model = RekonKas::class;

    public function definition(): array
    {
        $openingCash = fake()->numberBetween(100000, 1000000);
        $cashIncome = fake()->numberBetween(50000, 750000);
        $nonCashIncome = fake()->numberBetween(0, 500000);
        $operationalCash = fake()->numberBetween(10000, 300000);

        $cashExpected = ($openingCash + $cashIncome) - $operationalCash;
        $difference = fake()->randomElement([
            0,
            fake()->numberBetween(-50000, -1000),
            fake()->numberBetween(1000, 50000),
        ]);
        $actualCash = $cashExpected + $difference;

        $status = match (true) {
            $difference === 0 => RekonKas::STATUS_MATCH,
            $difference < 0 => RekonKas::STATUS_KURANG,
            default => RekonKas::STATUS_LEBIH,
        };

        return [
            'rekon_date'       => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'opening_cash'     => $openingCash,
            'cash_income'      => $cashIncome,
            'non_cash_income'  => $nonCashIncome,
            'operational_cash' => $operationalCash,
            'cash_expected'    => $cashExpected,
            'actual_cash'      => $actualCash,
            'difference'       => $difference,
            'status'           => $status,
            'notes'            => fake()->optional()->sentence(),
            'created_by'       => User::factory(),
        ];
    }
}