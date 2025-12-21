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
        'vat',
        'deadline',
        'completed_at',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
