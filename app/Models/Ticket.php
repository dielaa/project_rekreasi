<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'name',
       'thumbnail',
       'description',
       'price',
       'promo_id',
       'start_date',
       'end_date',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
    
}
