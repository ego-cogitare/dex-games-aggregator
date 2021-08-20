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
     * @return stdClass
     */
    public function fetchHistory(string $date = '', array $accounts = []): stdClass {
        $payload = json_encode([
            'accounts' => $accounts,
            'collectionName' => 'alienshipsio',
            'search' => [
                [
                    'schema_name' => 'addons',
                    'match' => 'AUTOPILOT P1',
                ],
                [
                    'schema_name' => 'addons',
                    'match' => 'AUTOPILOT P3',
                ],
            ],
        ]);
        $history = $this->call('history', [], [], 'POST', $payload, ['content-type: application/json']);

        return $history->calendar->{$date} ?? [];
    }

    /**
     * @param array $accounts
     * @return array
     */
    public function fetchPendingOrders(array $accounts = []): array {
        $payload = json_encode([
            'accounts' => $accounts,
            'collectionName' => 'alienshipsio',
            'search' => [
                [
                    'schema_name' => 'addons',
                    'match' => 'AUTOPILOT P1',
                ],
                [
                    'schema_name' => 'addons',
                    'match' => 'AUTOPILOT P3',
                ],
            ],
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
                'limit' => 100,
            ],
        ]);
        $staff = $this->call('staff', [], [], 'POST', $payload, ['content-type: application/json']);

        return (array)$staff->message;
    }
}