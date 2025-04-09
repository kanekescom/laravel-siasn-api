<?php

namespace Kanekes\Siasn\Api\Commands\Request;

use Exception;
use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Facades\Siasn;

class PostRequestCommand extends Command
{
    protected $signature = 'siasn:post
                            {endpoint : SIASN API endpoint}';

    protected $description = 'Send POST request to SIASN API';

    public function handle(): int
    {
        try {
            $endpoint = $this->argument('endpoint');
            $params = json_decode($this->ask('Enter JSON parameters (optional)'), true, 512, JSON_THROW_ON_ERROR);
            $response = Siasn::withSso()->post($endpoint, $params);

            $this->info(json_encode($response->object(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
