<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SchelduledTask;
use App\Services\AccountServices;
class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running command hourly';

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
     * @return int
     */
    public function handle(AccountServices $account_services)
    {
        $data=SchelduledTask::where('transfer_time',now())->get();
        foreach($data as $dat){
            $sender=$dat->sender;
            $receiver=$dat->receiver;
            $amount=$dat->amount;
            $account_services->sendJob($sender,$receiver,$amount);
        }
    }
}
