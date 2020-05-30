<?php

namespace App\Console\Commands;

use App\Plant;
use Illuminate\Console\Command;
use App\Http\Controllers\GameController;

class GameStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:start';

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
        $game = new GameController;
        $game->start();
        \Log::info('Game start');
    }
}
