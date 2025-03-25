<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceDate = $this->faker->dateTimeBetween('-6 months', 'now');

        $dueDate = Carbon::instance($invoiceDate)->addDays(rand(1, 60));

        return [
            'customer_name' => $this->faker->name,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'status' => $this->faker->randomElement(['Open', 'Paid', 'Pending Approval'])
        ];
    }
}
