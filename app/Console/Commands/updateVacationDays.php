<?php

namespace App\Console\Commands;

use App\Employee;
use App\Worker;
use Illuminate\Console\Command;

class updateVacationDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation';

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
     * @return int
     */
    public function handle()
    {
        $employees = Employee::all();
        foreach ($employees as $employee){
            $employee->normal_vacation_no = 21;
            $employee->casual_vacation_no = 7;
            $employee->save();
        }
        $workers = Worker::all();
        foreach ($workers as $worker){
            $worker->normal_vacation_no = 21;
            $worker->casual_vacation_no = 7;
            $worker->save();
        }
    }
}
