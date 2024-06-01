<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingredients extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ingredient';

    protected $fillable = [
        'name',
        'safe_amount',
        'unit',
        'safety',
        'added_by',
    ];

    protected $table = 'ingredients';

    public $timestamps = false;

    public function product_ingredients()
{
    return $this->hasMany(product_ingredients::class, 'id_ingredient');
}

protected static function boot()
    {
        parent::boot();

        static::deleting(function ($ingredient) {
            $ingredient->product_ingredients()->update(['id_ingredient' => null]);
        });
    }
}
