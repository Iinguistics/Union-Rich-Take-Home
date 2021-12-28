<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shopper\Shopper;
use App\Models\Store\Location\Location;
use Carbon\Carbon;



class AutoCheckOutTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:auto-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        $activeShoppers = Shopper::where('status_id', 1)->get();
        $currentTime = Carbon::now();

        foreach ($activeShoppers as $shopper) {
            $difference = $currentTime->diffInMinutes($shopper->check_in);
            if ($difference >= 120) {
                $checkedOutShopper = Shopper::where('uuid', $shopper->uuid)
                    ->update(['status_id' => 2, 'check_out' => $currentTime]);
            }
        }
    }
}
