<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_secretary',
        'id_manager',
        'id_company',
        'date',
        'deadline',
        'name',
        'description',
        'status',
        'cost',
    ];

    public function secretary()
    {
        return $this->belongsTo(secretaries::class, 'id_secretary');
    }

    public function manager()
    {
        return $this->belongsTo(managers::class, 'id_manager');
    }

    public function company()
    {
        return $this->belongsTo(companies::class, 'id_company');
    }
    public function products()
    {
        return $this->hasMany(products::class, 'id_order');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            $order->products()->each(function ($product) {
                $product->delete();
            });
        });
    }

}
