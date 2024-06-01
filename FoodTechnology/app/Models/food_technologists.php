<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class food_technologists extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_food_technologist';

    protected $fillable = [
        'id_employee',
        'id_manager',
    ];

    protected $table = 'food_technologists';

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(employees::class, 'id_employee');
    }

    public function manager()
    {
        return $this->belongsTo(managers::class, 'id_manager');
    }
    public function products()
    {
        return $this->hasMany(products::class, 'id_food_technologist');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($foodtechnologist) {
            $foodtechnologist->products()->update(['id_food_technologist' => null]);
        });
    }
}
