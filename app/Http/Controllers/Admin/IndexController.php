<?php

namespace App\Http\Controllers\Admin;


use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class IndexController
 * @package App\Http\Controllers\Admin
 */
class IndexController extends BaseController
{
    private $prices = [
        'WAX' => 0.1824,
        'TLM' => 0.2794,
    ];

    /**
     * @return Factory|View
     * @throws Exception
     */
    public function history()
    {
        $accounts = request()->input('account', array_keys($this->accounts));
        $date = request()->input('date', date('Y-m-d'));
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $history = $this->atomicHub->fetchHistory($date, $accounts);

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
        $accounts = request()->input('account', array_keys($this->accounts));
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
        $accounts = request()->input('account', array_keys($this->accounts));
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
        $accounts = request()->input('account', array_keys($this->accounts));
        if (is_string($accounts)) {
            $accounts = [$accounts];
        }
        $currency = request()->input('currency');
        $balances = [];
        $total = [];
        foreach ($accounts as $account) {
            $json = file_get_contents('https://lightapi.eosamsterdam.net/api/balances/wax/' . $account);
            $data = json_decode($json);
            foreach ($data->balances as $item) {
                if ($currency !== null && $item->currency !== $currency) {
                    continue;
                }
                $balances[] = [
                    'account' => $account,
                    'currency' => $item->currency,
                    'amount' => (float)$item->amount,
                    'estUSD' => $item->amount * ($this->prices[$item->currency] ?? 0),
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
            'prices' => $this->prices,
        ]);
    }

    /**
     * @param string $account
     */
    public function atomichub(string $account = '')
    {
        $this->atomicHub->open($this->accounts[$account]);
        return view('admin.atomichub');
    }
}
