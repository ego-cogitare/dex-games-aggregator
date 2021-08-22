<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Arbitrage
 * @package App\Models
 */
class Accounts extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'account',
        'wax_session_token',
        'is_active',
    ];

    /**
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @var bool
     */
    public $timestamps = false;
}
