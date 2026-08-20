<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dinas = User::create([
            'name'     => 'Dinas Perikanan Banyuwangi',
            'email'    => 'DinasBWI@gmail.com',
            'password' => Hash::make('111111111'),
            'role'     => 'dinas',
            'status'   => 1,
            'alamat'   => 'Jl. Perikanan No. 1, Banyuwangi',
            'phone'    => '081234567890',
        ]);

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('111111111'),
            'role'     => 'admin',
            'status'   => 1,
        ]);

        User::create([
            'name'      => 'TPI Muncar',
            'email'     => 'tpi@gmail.com',
            'password'  => Hash::make('111111111'),
            'role'      => 'tpi',
            'dinas_id'  => $dinas->id,
            'status'    => 1,
            'alamat'    => 'Pelabuhan Muncar, Banyuwangi',
            'phone'     => '081234567891',
            'latitude'  => -8.4321000,
            'longitude' => 114.3411000,
        ]);

        User::create([
            'name'      => 'TPI Puger',
            'email'     => 'puger@tpi.com',
            'password'  => Hash::make('111111111'),
            'role'      => 'tpi',
            'dinas_id'  => $dinas->id,
            'status'    => 1,
            'alamat'    => 'Pelabuhan Perikanan Puger, Jember',
            'phone'     => '081234567892',
            'latitude'  => -8.3713735,
            'longitude' => 113.4740358,
        ]);

        User::create([
            'name'      => 'TPI MIMBO',
            'email'     => 'mimbo@tpi.com',
            'password'  => Hash::make('111111111'),
            'role'      => 'tpi',
            'dinas_id'  => $dinas->id,
            'status'    => 1,
            'alamat'    => 'Pelabuhan Mimbo, Situbondo',
            'phone'     => '081234567893',
            'latitude'  => -7.7154309,
            'longitude' => 114.2793566,
        ]);

        User::create([
            'name'     => 'Ferdynand',
            'email'    => 'Ferdynand@gmail.com',
            'password' => Hash::make('111111111'),
            'role'     => 'pembeli',
            'status'   => 1,
        ]);

        User::create([
            'name'     => 'Septa',
            'email'    => 'Septa@gmail.com',
            'password' => Hash::make('111111111'),
            'role'     => 'pembeli',
            'status'   => 1,
        ]);

        User::create([
            'name'     => 'Rehan',
            'email'    => 'Rehan@gmail.com',
            'password' => Hash::make('111111111'),
            'role'     => 'pembeli',
            'status'   => 1,
        ]);
    }
}
