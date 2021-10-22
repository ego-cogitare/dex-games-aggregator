<?php

namespace App\Console\Commands;


use App\Components\Api\AtomicHub;
use App\Models\AlienworldsMining;
use App\Models\Accounts;
use Exception;

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
     * Execute the console command.
     * @return mixed
     * @throws Exception
     */
    public function handle(AtomicHub $atomicHub)
    {
        $delay = $this->option('delay');
        $accounts = Accounts::where('is_active', 1)->get();

        while (true) {
            $date = $this->option('date') ?: date('Y-m-d');
            foreach ($accounts as $account) {
                $item = AlienworldsMining::whereRaw('date = ? AND account = ?', [$date, $account->account]);
                $mines = $atomicHub->earnings([$account->account], $date, $date);
                if ($mines['success'] !== true) {
                    $this->error($mines['message']);
                    continue;
                }
                $data = $mines['message'][0];

                if ($item->count() > 0) {
                    $this->info('update existing record for ' . $account->account);
                    $item->update([
                        'total' => $data->total,
                        'avg' => $data->avg,
                        'count' => $data->count,
                    ]);
                } else {
                    $this->info('add new record for ' . $account->account);
                    AlienworldsMining::create([
                        'account' => $account->account,
                        'total' => $data->total,
                        'avg' => $data->avg,
                        'count' => $data->count,
                        'date' => $date,
                    ]);
                }

                $this->sleep($delay);
            }

            if (!$this->option('worker')) {
                break;
            }
        }
    }
}
