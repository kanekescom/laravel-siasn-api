<?php

namespace Kanekes\Siasn\Api\Commands\Token;

use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class ForgetTokenCommand extends Command
{
    protected $signature = 'siasn:forget-token';

    protected $description = 'Remove APIM and SSO Tokens';

    public function __construct(private readonly TokenManager $tokenManager)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->tokenManager->forgetTokens();

            $this->info('Tokens have been removed.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
