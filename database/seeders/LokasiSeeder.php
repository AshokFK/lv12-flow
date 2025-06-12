<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the lokasi table
        $lokasi = Reader::createFromPath(database_path() . '/csv/lokasi.csv', 'r');
        $lokasi->setHeaderOffset(0); //set the CSV header offset

        foreach ($lokasi as $lok) {
            DB::table('lokasi')->insert([
                'nama' => trim($lok['nama']),
                'sub' => trim($lok['sub']),
                'deskripsi' => trim($lok['deskripsi']),
            ]);
        }
    }
}
