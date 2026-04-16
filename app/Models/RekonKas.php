<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekonKas extends Model
{
    use HasFactory;

    protected $table = 'rekon_kas';

    public const STATUS_MATCH = 'sesuai';
    public const STATUS_LEBIH = 'selisih lebih';
    public const STATUS_KURANG = 'selisih kurang';

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
    ];

    protected static function booted(): void
    {
        static::creating(function (self $rekon) {
            $rekon->calculateTotals();
        });

        static::updating(function (self $rekon) {
            $rekon->calculateTotals();
        });
    }

    public function calculateTotals(): void
    {
        $openingCash     = (int) ($this->opening_cash ?? 0);
        $cashIncome      = (int) ($this->cash_income ?? 0);
        $operationalCash = (int) ($this->operational_cash ?? 0);
        $actualCash      = (int) ($this->actual_cash ?? 0);

        // non_cash_income tidak dihitung ke kas fisik
        $this->cash_expected = ($openingCash + $cashIncome) - $operationalCash;
        $this->difference    = $actualCash - $this->cash_expected;

        if ($this->difference === 0) {
            $this->status = self::STATUS_MATCH;
        } elseif ($this->difference < 0) {
            $this->status = self::STATUS_KURANG;
        } else {
            $this->status = self::STATUS_LEBIH;
        }
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts(): array
    {
        return [
            'rekon_date'       => 'date',
            'opening_cash'     => 'integer',
            'cash_income'      => 'integer',
            'non_cash_income'  => 'integer',
            'operational_cash' => 'integer',
            'cash_expected'    => 'integer',
            'actual_cash'      => 'integer',
            'difference'       => 'integer',
        ];
    }
}