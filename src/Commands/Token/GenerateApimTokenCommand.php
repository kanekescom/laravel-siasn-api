<?php

namespace Kanekes\Siasn\Api\Commands\Token;

use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class GenerateApimTokenCommand extends Command
{
    protected $signature = 'siasn:apim-token
                            {--fresh : Always request a new token}';

    protected $description = 'Generate an APIM Token';

    public function __construct(private readonly TokenManager $tokenManager)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $token = $this->option('fresh')
                ? $this->tokenManager->getFreshToken('apim')
                : $this->tokenManager->getToken('apim');

            $this->info(collect($token)->toJson(JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
