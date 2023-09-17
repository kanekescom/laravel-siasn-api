<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetData extends Command
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
    protected $description = 'Consume API endpoint';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(json_encode(Http::siasn()->get($this->argument('endpoint'))->object(), JSON_PRETTY_PRINT));
    }
}
