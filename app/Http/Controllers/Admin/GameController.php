<?php

namespace App\Http\Controllers\Admin;


use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use App\Models\AlienworldsMining;

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
        $date = request()->input('date', date('Y-m-d'));
        $accounts = request()->input('account', array_keys($this->accounts));
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }

        $earnings = AlienworldsMining::where('date', $date)
            ->whereIn('account', $accounts)
            ->orderBy('total', 'desc')
            ->get();

        $total = 0;
        $count = 0;
        foreach ($earnings as $earning) {
            $total += $earning->total;
            $count += $earning->count;
        }

        return view('admin.game.alienworlds', [
            'earnings' => $earnings,
            'total' => $total,
            'count' => $count,
        ]);
    }
}