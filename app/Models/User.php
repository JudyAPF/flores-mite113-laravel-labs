<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

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
     * 'password' => 'hashed' is why we never call Hash::make() ourselves:
     * assigning a plain string hashes it automatically on save, and
     * Auth::attempt() hashes the submitted password the same way to compare.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // without this cast MySQL hands back the string "0", which is
            // truthy in PHP — every user would look like an admin.
            'is_admin' => 'boolean',
        ];
    }

    /**
     * LAB 4: every student record this user owns.
     * The mirror image of Student::user().
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
