<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the proses table
        // Truncate the proses table to start fresh
        DB::table('proses')->truncate();
        // Import proses data from CSV file
        // Make sure to adjust the path to your CSV file
        // and the column names in the CSV file to match your database schema
        $proses = Reader::createFromPath(database_path() . '/csv/proses.csv', 'r');
        $proses->setHeaderOffset(0); //set the CSV header offset

        foreach ($proses as $pro) {
            DB::table('proses')->insert([
                'mastercode' => trim($pro['mastercode']),
                'lokasi_id' => trim($pro['lokasi_id']),
                'nama' => trim($pro['nama']),
                'nama_jp' => trim($pro['nama_jp']),
                'level' => trim($pro['level'])
            ]);
        }
    }
}
