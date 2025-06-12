<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the qc table
        $qc = Reader::createFromPath(database_path() . '/csv/qc.csv', 'r');
        $qc->setHeaderOffset(0); //set the CSV header offset

        foreach ($qc as $qcData) {
            DB::table('qc')->insert([
                'nama' => trim($qcData['nama']),
            ]);
        }
    }
}
