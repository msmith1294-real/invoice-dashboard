<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id';

    protected $fillable = ['customer_name', 'invoice_date', 'due_date', 'status'];

    public function lineItems() {
        return $this->hasMany(LineItem::class, 'invoice_id');
    }

    public function getLineItemTotalAttribute() {
        return $this->lineItems->sum(function ($lineItem) {
            return $lineItem->price;
        });
    }
}
