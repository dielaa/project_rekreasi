<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';
    protected $primaryKey = 'no';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['no', 'user_id', 'promo_id', 'total', 'promo', 'sub_total', 'payment_id', 'attachment'];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'no_transaction', 'no');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }

}
