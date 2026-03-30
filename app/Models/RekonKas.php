<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekonKas extends Model
{
    use HasFactory;

    // Nama tabel jika tidak jamak (optional, tapi aman untuk pemula)
    protected $table = 'rekon_kas';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'rekon_date',
        'opening_cash',
        'cash_income',
        'non_cash_income',
        'operational_cash',
        'cash_expected',
        'actual_cash',
        'difference',
        'status',
        'notes',
        'created_by'
    ];

    /**
     * Boot function untuk menghitung otomatis sebelum data disimpan.
     * Ini mencegah manipulasi angka selisih oleh user/karyawan.
     */
    protected static function booted()
    {
        static::creating(function ($rekon) {
            $rekon->calculateTotals();
        });

        static::updating(function ($rekon) {
            $rekon->calculateTotals();
        });
    }

    /**
     * Logika Kalkulator Rekonsiliasi
     */
    public function calculateTotals()
    {
        // 1. Hitung Saldo Seharusnya
        $this->cash_expected = ($this->opening_cash + $this->cash_income) - $this->operational_cash;

        // 2. Hitung Selisih
        $this->difference = $this->actual_cash - $this->cash_expected;

        // 3. Tentukan Status
        if ($this->difference == 0) {
            $this->status = 'match';
        } elseif ($this->difference < 0) {
            $this->status = 'selisih kurang';
        } else {
            $this->status = 'selisih lebih';
        }
    }

    /**
     * Relasi ke User (Siapa yang membuat rekon ini)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $casts = [
    'opening_cash' => 'float',
    'cash_income' => 'float',
    'non_cash_income' => 'float',
    'operational_cash' => 'float',
    'cash_expected' => 'float',
    'actual_cash' => 'float',
    'difference' => 'float',
    'rekon_date' => 'date',
    ];
}