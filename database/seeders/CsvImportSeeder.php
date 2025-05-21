<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CsvImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the komponen table
        // Make sure to adjust the path to your CSV file
        // and the column names in the CSV file to match your database schema
        $komponen = Reader::createFromPath(database_path() . '/csv/komponen.csv', 'r');
        $komponen->setHeaderOffset(0); //set the CSV header offset

        foreach ($komponen as $kom) {
            DB::table('komponen')->insert([
                'nama' => $kom['nama'],
                'type' => $kom['type'],
            ]);
        }
    }
}
