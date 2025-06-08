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

        // Import data from CSV file into the proses table
        $proses = Reader::createFromPath(database_path() . '/csv/proses.csv', 'r');
        $proses->setHeaderOffset(0); //set the CSV header offset
        foreach ($proses as $pro) {
            DB::table('proses')->insert([
                'mastercode' => $pro['mastercode'],
                'lokasi' => $pro['lokasi'],
                'nama' => $pro['nama'],
                'nama_jp' => $pro['nama_jp'],
                'level' => $pro['level']
            ]);
        }

        // Import data from CSV file into the qc table
        $qc = Reader::createFromPath(database_path() . '/csv/qc.csv', 'r');
        $qc->setHeaderOffset(0); //set the CSV header offset
        foreach ($qc as $qcData) {
            DB::table('qc')->insert([
                'nama' => $qcData['nama'],
            ]);
        }

        // Import data from CSV file into the lokasi table
        $lokasi = Reader::createFromPath(database_path() . '/csv/lokasi.csv', 'r');
        $lokasi->setHeaderOffset(0); //set the CSV header offset
        foreach ($lokasi as $lok) {
            DB::table('lokasi')->insert([
                'nama' => $lok['nama'],
                'sub' => $lok['sub'],
                'deskripsi' => $lok['deskripsi'],
            ]);
        }

        // Import data from CSV file into the flow header table
        $flowHeaders = Reader::createFromPath(database_path() . '/csv/header.csv', 'r');
        $flowHeaders->setHeaderOffset(0); //set the CSV header offset
        foreach ($flowHeaders as $header) {
            DB::table('flow_header')->insert([
                'kontrak' => $header['kontrak'],
                'brand' => $header['brand'],
                'pattern' => $header['pattern'],
                'style' => $header['style'],
                'tgl_berjalan' => $header['tgl_berjalan'],
                'lokasi' => $header['lokasi'],
            ]);
        }
        
    }
}
