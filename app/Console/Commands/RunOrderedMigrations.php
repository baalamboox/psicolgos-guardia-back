<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunOrderedMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrations:run-ordered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run each migration in ordered way';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = 'php artisan migrate --path=';
        // Migrations
        $migrationsToRunInOrder = array(
            '2023_10_20_201405_create_profiles_table.php',
            '2014_10_12_000000_create_users_table.php',
            '2023_10_20_201503_create_user_personal_data_table.php',
            '2023_10_20_201607_create_medical_histories_table.php',
            '2023_10_20_201649_create_emergency_contacts_table.php',
            '2023_10_20_201538_create_user_locations_table.php',
            '2023_10_20_201739_create_appointments_table.php',
            '2023_10_20_202647_create_users_log_table.php',
            '2023_10_20_202457_create_medical_histories_log_table.php',
            '2023_10_20_201758_create_appointments_log_table.php'
        );
        for ($i=0; $i < sizeof($migrationsToRunInOrder); $i++) {
            $this->info("Ejecutando migración: $migrationsToRunInOrder[$i]");
            echo shell_exec($command . "/database/migrations/$migrationsToRunInOrder[$i]");
        }
    }
}
