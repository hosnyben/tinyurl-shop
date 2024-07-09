<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ClearCache implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    protected $type;

    /**
     * Create a new job instance.
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Redis::select(1);
            $cursor = '0';
            $pattern = config('database.redis.options.prefix') . $this->type . '_*';
            $count = 1000; // Number of keys to retrieve per iteration

            do {
                info("While ". $this->type . " : " . $cursor);
                $result = Redis::scan($cursor, ['match' => $pattern, 'count' => $count]);
                $cursor = $result[0];
                $keys = $result[1];

                foreach ($keys as $key) {
                    info("Deleted key : ".$key);
                    Cache::forget(str_replace(config('database.redis.options.prefix'), '', $key));
                }
            } while ($cursor != '0');

            // Log the number of keys deleted
            info("Deleted keys");
        } catch (Exception $e) {
            // Log the exception
            info("Exception occurred: " . $e->getMessage());
            // Re-throw the exception to ensure the job fails and can be retried
            throw $e;
        }
    }
}
