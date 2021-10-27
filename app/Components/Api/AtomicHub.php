<?php

namespace App\Components\Api;


use App\Traites\Call;
use stdClass;

/**
 * Class AtomicHub
 * @package App\Components\Api
 */
class AtomicHub
{
    use Call;

    /**
     * @var null|string
     */
    private $apiUrl = null;

    /**
     * @var string[][]
     */
    private $search = [
        [
            'schema_name' => 'addons',
            'match' => 'AUTOPILOT P1',
        ],
        [
            'schema_name' => 'addons',
            'match' => 'AUTOPILOT P3',
        ],
        [
            'schema_name' => 'addons',
            'match' => 'AUTOPILOT P4',
        ],
//        [
//            'schema_name' => 'alienships',
//            'match' => 'S : A1',
//        ],
    ];

    /**
     * AtomicHub constructor.
     * @param string $apiUrl
     * @param string $auth
     */
    public function __construct(string $apiUrl = '', string $auth = '') {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param string $date
     * @param array $accounts
     * @return array
     */
    public function fetchHistory(string $date = '', array $accounts = []): array {
        $payload = json_encode([
            'accounts' => $accounts,
            'collectionName' => 'alienshipsio',
            'search' => $this->search,
        ]);
        $history = $this->call('history', [], [], 'POST', $payload, ['content-type: application/json']);

        return empty($history->calendar->{$date}) ? [
            'details' => [],
            'amount' => 0,
            'wax' => 0,
        ] : (array)$history->calendar->{$date};
    }

    /**
     * @param array $accounts
     * @return array
     */
    public function fetchPendingOrders(array $accounts = []): array {
        $payload = json_encode([
            'accounts' => $accounts,
            'collectionName' => 'alienshipsio',
            'search' => $this->search,
        ]);
        $orders = $this->call('pending', [], [], 'POST', $payload, ['content-type: application/json']);
        $result = [];
        $amount = 0;
        $wax = 0;

        foreach ($orders->calendar as $date => $info) {
            $amount += $info->amount;
            $wax += $info->wax;
            foreach ($info->details as $order) {
                $result[] = $order;
            }
        }

        return [
            'orders' => $result,
            'amount' => $amount,
            'wax' => $wax,
        ];
    }

    /**
     * @param array $accounts
     * @param string $collectionName
     * @param string $schemaName
     * @param string $match
     * @return array
     */
    public function fetchStaff(array $accounts = [], string $collectionName = '', string $schemaName = '', string $match = ''): array {
        $payload = json_encode([
            'accounts' => $accounts,
            'filter' => [
                'schema_name' => $schemaName,
                'match' => $match,
                'collection_name' => $collectionName,
                'page' => 1,
                'limit' => 500,
            ],
        ]);
        $staff = $this->call('staff', [], [], 'POST', $payload, ['content-type: application/json']);

        return (array)$staff->message;
    }

    /**
     * @param array $accounts
     * @param string $from
     * @param string $to
     * @return array
     */
    public function earnings(array $accounts = [], string $from, string $to = ''): array {
        $payload = json_encode([
            'accounts' => $accounts,
            'from' => $from ?: date('Y-m-d'),
            'to' => $to ?: date('Y-m-d'),
        ]);
        $earnings = $this->call('earnings', [], [], 'POST', $payload, ['content-type: application/json']);

        return (array)$earnings;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function open(string $token = '') {
        $payload = json_encode([
            'token' => $token,
        ]);
        return $this->call('open', [], [], 'POST', $payload, ['content-type: application/json']);
    }
}