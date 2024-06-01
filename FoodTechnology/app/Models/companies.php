<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_company';

    public $timestamps = false;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'nip',
        'address',
        'postal_code',
        'city',
        'phone_number',
        'email',
    ];

    public function orders()
    {
        return $this->hasMany(orders::class, 'id_company');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($company) {
            $company->orders()->each(function ($order) {
                $order->delete();
            });
        });
    }
}
