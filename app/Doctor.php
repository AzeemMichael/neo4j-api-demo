<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Vinelab\NeoEloquent\Eloquent\Relations\MorphMany;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Doctor extends NeoEloquent implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $label = 'Doctor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password', 'npi', 'speciality_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The appointments with clients
     * @return MorphMany
     */
    public function appointments() : MorphMany
    {
        return $this->morphMany(Appointment::class, 'WITH');
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
