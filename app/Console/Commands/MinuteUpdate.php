<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExpenseType;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Auth;
use Auth;

class MinuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:minute-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send per minute update in the DB to the user';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {   
        $expenses = ExpenseType::all();
        $expenses = new ExpenseType;
        $id = Auth::id();
        $this->info($id);
        die;
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        $expenses->expense_name = 'Car_';
        $expenses->added_by = Auth::id();
        $expenses->save();

        $this->info('per minute update has been send successfully');
    }
}
