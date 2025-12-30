<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_address',
        'postal_code',
        'city',
        'invoice_email',
        'vat_number',
        'contact_person',
        'country'
    ];

    public function translationJobs()
    {
        return $this->hasMany(TranslationJob::class);
    }
}
