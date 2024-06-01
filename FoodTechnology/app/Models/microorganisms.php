<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class microorganisms extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_microorganism';


    protected $fillable = [
        'name',
        'type',
        'safe_amount',
        'unit',
        'safety',
        'added_by',
    ];

    protected $table = 'microorganisms';

    public $timestamps = false;

  public function product_microorganisms()
    {
        return $this->hasMany(product_microorganisms::class, 'id_microorganism');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($microorganism) {
            $microorganism->product_microorganisms()->update(['id_microorganism' => null]);
        });
    }
}
