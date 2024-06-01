<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secretaries extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_secretary';

    protected $fillable = [
        'id_employee',
    ];

    protected $table = 'secretaries';

    public function employee()
    {
        return $this->belongsTo(employees::class, 'id_employee', 'id_employee');
    }
}
