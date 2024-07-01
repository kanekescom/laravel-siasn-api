<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;

class ForgetTokenCommand extends Command
{
    protected $signature = 'siasn:forget-token';

    protected $description = 'Remove APIM and SSO Token';

    public function handle(): int
    {
        Token::forget();

        $this->comment('Tokens has been removed');

        return self::SUCCESS;
    }
}
