<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lecturer extends Model
{
    protected $fillable = [
        'lecturer_code',
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'enroll_year',
        'department',
        'address',
        'image',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ─── Mutators (save as lowercase) ───────────────────────────────────────────

    public function setLecturerCodeAttribute($value)
    {
        $this->attributes['lecturer_code'] = strtolower($value);
    }

    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = strtolower($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = strtolower($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\s+/', '', $value);
    }

    // ─── Accessors (display as Title Case) ──────────────────────────────────────

    public function getLecturercodeFormattedAttribute()
    {
        return ucwords($this->lecturer_code);
    }

    public function getFullnameFormattedAttribute()
    {
        return ucwords($this->full_name);
    }

    public function getAddressFormattedAttribute()
    {
        return ucwords($this->address);
    }

    public function getStatusFormattedAttribute()
    {
        return ucwords($this->status);
    }

    public function getPhoneFormattedAttribute()
    {
        $number = $this->phone;
        return substr($number, 0, 3) . ' ' . substr($number, 3, 3) . ' ' . substr($number, 6);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk(config('filesystems.default'))->url($this->image)
            : asset('assets/images/default-avatar.png');
    }
}
