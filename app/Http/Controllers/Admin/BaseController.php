<?php

namespace App\Http\Controllers\Admin;


use App\Components\Api\AtomicHub;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use View;
use App;

/**
 * Class BaseController
 * @package App\Http\Controllers\Admin
 */
class BaseController extends Controller
{
    /**
     * @var AtomicHub|null
     */
    protected $atomicHub = null;

    /**
     * @var null|string[]
     */
    protected $accounts = [];

    /**
     * MarketController constructor.
     * @param AtomicHub $atomicHub
     */
    public function __construct(AtomicHub $atomicHub)
    {
        $this->atomicHub = $atomicHub;
        $accounts = Accounts::get();
        foreach ($accounts as $account) {
            if ($account->is_active === false) {
                continue;
            }
            $this->accounts[$account->account] = $account->wax_session_token;
        }

        /** Share global view market variable */
        View::share('accounts', array_keys($this->accounts));
    }
}
