<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;

class ForgetTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:forget-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove APIM and SSO Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Token::forget();

        $this->comment('Tokens has been removed');

        return self::SUCCESS;
    }
}
