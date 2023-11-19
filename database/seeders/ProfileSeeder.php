<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $profiles = array(
            'administrador',
            'paciente',
            'psicólogo'
        );
        for($i=0; $i < sizeof($profiles); $i++) { 
            Profile::create([
                'profile' => $profiles[$i]
            ]);
        } 
    }
}
