<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'entry_time',
        'exit_time',
        'purpose',
        'attendance_date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
