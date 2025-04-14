<?php

namespace Kanekes\Siasn\Api\Commands\Request;

use Exception;
use Illuminate\Console\Command;
use JsonException;
use Kanekes\Siasn\Api\Facades\Siasn;

class PostRequestCommand extends Command
{
    protected $signature = 'siasn:post
                            {endpoint : SIASN API endpoint}
                            {--with-sso : Send request using SSO authentication}';

    protected $description = 'Send POST request to SIASN API';

    public function handle(): int
    {
        $endpoint = $this->argument('endpoint');
        $withSso = $this->option('with-sso');
        $params = $this->getJsonParams();

        try {
            $response = $withSso
                ? Siasn::withSso()->post($endpoint, $params)
                : Siasn::post($endpoint, $params);

            $this->info(json_encode($response->object(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function getJsonParams(): ?array
    {
        $input = $this->ask('Enter JSON parameters (optional)');

        if (blank($input)) {
            return [];
        }

        try {
            return json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->error('Invalid JSON input: '.$e->getMessage());

            return null;
        }
    }
}
