<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionItem;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transactionItems() 
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    
}