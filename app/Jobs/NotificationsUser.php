<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Model\Notification;

class NotificationsUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $data;
      public $type;
    public function __construct($data, $type)
    {
        $this->data=$data;
        $this->type=$type;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type==1) {
            Notification::create([
                "from_id"=>$this->data->customer_id,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->customer_name." has requested a pickup.",
                "data"=>$this->data,
                "type"=>1,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>1
                ]);
        }
    }
}
