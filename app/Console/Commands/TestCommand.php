<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $attempt = 0;
        $created = false;
        $subdomain = 'dashboard';

        do {

            if ($attempt > 10) {
                throw new \Exception('Site can\'t be created. Too much attempts.');
            }

            try {
//                if ($attempt < 3) {
//                    throw new \Exception('Site can\'t be created. Too much attempts.');
//                }
                $created = true;

            } catch (\Exception $e) {
                $subdomain .= substr($subdomain, -1);
            }

            $this->info($subdomain);

            $attempt++;

        } while (! $created);
    }

}
