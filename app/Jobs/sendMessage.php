<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\CommonRepository;

use App\Model\{
    OrderItems,
    SMSTemplate
};
class sendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $phone;
    public $type;
    public $data;
    public $message;
    public function __construct($message, $phone, $type, $data)
    {
        $this->phone=$phone;
        $this->message=$message;
        $this->type=$type;
        $this->data=$data;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type==1) {
            $order = $this->data;
            $total = OrderItems::where('order_id', $order->id)->sum('quantity');
            $weighr = OrderItems::where('order_id', $order->id)->sum('weight');
            
            $message = SMSTemplate::where('title', 'like','%Order Created%')->select('description')->first();
              //dd($message);
            $message = $message->description;

            $mes = str_replace('@order_id@', $order->id, $message);
            $mes = str_replace('@total_clothes@', $total, $mes);
            if ($weighr && $weighr>0) {
               $mes = str_replace('@weight@', $weighr, $mes);
            }
            $mes = str_replace(' ', '%20', $mes);

            CommonRepository::sendmessage($this->phone, $this->message);
        }
        
    }
}
