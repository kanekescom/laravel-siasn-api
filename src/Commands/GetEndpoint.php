<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Facades\Siasn;

class GetEndpoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:get
                            {endpoint : Get request to endpoint of SIASN API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume endpoint on SIASN API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(json_encode(Siasn::get($this->argument('endpoint'))->object(), JSON_PRETTY_PRINT));
    }
}
