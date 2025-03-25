<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\LineItem;

class LineItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LineItem::query()->delete();
        Invoice::all()->each(function ($invoice) {
            LineItem::factory()->count(rand(1, 5))->create([
                'invoice_id' => $invoice->invoice_id,
            ]);
        });
    }
}
