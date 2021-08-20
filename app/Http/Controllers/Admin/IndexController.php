<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

/**
 * Class IndexController
 * @package App\Http\Controllers\Admin
 */
class IndexController extends BaseController
{
    /**
     * @var null|string[]
     */
    private $accounts = [
        "qdyek.wam",
        "jwpeg.wam",
        "jhque.wam",
        "zc4ey.wam",
        "mjqfm.wam",
        "z4jfo.wam",
        "11nfo.wam",
        "tjnvq.wam",
        "4rovq.wam",
        "z1jfu.wam",

        "wmptw.wam",
    ];

    /**
     * @return Factory|View
     * @throws Exception
     */
    public function history()
    {
        $accounts = request()->input('account', $this->accounts);
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $history = $this->atomicHub->fetchHistory(date('Y-m-d'), $accounts);

        return view('admin.history', [
            'history' => $history,
        ]);
    }

    /**
     * @return Factory|View
     * @throws Exception
     */
    public function pending()
    {
        $accounts = request()->input('account', $this->accounts);
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $data = $this->atomicHub->fetchPendingOrders($accounts);

        return view('admin.pending', [
            'data' => $data,
        ]);
    }

    /**
     * @return Factory|View
     * @throws Exception
     */
    public function staff()
    {
        $accounts = request()->input('account', $this->accounts);
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $collection = request()->input('collection', 'alienshipsio');
        $schema = request()->input('schema', 'addons');
        $match = request()->input('match', 'AUTOPILOT');

        $staffs = $this->atomicHub->fetchStaff($accounts, $collection, $schema, $match);
        uasort($staffs, function($a, $b) {
            $a = (array)$a;
            $b = (array)$b;
            return array_sum(array_values($a)) > array_sum(array_values($b)) ? -1 : 1;
        });

        $result = [];
        foreach ($staffs as $account => &$staff) {
            $staff = (array)$staff;
            if (count($staff) === 0) {
                continue;
            }
            uasort($staff, function($a, $b) {
                return $a > $b ? -1 : 1;
            });
            $result[] = [
                'account'=> $account,
                'staff' => $staff,
            ];
        }

        return view('admin.staff', [
            'staff' => $result,
        ]);
    }

    /**
     * @return Factory|View
     * @throws Exception
     */
    public function balances()
    {
        $accounts = request()->input('account', $this->accounts);
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $balances = [];
        $total = [];
        foreach ($accounts as $account) {
            $json = file_get_contents('https://lightapi.eosamsterdam.net/api/balances/wax/' . $account);
            $data = json_decode($json);
            foreach ($data->balances as $item) {
                $balances[] = [
                    'account' => $account,
                    'currency' => $item->currency,
                    'amount' => (float)$item->amount,
                ];
                if (empty($total[$item->currency])) {
                    $total[$item->currency] = 0;
                }
                $total[$item->currency] += (float)$item->amount;
            }
        }
        usort($balances, function($a, $b) {
            return $a['amount'] < $b['amount'] ? 1 : -1;
        });

        return view('admin.balances', [
            'balances' => $balances,
            'total' => $total,
        ]);
    }
}
