<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    
    protected $fillable = [
        'invoice_number',
        'kasir_id',
        'customer_name',
        'payment_method',
        'total',
        'diskon',
        'discount_percent',
        'grand_total',
        'bayar',
        'kembalian',
        'metode_pembayaran'
    ];
    
    protected $casts = [
        'total' => 'integer',
        'diskon' => 'integer',
        'discount_percent' => 'integer',
        'grand_total' => 'integer',
        'bayar' => 'integer',
        'kembalian' => 'integer',
    ];
    
    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
    
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}