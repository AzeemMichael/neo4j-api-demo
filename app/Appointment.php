<?php

namespace App;

use Carbon\Carbon;
use Vinelab\NeoEloquent\Eloquent\Model  as NeoEloquent;
use Vinelab\NeoEloquent\Eloquent\Relations\{BelongsTo, MorphTo};

/**
 * Class Appointment
 * @package App
 */
class Appointment extends NeoEloquent
{
    /**
     * @var string
     */
    protected $label = 'Appointment';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get patient the appointment belongs to.
     * @return BelongsTo
     */
    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class, 'APPOINTMENT');
    }

    /**
     * Get doctor with whom user made the appointment appointment.
     * @return MorphTo
     */
    public function doctor() : MorphTo
    {
        return $this->morphTo(Doctor::class, 'WITH');
    }

    /**
     * @param string $value
     * @return string
     */
    public function getAtAttribute(string $value) : string
    {
        return Carbon::parse($value)->toIso8601String();
    }
}
