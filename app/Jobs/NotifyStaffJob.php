<?php

namespace App\Jobs;

use App\Mail\NotifyStaffEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyStaffJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $name, private $email, private $subject, private $message)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            //code...
            Mail::to(config('mail.from.address'))->queue(new NotifyStaffEmail($this->name, $this->email, $this->subject, $this->message));

        } catch (\Throwable $th) {
    
            info( $th);

        }
    }
}
