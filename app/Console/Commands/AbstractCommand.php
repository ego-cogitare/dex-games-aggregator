<?php

namespace App\Console\Commands;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

abstract class AbstractCommand extends Command
{

    protected function sleep($delay = 1)
    {
        $this->line('Sleeping ' . $delay. ' seconds...');
        sleep((int)$delay);
    }

    protected function queueLimitReached($queueName) : bool
    {
        $jobsInQueue = DB::connection()->getPdo()->query("SELECT COUNT(*) as count FROM jobs WHERE queue = ".DB::connection()->getPdo()->quote($queueName))->fetch()['count'] ?? 0;
        $jobsLimit = Setting::get('max_jobs_per_queue') ?? 0;
        return $jobsInQueue >= $jobsLimit;
    }

    protected function getDateString ()
    {
        return Carbon::now()->format("Y-m-d H:i:s");
    }

    public function info($string, $verbosity = null)
    {
        parent::info((!empty($string) ? $this->getDateString().' : ' : '').$string, $verbosity);
    }

    public function line($string, $style = null, $verbosity = null)
    {
        parent::line((!empty($string) ? $this->getDateString().' : ' : '').$string, $style, $verbosity);
    }

    public function comment($string, $verbosity = null)
    {
        parent::comment((!empty($string) ? $this->getDateString().' : ' : '').$string, $verbosity);
    }

    public function question($string, $verbosity = null)
    {
        parent::question((!empty($string) ? $this->getDateString().' : ' : '').$string, $verbosity);
    }

    public function error($string, $verbosity = null)
    {
        parent::error((!empty($string) ? $this->getDateString().' : ' : '').$string, $verbosity);
    }

    public function warn($string, $verbosity = null)
    {
        parent::warn((!empty($string) ? $this->getDateString().' : ' : '').$string, $verbosity);
    }

    public function alert($string)
    {
        parent::alert((!empty($string) ? $this->getDateString().' : ' : '').$string);
    }
}