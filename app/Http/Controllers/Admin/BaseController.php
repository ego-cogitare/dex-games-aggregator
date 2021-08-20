<?php

namespace App\Http\Controllers\Admin;


use App\Components\Api\AtomicHub;
use App\Http\Controllers\Controller;
use View;
use App;

/**
 * Class BaseController
 * @package App\Http\Controllers\Admin
 */
class BaseController extends Controller
{
    /**
     * @var AtomicHub|null
     */
    protected $atomicHub = null;

    /**
     * MarketController constructor.
     * @param AtomicHub $atomicHub
     */
    public function __construct(AtomicHub $atomicHub)
    {
        $this->atomicHub = $atomicHub;
    }

//        if (is_numeric($market)) {
//            /** @var MarketOptions $marketOptions */
//            $marketOptions = MarketOptions::with(['stock', 'server'])
//                ->where(['stock_id' => $market])
//                ->first();
//
//            /** @var array $processesInfo */
//            $processesInfo = $this->collectSupervisorsProcesses();
//
//            $this->marketData = [
//                'id' => $marketOptions->stock_id,
//                'title' => $marketOptions->stock->name,
//                'log' => [
//                    'bot' => array_first($processesInfo['exchanges'][$market] ?? [])['log_url'],
//                    'equalizer' => array_first($processesInfo['equalizers'][$market] ?? [])['log_url'],
//                    'wss' => array_first($processesInfo['wss'][$market] ?? [])['log_url'],
//                ],
//            ];
//
//            /** Share global view market variable */
//            View::share('marketData', $this->marketData);
//        }
}
