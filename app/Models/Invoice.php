<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_net',
        'invoice_vat',
        'invoice_total',
        'due_date',
        'extra_info',
    ];

    protected $casts = [
        'invoice_net' => 'decimal:2',
        'invoice_vat' => 'decimal:2',
        'invoice_total' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function translationJobs()
    {
        return $this->hasMany(TranslationJob::class);
    }
}
