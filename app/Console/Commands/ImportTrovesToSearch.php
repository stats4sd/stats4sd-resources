<?php

namespace App\Console\Commands;

use Laravel\Scout\Searchable;
use Illuminate\Console\Command;

class ImportTrovesToSearch extends Command
{
    use Searchable;
    
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
        Trove::query()->searchable();

        $this->info("Trove search indexes imported!");
    }
}
