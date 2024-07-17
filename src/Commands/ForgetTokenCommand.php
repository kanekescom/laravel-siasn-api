<?php

namespace Kanekescom\Siasn\Api\Commands;

use Exception;
use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;

class ForgetTokenCommand extends Command
{
    protected $signature = 'siasn:forget-token';

    protected $description = 'Remove APIM and SSO Token';

    public function handle(): int
    {
        try {
            Token::forget();

            $this->info('Tokens has been removed');

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
