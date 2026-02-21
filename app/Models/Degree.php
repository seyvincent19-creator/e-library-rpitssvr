<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = [
        'majors',
        'duration_years',
        'study_time',
        'degree_level',
        'generation',
    ];

    protected $appends = [
        'majors_formatted',
        'generation_text'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }


       // ចង់ save fullname ជា lowercase → ប្រើ Mutator setFullnameAttribute
   public function setmajorsAttribute($value)
   {
       $this->attributes['majors'] = strtolower($value);
   }

   // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getFullnameFormattedAttribute
   public function getmajorsFormattedAttribute()
   {
       return ucwords($this->majors);
   }





     // 👇 Accessor សម្រាប់បង្ហាញ Generation ជាភាសាខ្មែរ
     public function getgenerationTextAttribute()
     {
         return [
             'generation 1' => 'ជំនាន់ទី ១',
             'generation 2' => 'ជំនាន់ទី ២',
             'generation 3' => 'ជំនាន់ទី ៣',
             'generation 4' => 'ជំនាន់ទី ៤',
             'generation 5' => 'ជំនាន់ទី ៥',
             'generation 6' => 'ជំនាន់ទី ៦',
             'generation 7' => 'ជំនាន់ទី ៧',
             'generation 8' => 'ជំនាន់ទី ៨',
             'generation 9' => 'ជំនាន់ទី ៩',
             'generation 10' => 'ជំនាន់ទី ១០',
             'generation 11' => 'ជំនាន់ទី ១១',
             'generation 12' => 'ជំនាន់ទី ១២',
         ][$this->generation] ?? $this->generation;
     }






}
