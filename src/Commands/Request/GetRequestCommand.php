<?php

namespace Kanekes\Siasn\Api\Commands\Request;

use Exception;
use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Facades\Siasn;

class GetRequestCommand extends Command
{
    protected $signature = 'siasn:get
                            {endpoint : GET a request to endpoint of SIASN API}';

    protected $description = 'Send a GET request to the endpoint of SIASN API';

    public function handle(): int
    {
        $endpoint = $this->argument('endpoint');
        $params = json_decode($this->ask('Write the parameters in JSON form here'), true, 512, JSON_THROW_ON_ERROR);

        try {
            $response = Siasn::withSso()->get($endpoint, $params);

            $this->info(json_encode($response->object(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
