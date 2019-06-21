<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendInvoice as SendInvoice;
use Mail;
class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     protected $details;
     protected $to_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $customer_id)
    {
         $this->details = $details;
         $this->to_id = $customer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('id', $this->to_id)->first();

        if ($user->email) {
           
           $email = new SendInvoice($this->details);
           Mail::to($user->email)->send($email);
        }
        
    }
}
