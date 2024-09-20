<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Log;

class TestCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:TestCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is Demo Testing Custom Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("This is a info method display in red text.");
        Log::info("This is a info method display in red text.");
        Log::error("Error");
        $this->newLine(2);
        $this->line("This is a line method display in uncolored text.");
    }
}
