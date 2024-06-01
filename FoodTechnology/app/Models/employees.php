<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class employees extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = 'employees';

    protected $primaryKey = 'id_employee';

    protected $fillable = [
        'first_name',
        'last_name',
        'employee_image',
        'position',
        'email',
        'phone_number',
        'login',
        'password',
        'status',
    ];
public function getAuthIdentifierName()
{
    return 'id_employee';
}

public function getAuthIdentifier()
{
    return $this->getKey();
}

public function getAuthPasswordName()
{
    return 'password';
}

public function getAuthPassword()
{
    return $this->password;
}

public function getRememberToken()
{
    return $this->remember_token;
}

public function setRememberToken($value)
{
    $this->remember_token = $value;
}

public function getRememberTokenName()
{
    return 'remember_token';
}
    public function managers()
    {
        return $this->hasOne(managers::class, 'id_employee');
    }
    public function food_technologists()
    {
        return $this->hasOne(food_technologists::class, 'id_employee');
    }

    public function secretaries()
    {
        return $this->hasOne(secretaries::class, 'id_employee');
    }
    public function administrators(){
        return $this->hasOne(administrators::class, 'id_employee');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employees) {
            $employees->food_technologists()->delete();

            $employees->secretaries()->delete();

            $employees->managers()->delete();
        });
    }
}
