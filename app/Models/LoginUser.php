<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginUser extends Authenticatable
{
    use HasRoles;
    protected $connection = 'login';
    protected $table = 'users';

    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];
    protected $guard_name = 'login';

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ', 2)
            ->map(fn(string $name) => Str::of($name)->substr(0, 1)->upper())
            ->implode('');
    }
}
