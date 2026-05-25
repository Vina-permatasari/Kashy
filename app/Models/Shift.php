<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $table = 'shifts';
    
    protected $fillable = [
        'kasir_id',
        'saldo_awal',
        'saldo_akhir',
        'total_penjualan',
        'status',
        'waktu_buka',
        'waktu_tutup'
    ];
    
    protected $casts = [
        'waktu_buka' => 'datetime',
        'waktu_tutup' => 'datetime',
        'saldo_awal' => 'integer',
        'saldo_akhir' => 'integer',
        'total_penjualan' => 'integer'
    ];
    
    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
}