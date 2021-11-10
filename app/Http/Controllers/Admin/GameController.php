<?php

namespace App\Http\Controllers\Admin;


use Exception;
use http\Env\Request;
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
        $staked = 0;
        $waxBalance = 0;
        $cpuRefund = 0;
        foreach ($earnings as $earning) {
            $total += $earning->total;
            $count += $earning->count;
            $staked += (float)$earning->cpu_staked;
            $waxBalance += (float)$earning->wax_balance;
            $cpuRefund += (float)$earning->refund_cpu;
            if (is_null($earning->last_mine_at)) {
                $earning->last_mine = '-';
                $earning->time_left = '-';
            } else {
                $earning->last_mine = $earning->last_mine_at;
                $date = \Carbon\Carbon::createFromTimeString($earning->last_mine);
                $earning->last_mine = $date->addHour(2)->format('M j H:i');
                $earning->time_left = \Carbon\Carbon::createFromTimeString($date->subHour(2))->diffForHumans();
            }
            if (!is_null($earning->refund_ts)) {
                $earning->refund_ts = \Carbon\Carbon::createFromTimeString($earning->refund_ts)->addDays(3)->format('M j H:i');
            }
        }

        return view('admin.game.alienworlds', [
            'earnings' => $earnings,
            'total' => $total,
            'count' => $count,
            'avg' => $total / $count,
            'staked' => $staked,
            'waxBalance' => $waxBalance,
            'cpuRefund' => $cpuRefund,
        ]);
    }

    /**
     * @param string $account
     * @return Factory|\Illuminate\Foundation\Application|View
     */
    public function alienworldsPlanet(string $account = '')
    {
        /** Fetch land id by account name */
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json' . PHP_EOL,
                'content' => json_encode([
                    "json" => true,
                    "code" => "m.federation",
                    "scope" => "m.federation",
                    "table" => "miners",
                    "lower_bound" => $account,
                    "upper_bound" => $account,
                    "index_position" => 1,
                    "key_type" => "",
                    "limit" => 10,
                    "reverse" => false,
                    "show_payer" => false
                ]),
            ],
        ]);
        $response = file_get_contents('https://aw-guard.yeomen.ai/v1/chain/get_table_rows', false, $context);
        $data = json_decode($response, true);
        $landId = $data['rows'][0]['current_land'] ?? null;

        /** Load whole lands map */
        $lands = file_get_contents(__DIR__ . '/../../../../resources/land.points.json');
        $lands = json_decode($lands, true);

        /** Get land parameters */
        $response = file_get_contents('https://wax.api.atomicassets.io/atomicassets/v1/assets?page=1&limit=100&asset_id=' . $landId);
        $landParams = json_decode($response, true)['data'][0]['data'];

        return view('admin.game.alienworldsLand', [
            'account' => $account,
            'landId' => $landId,
            'landInfo' => array_merge($landParams, $lands[$landId]),
        ]);
    }
}
