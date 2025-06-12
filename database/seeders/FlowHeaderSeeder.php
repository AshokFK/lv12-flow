<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FlowHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the flow header table
        $flowHeaders = Reader::createFromPath(database_path() . '/csv/header.csv', 'r');
        $flowHeaders->setHeaderOffset(0); //set the CSV header offset

        foreach ($flowHeaders as $header) {
            DB::table('flow_header')->insert([
                'kontrak' => trim($header['kontrak']),
                'brand' => trim($header['brand']),
                'pattern' => trim($header['pattern']),
                'style' => trim($header['style']),
                'tgl_berjalan' => trim($header['tgl_berjalan']),
                'lokasi_id' => trim($header['lokasi_id']),
                'wrapper_width' => trim($header['wrapper_width']),
                'wrapper_height' => trim($header['wrapper_height']),
            ]);
        }
    }
}
