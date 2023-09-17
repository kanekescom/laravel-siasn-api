<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Credentials\Ws;

class GenerateWsToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:ws-token
                            {--fresh : Always request new token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate WS Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $token = Ws::getToken()->object();
        } else {
            $token = Token::getWsToken();
        }

        $this->info(json_encode($token, JSON_PRETTY_PRINT));
    }
}
