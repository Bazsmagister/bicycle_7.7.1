<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class InspireMe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire:me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command inspires me hopefully';

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
        echo(Inspiring::quote()),"\n";
        echo 'foo end', "\n";
        $this->line('==================');
        $this->line('Running my job at ' . Carbon::now());
        $this->line('Ending my job at ' . Carbon::now());


        // echo(Inspiring::quote()) > laravel.log;
    }
}
