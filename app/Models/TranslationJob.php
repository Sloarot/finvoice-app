<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'service',
        'title',
        'price',
        'total_price',
        'quantity',
        'vat',
        'deadline',
        'completed_at',
        'client_id',
        'invoice_id',
        'is_on_invoice',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
