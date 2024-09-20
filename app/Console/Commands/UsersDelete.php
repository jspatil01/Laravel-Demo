<?php

namespace App\Console\Commands;

use Exception;
use Log;
use Illuminate\Console\Command;
use App\Models\User;

class UsersDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            User::where('mobile_no', null)->delete();
            Log::info("Users Deleted Successfully.");
        }catch(Exception $e){
            Log::error("Error while deleting users!");
        }
    }
}
