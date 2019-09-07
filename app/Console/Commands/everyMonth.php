<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customer;
use App\Bill;
use Carbon\Carbon;
class everyMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:billgenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $users=Customer::where('status',1)
        ->with('package')
        ->get();
        $date = Carbon::now(); 
        $month=date_format($date,"m");
        $year=date_format($date,"Y");
        $bills=Bill::where('enddate',date_format($date,"y-m-m"))
        ->get();
        if(count($bills))
        {
            echo 'Bill Generate Error';  
            return;     
    
        }

       foreach($users as $user)
            {
                Bill::create(
                    [
                        'admin_id' => 1,
                        'customer_id' => $user->id,
                        'package' => $user->package_id,
                        'price' => $user->package->price,
                        'startdate' => date_format($date,"y-m-m"),
                        'enddate' => date_format($date,"y-m-m"),
                        'month' => $month,
                        'year' => $year,
                    ]
                    );
            }
            echo 'Successfully Generated';       
    
    }
}
