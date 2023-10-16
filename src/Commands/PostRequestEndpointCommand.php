<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Facades\Siasn;

class PostRequestEndpointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:post
                            {endpoint : POST request to endpoint of SIASN API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send POST request to endpoint of SIASN API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $endpoint = $this->argument('endpoint');
        $params = json_decode($this->ask('Write the parameters in JSON form here'), true);

        $this->info(json_encode(Siasn::post($endpoint, $params)->object(), JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
