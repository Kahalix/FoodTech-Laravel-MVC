<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class product_microorganisms extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product_microorganism';


    protected $fillable = [
        'id_product',
        'id_microorganism',
        'name',
        'type',
        'amount',
        'unit',
        'completed_by',
    ];

    protected $table = 'product_microorganisms';

    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(products::class, 'id_product');
    }

    public function microorganism()
    {
        return $this->belongsTo(microorganisms::class, 'id_microorganism');
    }


}
