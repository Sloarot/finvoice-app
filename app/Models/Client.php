<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'company', 'vat_number'];

    public function translationJobs()
    {
        return $this->hasMany(TranslationJob::class);
    }
}
