<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class result_images extends Model
{
    use HasFactory;

    protected $table = 'result_images';

    public $timestamps = false;

    protected $primaryKey = 'id_result_image';

    protected $fillable = ['image_path', 'id_test_result'];

    public function testResult()
    {
        return $this->belongsTo(test_results::class, 'id_test_result');
    }
}
