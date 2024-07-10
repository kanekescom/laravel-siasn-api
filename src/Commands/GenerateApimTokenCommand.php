<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateApimTokenCommand extends Command
{
    protected $signature = 'siasn:apim-token
                            {--fresh : Always request a new token}';

    protected $description = 'Generate an APIM Token';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $token = Token::getNewApimToken();
        } else {
            $token = Token::getApimToken();
        }

        $this->info(json_encode($token, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
