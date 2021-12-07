<?php

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KodePos;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        User::create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'username' => 'sayaadmin',
            'email' => 'sayaadmin@gmail.com',
            'role' => 'Admin',
            'foto' => 'fotoadmin.jpg',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'firstname' => 'new',
            'lastname' => 'manager',
            'username' => 'newmanager',
            'email' => 'newmanager@gmail.com',
            'role' => 'Manager',
            'foto' => 'fotomanajer.jpg',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);


        Provinsi::truncate();
        $csvProvinsiFile = fopen(base_path("database\seeds\csv\province.csv"), "r");  
        $firstline = true;
        while (($data = fgetcsv($csvProvinsiFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Provinsi::create([
                    "id" => $data['0'],
                    "nama" => $data['1']
                ]);    
            }
            $firstline = false;
        }   
        fclose($csvProvinsiFile); 
        
        $csvKotaFile = fopen(base_path("database\seeds\csv\city.csv"), "r");  
        $firstline = true;
        while (($data = fgetcsv($csvKotaFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Kota::create([
                    "id" => $data['0'],
                    "nama" => $data['1'],
                    "provinsi_id" => $data['2']
                ]);    
            }
            $firstline = false;
        }   
        fclose($csvKotaFile); 
        
        $csvKecamatanFile = fopen(base_path("database\seeds\csv\district.csv"), "r");  
        $firstline = true;
        while (($data = fgetcsv($csvKecamatanFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Kecamatan::create([
                    "id" => $data['0'],
                    "nama" => $data['1'],
                    "kota_id" => $data['2']
                ]);    
            }
            $firstline = false;
        }   
        fclose($csvKecamatanFile); 

        $csvDesaFile = fopen(base_path("database\seeds\csv\subdistrict.csv"), "r");  
        $firstline = true;
        while (($data = fgetcsv($csvDesaFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Desa::create([
                    "id" => $data['0'],
                    "nama" => $data['1'],
                    "kecamatan_id" => $data['2']
                ]);    
            }
            $firstline = false;
        }   
        fclose($csvDesaFile); 

        
        $csvKodePosFile = fopen(base_path("database\seeds\csv\postal_code.csv"), "r");  
        $firstline = true;
        while (($data = fgetcsv($csvKodePosFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                KodePos::create([
                    "desa_id" => $data['1'],
                    "kecamatan_id" => $data['2'],
                    "kota_id" => $data['3'],
                    "provinsi_id" => $data['4'],
                    "kode" => $data['5']
                ]);    
            }
            $firstline = false;
        }   
        fclose($csvKodePosFile);  
        
    }
}