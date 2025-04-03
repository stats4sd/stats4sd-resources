<?php

namespace App\Console\Commands;

use App\Models\Trove;
use Illuminate\Console\Command;

class ImportTrovesToSearch extends Command
{    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import-troves';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Troves to the search index';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Trove::query()->searchable();

        Trove::where('id', '=', 500)->searchable();

        $this->info("Trove search indexes imported!");
    }
}
