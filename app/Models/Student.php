<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
      protected $fillable = [
        'student_code',
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'enroll_year',
        'degree_id',
        'address',
        'image',
        'status',
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }









    public function setPhoneAttribute($value)
    {
        // remove space before save
        $this->attributes['phone'] = preg_replace('/\s+/', '', $value);
    }

    public function getPhoneFormattedAttribute()
    {
        $number = $this->phone; // e.g. 0882942181


        // Format: 3 3 4
        return substr($number, 0, 3) . ' ' .
            substr($number, 3, 3) . ' ' .
            substr($number, 6);
    }


    // ចង់ save student_code ជា lowercase → ប្រើ Mutator setstudent_codeAttribute
    public function setstudentcodeAttribute($value)
    {
        $this->attributes['student_code'] = strtolower($value);
    }

    // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getstudent_codeFormattedAttribute
    public function getstudentcodeFormattedAttribute()
    {
        return ucwords($this->student_code);
    }


    // ចង់ save full_name ជា lowercase → ប្រើ Mutator setfull_nameAttribute
    public function setfullnameAttribute($value)
    {
        $this->attributes['full_name'] = strtolower($value);
    }

    // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getfull_nameFormattedAttribute
    public function getfullnameFormattedAttribute()
    {
        return ucwords($this->full_name);
    }




    // ចង់ save address ជា lowercase → ប្រើ Mutator setaddressAttribute
    public function setaddressAttribute($value)
    {
        $this->attributes['address'] = strtolower($value);
    }

    // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getaddressFormattedAttribute
    public function getaddressFormattedAttribute()
    {
        return ucwords($this->address);
    }

    // ចង់ save status ជា lowercase → ប្រើ Mutator setstatusAttribute
    public function setstatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getstatusFormattedAttribute
    public function getstatusFormattedAttribute()
    {
        return ucwords($this->status);
    }




    public function getimageUrlAttribute()
    {
        return $this->image
            ? Storage::disk(config('filesystems.default'))->url($this->image)
            : asset('assets/images/default-avatar.png');
    }




}
