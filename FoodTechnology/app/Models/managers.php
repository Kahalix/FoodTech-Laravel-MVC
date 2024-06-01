<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managers extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_manager';

    protected $fillable = [
        'id_employee',
    ];

    protected $table = 'managers';

    public $timestamps = false;


    public function employee()
    {
        return $this->belongsTo(employees::class, 'id_employee');
    }
   public function food_technologists()
   {
       return $this->hasMany(managers::class, 'id_manager');
   }
   public function orders(){
       return $this->hasMany(orders::class, 'id_manager');
   }

   protected static function boot()
    {
        parent::boot();

        static::deleting(function ($manager) {
            $manager->food_technologists()->update(['id_manager' => null]);
            $manager->orders()->update(['id_manager' => null]);
        });
    }
}
