<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_DOCTOR = 'doctor';
    const ROLE_PATIENT = 'patient';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'age'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDoctor()
    {
        return $this->role === self::ROLE_DOCTOR;
    }

    public function isPatient()
    {
        return $this->role === self::ROLE_PATIENT;
    }
    public function medicalInfos()
    {
        return $this->hasMany(MedicalInfo::class, 'patient_id');
    }
//     public function appointments()
// {
//     return $this->hasMany(Appointment::class, 'doctor_id');
// }

public function appointments()
{
    return $this->hasMany(Appointment::class, 'patient_id');
}


}

