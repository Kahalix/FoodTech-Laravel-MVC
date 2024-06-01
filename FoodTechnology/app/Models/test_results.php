<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class test_results extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_test_result';

    protected $fillable = [
        'id_product',
        'test_results',
        'decision',
    ];

    protected $table = 'test_results';


    public function product()
    {
        return $this->belongsTo(orders::class, 'id_product');
    }
    public function resultImages()
    {
        return $this->hasMany(result_images::class, 'id_test_result');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($testResult) {
            $testResult->resultImages()->each(function ($resultImage) {
                $resultImage->delete();
            });
        });
    }
}
