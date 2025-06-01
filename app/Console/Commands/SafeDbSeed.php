<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SafeDbSeed extends Command
{
    protected $signature = 'db:seed-safe';
    protected $description = 'Safely seed the database only if tables are empty';

    public function handle()
    {
        // Check if database has data
        $isEmpty = true;
        
        $criticalTables = ['moods', 'dietary_preferences', 'food_categories', 'foods'];
        
        foreach ($criticalTables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                if ($count > 0) {
                    $isEmpty = false;
                    break;
                }
            }
        }
        
        if ($isEmpty) {
            $this->info('Database appears empty. Running seeders...');
            $this->call('db:seed', ['--force' => true]);
            $this->info('Database seeded successfully!');
        } else {
            $this->info('Database already contains data. Skipping seeding.');
        }
        
        return 0;
    }
}
