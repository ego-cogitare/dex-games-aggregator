<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Arbitrage
 * @package App\Models
 */
class AlienworldsMiningHistory extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'account',
        'timestamp',
        'amount',
    ];

    /**
     * @var string
     */
    protected $table = 'alienworlds_minings_history';

    /**
     * @var string[]
     */
    protected $primaryKey = 'account,timestamp';

    /**
     * @var bool
     */
    public $timestamps = false;
}
