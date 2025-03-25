<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LineItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'line_item_id';

    protected $fillable = ['invoice_id', 'item_name', 'quantity', 'unit_of_measure', 'price'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
