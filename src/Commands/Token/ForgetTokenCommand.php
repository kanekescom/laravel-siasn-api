<?php

namespace Kanekes\Siasn\Api\Commands\Token;

use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class ForgetTokenCommand extends Command
{
    protected $signature = 'siasn:forget-token';

    protected $description = 'Forget APIM and SSO tokens';

    public function __construct(private readonly TokenManager $tokenManager)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->tokenManager->forgetTokens();

            $this->info('Tokens forgotten.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
