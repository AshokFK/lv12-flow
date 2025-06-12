<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FlowItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from CSV file into the flow item table

        // kosongkan table flow_item
        DB::table('flow_item')->truncate();

        // import standar item SJA
        $flowItems = Reader::createFromPath(database_path() . '/csv/item-standar-sja.csv', 'r');
        $flowItems->setHeaderOffset(0); //set the CSV header offset

        $this->command->outputComponents()->task('item-standar-sja.csv', function () use ($flowItems) {
            // Insert each item into the flow_item table
            foreach ($flowItems as $item) {
                DB::table('flow_item')->insert([
                    'header_id' => trim($item['header_id']),
                    'itemable_type' => trim($item['itemable_type']),
                    'itemable_id' => trim($item['itemable_id']),
                    'next_to' => trim($item['next_to']),
                    'proses_type' => trim($item['proses_type']),
                    'operator' => trim($item['operator']),
                    'mesin' => trim($item['mesin']),
                    'left' => trim($item['left']) . "px",
                    'top' => trim($item['top']) . "px",
                ]);
            }
        });

        // import standar item SJB
        $flowItems = Reader::createFromPath(database_path() . '/csv/item-standar-sjb.csv', 'r');
        $flowItems->setHeaderOffset(0); //set the CSV header offset

        $this->command->outputComponents()->task('item-standar-sjb.csv', function () use ($flowItems) {
            // Insert each item into the flow_item table
            foreach ($flowItems as $item) {
                DB::table('flow_item')->insert([
                    'header_id' => trim($item['header_id']),
                    'itemable_type' => trim($item['itemable_type']),
                    'itemable_id' => trim($item['itemable_id']),
                    'next_to' => trim($item['next_to']),
                    'proses_type' => trim($item['proses_type']),
                    'operator' => trim($item['operator']),
                    'mesin' => trim($item['mesin']),
                    'left' => trim($item['left']) . "px",
                    'top' => trim($item['top']) . "px",
                ]);
            }
        });
    }
}
