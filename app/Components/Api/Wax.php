<?php

namespace App\Components\Api;


use App\Traites\Call;

/**
 * Class WAX
 * @package App\Components\Api
 */
class WAX
{
    /**
     * @var null
     */
    private $waxBlock;

    /**
     * @var null
     */
    private $greyMass;

    /**
     * WAX constructor.
     */
    public function __construct()
    {
        $this->waxBlock = new class {
            use Call;
            private $apiUrl = 'https://wax.eosrio.io';
        };

        $this->greyMass = new class {
            use Call;
            private $apiUrl = 'https://wax.greymass.com';
        };
    }

    /**
     * @param array $accounts
     * @param string $dateFrom
     * @param string $dateTo
     * @param int $limit
     * @param int $skip
     * @param string $sort
     * @return array
     */
    public function earnings(array $accounts = [], string $dateFrom = '', string $dateTo = '', int $limit = 200, int $skip = 0, string $sort = 'desc'): array
    {
        $result = [];
        foreach ($accounts as $account) {
            $response = $this->waxBlock->call('v2/history/get_actions', [], [
                'account' => $account,
                'filter' => 'alien.worlds:*',
                'skip' => $skip,
                'limit' => $limit,
                'sort' => $sort,
                'after' => sprintf('%sT00:00:00.000Z', $dateFrom),
                'before' => sprintf('%sT23:59:59.000Z', $dateTo),
            ]);

            $mines = [];
            $total = 0;
            $count = 0;
            foreach ($response['actions'] as $action) {
                if ($action['act']['data']['to'] !== $account || $action['act']['data']['from'] !== 'm.federation') {
                    continue;
                }
                $mines[] = [
                    'timestamp' => $action['timestamp'],
                    'amount' => $action['act']['data']['amount'],
                ];
                $total += $action['act']['data']['amount'];
                $count += 1;
            }

            $result[$account] = [
                'total' => $total,
                'currency' => 'TLM',
                'avg' => $count > 0 ? $total / $count : null,
                'count' => $count,
                'mines' => $mines,
            ];
        }

        return $result;
    }

    /**
     * @param array $accounts
     * @return array
     */
    public function accountsInfo(array $accounts = []): array
    {
        $result = [];
        foreach ($accounts as $account) {
            $response = $this->greyMass->call('v1/chain/get_account', [], [], 'POST', json_encode([
                    'account_name' => $account,
                ]),
                ['Content-Type: application/json']
            );
            $result[$account] = [
                'cpuStaked' => $response['cpu_weight'] / 1e8,
                'cpuUsage' => empty($response['cpu_limit']['max']) ? 0 : $response['cpu_limit']['used'] / $response['cpu_limit']['max'] * 100,
                'waxBalance' =>  (float)$response['core_liquid_balance'],
            ];
            if (!is_null($response['refund_request'])) {
                $result[$account]['refund'] = [
                    'cpu' => (float)$response['refund_request']['cpu_amount'],
                    'net' => (float)$response['refund_request']['net_amount'],
                    'timestamp' => $response['refund_request']['request_time'],
                ];
            }
        }

        return $result;
    }
}