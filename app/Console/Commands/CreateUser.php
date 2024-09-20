<?php

namespace App\Console\Commands;
use Log;
use Exception;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class CreateUser extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Dummy Users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $numberOfUsers = $this->argument('count');
            for($i=0; $i < $numberOfUsers; $i++){
                User::factory()->create();
            }
        
        // --- Give Data Form of Table---
            // $this->table(
            //     ['contact_no', 'designatione'],
            //     User::all(['mobile_no', 'role'])->toArray()
            // );

            // $this->info("Users created successfully.");
            Log::info("Users created successfully.");
        }catch(Exception $e){
            // $this->error("Error ocuured while updating users columns!");
            Log::error("Error ocuured while updating users columns!");
        }
    }
}
