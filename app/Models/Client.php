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

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the ISO country code for flag display
     * Returns the 2-letter ISO country code if country matches supported countries
     */
    public function getCountryFlagCode(): ?string
    {
        $countryMappings = [
            // EEA/EU Major Countries
            'germany' => 'de',
            'deutschland' => 'de',
            'allemagne' => 'de',
            'duitsland' => 'de',
            'france' => 'fr',
            'frankreich' => 'fr',
            'frankrijk' => 'fr',
            'italy' => 'it',
            'italien' => 'it',
            'italie' => 'it',
            'italië' => 'it',
            'italia' => 'it',
            'spain' => 'es',
            'spanien' => 'es',
            'espagne' => 'es',
            'spanje' => 'es',
            'españa' => 'es',
            'netherlands' => 'nl',
            'niederlande' => 'nl',
            'pays-bas' => 'nl',
            'nederland' => 'nl',
            'belgium' => 'be',
            'belgien' => 'be',
            'belgique' => 'be',
            'belgië' => 'be',
            'austria' => 'at',
            'österreich' => 'at',
            'autriche' => 'at',
            'oostenrijk' => 'at',
            'sweden' => 'se',
            'schweden' => 'se',
            'suède' => 'se',
            'zweden' => 'se',
            'sverige' => 'se',
            'denmark' => 'dk',
            'dänemark' => 'dk',
            'danemark' => 'dk',
            'denemarken' => 'dk',
            'danmark' => 'dk',
            'finland' => 'fi',
            'finnland' => 'fi',
            'finlande' => 'fi',
            'suomi' => 'fi',
            'poland' => 'pl',
            'polen' => 'pl',
            'pologne' => 'pl',
            'polska' => 'pl',
            'portugal' => 'pt',
            'portogallo' => 'pt',
            'greece' => 'gr',
            'griechenland' => 'gr',
            'grèce' => 'gr',
            'griekenland' => 'gr',
            'ελλάδα' => 'gr',
            'ireland' => 'ie',
            'irland' => 'ie',
            'irlande' => 'ie',
            'ierland' => 'ie',
            'éire' => 'ie',
            'czech republic' => 'cz',
            'czechia' => 'cz',
            'tschechien' => 'cz',
            'république tchèque' => 'cz',
            'tsjechië' => 'cz',
            'česko' => 'cz',
            'hungary' => 'hu',
            'ungarn' => 'hu',
            'hongrie' => 'hu',
            'hongarije' => 'hu',
            'magyarország' => 'hu',
            'romania' => 'ro',
            'rumänien' => 'ro',
            'roumanie' => 'ro',
            'roemenië' => 'ro',
            'românia' => 'ro',
            'croatia' => 'hr',
            'kroatien' => 'hr',
            'croatie' => 'hr',
            'kroatië' => 'hr',
            'hrvatska' => 'hr',
            'luxembourg' => 'lu',
            'luxemburg' => 'lu',
            'lussemburgo' => 'lu',
            'norway' => 'no',
            'norwegen' => 'no',
            'norvège' => 'no',
            'noorwegen' => 'no',
            'norge' => 'no',
            'iceland' => 'is',
            'island' => 'is',
            'islande' => 'is',
            'ijsland' => 'is',
            'ísland' => 'is',

            // Major Non-EU Countries
            'united states' => 'us',
            'usa' => 'us',
            'vereinigte staaten' => 'us',
            'états-unis' => 'us',
            'verenigde staten' => 'us',
            'united kingdom' => 'gb',
            'uk' => 'gb',
            'britain' => 'gb',
            'großbritannien' => 'gb',
            'royaume-uni' => 'gb',
            'verenigd koninkrijk' => 'gb',
            'australia' => 'au',
            'australien' => 'au',
            'australie' => 'au',
            'australië' => 'au',
            'japan' => 'jp',
            'japon' => 'jp',
            'giappone' => 'jp',
            '日本' => 'jp',
            'canada' => 'ca',
            'kanada' => 'ca',
            'switzerland' => 'ch',
            'schweiz' => 'ch',
            'suisse' => 'ch',
            'zwitserland' => 'ch',
        ];

        $country = strtolower(trim($this->country));
        return $countryMappings[$country] ?? null;
    }
}
