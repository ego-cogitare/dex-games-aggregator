<?php

namespace App\Http\Controllers\Admin;


use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class GameController
 * @package App\Http\Controllers\Admin
 */
class GameController extends BaseController
{
    /**
     * @return Factory|View
     * @throws Exception
     */
    public function alienworlds()
    {
        $from = request()->input('from', date('Y-m-d'));
        $to = request()->input('to', date('Y-m-d'));
        $accounts = request()->input('account', array_keys($this->accounts));
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $data = $this->atomicHub->earnings($accounts, $from, $to);
        dd($data);

        usort($balances, function($a, $b) {
            return $a['amount'] < $b['amount'] ? 1 : -1;
        });

        return view('admin.game.alienworlds', [
//            'balances' => $balances,
//            'total' => $total,
//            'prices' => $this->prices,
        ]);
    }
}
