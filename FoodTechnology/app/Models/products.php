<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product'; // Ustawienie klucza głównego

    // Kolumny, które można uzupełniać masowo
    protected $fillable = [
        'id_order',
        'id_food_technologist',
        'name',
        'status',
        'product_image',
    ];

    protected $table = 'products';


    public function order()
    {
        return $this->belongsTo(orders::class, 'id_order');
    }
    public function foodTechnologist()
    {
        return $this->belongsTo(food_technologists::class, 'id_food_technologist');
    }
    public function product_ingredients() {
        return $this->hasMany(product_ingredients::class, 'id_product');
    }
    public function product_microorganisms() {
        return $this->hasMany(product_microorganisms::class, 'id_product');
    }
    public function test_result() {
        return $this->hasOne(test_results::class, 'id_product');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($product) {
            $order = $product->order;
            if ($order) {
                $completedProductsCount = $order->products()->where('status', 'completed')->count();
                $totalProductsCount = $order->products()->count();
                if ($completedProductsCount === $totalProductsCount) {
                    $order->status = 'completed';
                    $order->save();
                }
                // else {
                //     $order->status = 'assigned';
                //     $order->save();
                // }
            }



        });
        static::deleting(function ($product) {
            $product->product_ingredients()->each(function ($productIngredient) {
                $productIngredient->delete();
            });

            $product->product_microorganisms()->each(function ($productMicroorganism) {
                $productMicroorganism->delete();
            });

            $testResult = $product->test_result;
            if ($testResult) {
                $testResult->delete();
            }
        });
    }
}
