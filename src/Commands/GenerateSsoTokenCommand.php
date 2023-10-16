<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateSsoTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:sso-token
                            {--fresh : Always request new token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SSO Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $token = Sso::getToken()->object();
        } else {
            $token = Token::getSsoToken();
        }

        $this->info(json_encode($token, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
