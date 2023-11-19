<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;

class MagicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta todo lo necesario para iniciar el sistema por primera vez.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $option = null;
        while($option != 'Salir')
        {
            $option = $this->choice(
                '¿Qué desea realizar?',
                ['Ejecutar migraciones', 'Ejecutar ProfileSeeder', 'Crear administrador por defecto', 'Crear directorios para almacenar fotos de perfil', 'Reiniciar migraciones', 'Ayuda' ,'Salir']
            );
            switch($option)
            {
                case 'Ejecutar migraciones':
                    $migrateCommand = 'php artisan migrate --path=';
                    $migrationsOrdered = [
                        '2023_10_20_201405_create_profiles_table.php',
                        '2014_10_12_000000_create_users_table.php',
                        '2023_10_20_201503_create_user_personal_data_table.php',
                        '2023_10_20_201607_create_medical_histories_table.php',
                        '2023_10_20_201649_create_emergency_contacts_table.php',
                        '2023_10_20_201538_create_user_locations_table.php',
                        '2023_10_20_201739_create_appointments_table.php',
                        '2023_10_20_202647_create_users_log_table.php',
                        '2023_10_20_202457_create_medical_histories_log_table.php',
                        '2023_10_20_201758_create_appointments_log_table.php',
                        '2023_11_17_042200_create_verification_codes_table.php',
                        '2014_10_12_100000_create_password_reset_tokens_table.php',
                        '2019_12_14_000001_create_personal_access_tokens_table.php',
                        '2019_08_19_000000_create_failed_jobs_table.php'
                    ];
                    for($i=0; $i < sizeof($migrationsOrdered); $i++) {
                        $this->info("Ejecutando migración: $migrationsOrdered[$i]");
                        echo shell_exec($migrateCommand . "/database/migrations/$migrationsOrdered[$i]");
                    }
                    break;
                case 'Ejecutar ProfileSeeder':
                    $this->info('Creando datos para Perfiles...');
                    echo shell_exec('php artisan db:seed --class=ProfileSeeder');
                    break;
                case 'Crear administrador por defecto':
                    $this->info('Los siguientes datos del administrador por defecto son importantes para su creación.');
                    $names = $this->ask('Nombre(s)');
                    $firstSurname = $this->ask('Apellido paterno');
                    $secondSurname = $this->ask('Apellido materno');
                    $email = $this->ask('Correo electrónico');
                    $password = $this->secret('Contraseña');
                    $confirmPassword = $this->secret('Confirmar contraseña');
                    if($names == null || $firstSurname == null || $secondSurname == null || $email == null)
                    {
                        $this->error('Los datos requeridos, no cumplen lo necesario, ¡Abortando la creación del administrador!');
                        break;
                    }
                    if($password != $confirmPassword)
                    {
                        $this->error('Las contraseñas no coinciden, ¡Abortando la creación del administrador!');
                        break;
                    }
                    $profile = Profile::find(1);
                    $user = new User([
                        'email' => strtolower($email),
                        'password' => $password,
                        'state' => 1
                    ]);
                    $profile->users()->save($user);
                    $userPersonalData = new UserPersonalData([
                        'names' => strtolower($names),
                        'first_surname' => strtolower($firstSurname),
                        'second_surname' => strtolower($secondSurname)
                    ]);
                    $user->userPersonalData()->save($userPersonalData);
                    $userLog = new UserLog([
                        'user_id' => $user->id,
                        'action' => 'creación de administrador por defecto',
                        'details' => 'el sistema ha creado correctamente tu perfil por primer vez como administrador'
                    ]);
                    $userLog->save();
                    $this->info($user);
                    break;
                case 'Crear directorios para almacenar fotos de perfil':
                    echo shell_exec('php artisan storage:link');
                    break;
                case 'Reiniciar migraciones':
                    if($this->confirm("¿Seguro que desea reiniciar las migraciones?\n\n¡Todos los datos serán eliminados!")) {
                        $this->error('Eliminando migraciones...');
                        echo shell_exec('php artisan migrate:reset');
                    }
                    break;
                case 'Ayuda':
                    break;
                case 'Salir':
                    echo "saliendo";
                    break;
            }
        }
    }
}
