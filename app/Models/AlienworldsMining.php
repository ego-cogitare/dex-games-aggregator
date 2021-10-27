<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Arbitrage
 * @package App\Models
 */
class AlienworldsMining extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'account',
        'total',
        'avg',
        'count',
        'date',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $table = 'alienworlds_minings';

    /**
     * @var bool
     */
    public $timestamps = false;
}
