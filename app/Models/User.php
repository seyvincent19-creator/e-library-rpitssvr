<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'code_member',
        'student_id',
        'lecturer_id',
        'name',
        'email',
        'password',
        'role',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }


    public function borrowBooks()
    {
        return $this->hasMany(BorrowBook::class);
    }




    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            // Auto generate CM0001 …
            $user->code_member = 'CM' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            $user->save();
        });
    }


     // ចង់ save name ជា lowercase → ប្រើ Mutator setnameAttribute
        public function setnameAttribute($value)
        {
            $this->attributes['name'] = strtolower($value);
        }

        // ចង់បង្ហាញលើ view ជា Title Case → ប្រើ Accessor getnameFormattedAttribute
        public function getnameFormattedAttribute()
        {
            return ucwords($this->name);
        }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
