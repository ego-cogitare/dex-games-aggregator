<?php

namespace App\Console\Commands;


use App\Components\Api\WAX;
use App\Models\AlienworldsMining;
use App\Models\Accounts;
use App\Models\AlienworldsMiningHistory;
use Carbon\Carbon;
use Exception;
use Log;

/**
 * Class TestCommand
 * @package App\Console\Commands
 */
class AlienworldsStatistic extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'alienworlds:statistic {--worker} {--delay=30} {--date=}';

    /**
     * @param WAX $wax
     */
    public function handle(WAX $wax)
    {
        $delay = $this->option('delay');
        $accounts = Accounts::where('is_active', 1)->get();

        while (true) {
            $date = $this->option('date') ?: date('Y-m-d');
            foreach ($accounts as $account) {
                try {
                    $this->info($account->account);
                    $item = AlienworldsMining::whereRaw('date = ? AND account = ?', [$date, $account->account]);

                    /** Fetch mine history */
                    $mines = $wax->earnings([$account->account], $date, $date);

                    if (empty($mines[$account->account])) {
                        continue;
                    }
                    $data = $mines[$account->account];

                    /** Fetch account info */
                    $accountInfo = $wax->accountsInfo([$account->account]);
                    $lastMine = $data['mines'][0]['timestamp'] ?? null;

                    $dbData = [
                        'account' => $account->account,
                        'total' => $data['total'],
                        'avg' => $data['avg'],
                        'count' => $data['count'],
                        'date' => $date,
                        'updated_at' => Carbon::now(),
                        'wax_balance' => $accountInfo[$account->account]['waxBalance'],
                        'cpu_usage' => $accountInfo[$account->account]['cpuUsage'],
                        'cpu_staked' => $accountInfo[$account->account]['cpuStaked'],
                        'last_mine_at' => is_null($lastMine) ? null : Carbon::createFromTimeString($lastMine),
                        'refund_cpu' => $accountInfo[$account->account]['refund']['cpu'] ?? null,
                        'refund_net' => $accountInfo[$account->account]['refund']['net'] ?? null,
                        'refund_ts' => $accountInfo[$account->account]['refund']['timestamp'] ?? null,
                    ];
                    if ($item->count() > 0) {
                        $this->info('update existing record for ' . $account->account);
                        $item->update($dbData);
                    } else {
                        $this->info('add new record for ' . $account->account);
                        AlienworldsMining::create($dbData);
                    }

                    if (!empty($data['mines'])) {
                        Log::info('update mining history');
                        foreach ($data['mines'] as $mine) {
                            $entity = [
                                'account' => $account->account,
                                'timestamp' => Carbon::createFromTimeString($mine['timestamp']),
                                'amount' => $mine['amount'],
                            ];

                            /** @var AlienworldsMiningHistory $item */
                            $item = AlienworldsMiningHistory::whereRaw('account = ? AND timestamp = ?', [$account->account, $entity['timestamp']]);

                            /** Update existing or create new record */
                            if ($item->count() === 0) {
                                AlienworldsMiningHistory::create($entity);
                            }
                        }
                    }
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }

                $this->sleep($delay);
            }

            if (!$this->option('worker')) {
                break;
            }
        }
    }
}
