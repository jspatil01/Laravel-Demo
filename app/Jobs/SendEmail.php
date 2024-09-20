<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\UserCreated;
use App\Models\User;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        // $this->onQueue('email');
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            \Log::info('Sending email to: ' . $this->user->email);
            Mail::to($this->user->email)->send(new UserCreated($this->user));
        } catch (Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
            report($e);
        }
    }
}