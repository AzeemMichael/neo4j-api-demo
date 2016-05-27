<?php

namespace App;

use Carbon\Carbon;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use Vinelab\NeoEloquent\Eloquent\Relations\HyperMorph;

class Patient extends NeoEloquent
{
    protected  $label = 'Patient';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
    ];

    /**
     * The appointments the patient has made with the doctors
     * @param NeoEloquent $morph
     * @return HyperMorph
     */
    public function appointments(NeoEloquent $morph = null) : HyperMorph
    {
        return $this->hyperMorph($morph, Appointment::class, 'APPOINTMENT', 'WITH');
    }

    /**
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute(string $value) : string
    {
        return Carbon::parse($value)->toIso8601String();
    }
    /**
     * @param string $value
     * @return string
     */
    public function getUpdatedAtAttribute(string $value) : string
    {
        return Carbon::parse($value)->toIso8601String();
    }
}