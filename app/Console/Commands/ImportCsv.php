<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use  App\Model\Service;
use  App\Model\Items;

use  App\Model\ServicePrice;
class ImportCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imprts csv content';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = ($this->csvToArray( public_path('csv/service/dry-clean.csv')) );
        foreach ($data as $key => $value) {
            
            $vals = explode(";", $value[0]);
            $items = [];
            $id = Service::where('name', 'Dry Clean')->select('id')->first();
            $id = $id->id;
            
            print_r($vals);

            $item = Items::create(['name'=>$vals[1], 'type'=> 1]);

            $price = ServicePrice::create(['location'=>'global', 'value'=>$vals[2], 'service_id'=>$id,
                                                   'parameter'=>$item->id, 'service_type'=1]);
        }

    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
