<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_ingredients extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product_ingredient';

    protected $fillable = [
        'id_product',
        'id_ingredient',
        'name',
        'ingredient_amount',
        'unit',
        'completed_by',
    ];

    protected $table = 'product_ingredients';

    public function product()
    {
        return $this->belongsTo(products::class, 'id_product');
    }

    public function ingredient()
{
    return $this->belongsTo(ingredients::class, 'id_ingredient');
}

}
