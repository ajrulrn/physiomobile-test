<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateAccessKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'access-key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an access key for accessing api routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = Str::random(32);
        $path = base_path('.env');

        if (!file_exists($path)) {
            $this->error('.env file not found');
            return 1;
        }

        $content = file_get_contents($path);

        if (preg_match('/^ACCESS_KEY=/m', $content)) {
            $content = preg_replace('/^ACCESS_KEY=.*/m', 'ACCESS_KEY=' . $key, $content);
        } else {
            $content .= PHP_EOL . 'ACCESS_KEY=' . $key . PHP_EOL;
        }

        file_put_contents($path, $content);
        $this->info('Access key generated successfully: ' . $key);
        return 0;
    }
}
