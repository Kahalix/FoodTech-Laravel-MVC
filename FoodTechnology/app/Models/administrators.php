<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrators extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_administrator';

    protected $fillable = [
        'id_employee',
    ];

    protected $table = 'administrators';

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(employees::class, 'id_employee');
    }
}
