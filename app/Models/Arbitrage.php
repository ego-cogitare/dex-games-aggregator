<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Arbitrage
 * @package App\Models
 */
class Arbitrage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'triplet',
        'stock_id',
        'profit',
        'profit_quote',
        'bet',
        'notify',
    ];

    /**
     * @var string
     */
    protected $table = 'arbitrage';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
