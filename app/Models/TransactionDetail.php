<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'harga',
        'subtotal'
    ];
    
    protected $casts = [
        'qty' => 'integer',
        'harga' => 'integer',
        'subtotal' => 'integer'
    ];
    
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}