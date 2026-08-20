<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CariTpiTerdekatTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_publik_cari_tpi_terdekat_dapat_diakses_tanpa_login()
    {
        $response = $this->get(route('tpi.cari-terdekat'));

        $response->assertStatus(200);
        $response->assertSee('Cari TPI Terdekat');
        $response->assertSee('Gunakan Lokasi Saya');
    }

    public function test_json_endpoint_mengembalikan_list_tpi_terdekat_terurut()
    {
        // Buat 2 TPI aktif dengan koordinat
        $tpiJauh = User::create([
            'name'      => 'TPI Jauh',
            'email'     => 'jauh@tpi.com',
            'phone'     => '08123456789',
            'alamat'    => 'Jl. Jauh',
            'latitude'  => -8.5000000,
            'longitude' => 114.5000000,
            'role'      => 'tpi',
            'status'    => 1,
            'password'  => bcrypt('password'),
        ]);

        $tpiDekat = User::create([
            'name'      => 'TPI Dekat',
            'email'     => 'dekat@tpi.com',
            'phone'     => '08987654321',
            'alamat'    => 'Jl. Dekat',
            'latitude'  => -8.2200000,
            'longitude' => 114.3700000,
            'role'      => 'tpi',
            'status'    => 1,
            'password'  => bcrypt('password'),
        ]);

        // Request dari titik lokasi browser dekat dengan TPI Dekat (-8.2192, 114.3692)
        $response = $this->getJson(route('tpi.terdekat-json', [
            'latitude'  => -8.2192,
            'longitude' => 114.3692,
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
        ]);

        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals('TPI Dekat', $data[0]['name']);
        $this->assertEquals('TPI Jauh', $data[1]['name']);
        $this->assertLessThan($data[1]['jarak_km'], $data[0]['jarak_km']);
    }

    public function test_json_endpoint_validasi_input_koordinat()
    {
        $response = $this->getJson(route('tpi.terdekat-json', [
            'latitude'  => 999, // tidak valid
            'longitude' => 114.3692,
        ]));

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
        ]);
    }
}
