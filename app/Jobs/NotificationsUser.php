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

        if ($this->type==2) {
            Notification::create([
                "from_id"=>$this->data->assigned_to,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->runner_name." has canceled pickup request ". $this->data->id.'.',
                "data"=>$this->data,
                "type"=>2,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>2
                ]);
        }
        if ($this->type==3) {
            Notification::create([
                "from_id"=>$this->data->assigned_to,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->runner_name." has accepted pickup request ". $this->data->id.'.',
                "data"=>$this->data,
                "type"=>3,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>2
                ]);
        }
        if ($this->type==4) {
            Notification::create([
                "from_id"=>$this->data->assigned_to,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->runner_name."is out for pickup of request id". $this->data->id.'.',
                "data"=>$this->data,
                "type"=>4,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>2
                ]);
        }
        if ($this->type==5) {
            Notification::create([
                "from_id"=>$this->data->assigned_to,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->runner_name."has recieved request id". $this->data->id.'.',
                "data"=>$this->data,
                "type"=>5,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>2
                ]);
        }

         if ($this->type==6) {
            Notification::create([
                "from_id"=>$this->data->assigned_to,
                "to_id"=>$this->data->store_id,
                "message"=>$this->data->runner_name."has delivered pickup ". $this->data->id.' to store.',
                "data"=>$this->data,
                "type"=>6,
                'notifiable_type'=>'pickup-request',
                'notifiable_id'=>2
                ]);
        }
    }
}
