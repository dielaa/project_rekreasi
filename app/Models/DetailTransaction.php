<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaction extends Model
{
    use SoftDeletes;
    protected $table = 'detail_transactions';
    protected $fillable = ['no_transaction', 'ticket_id', 'date', 'qty'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    
}
