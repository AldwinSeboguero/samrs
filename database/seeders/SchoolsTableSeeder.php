<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SchoolsTableSeeder extends Seeder
{
    public function run()
    {
        // Path to the CSV file
        $csvFile = __DIR__ . '/schools2.csv';

        if (File::exists($csvFile)) {
            $file = fopen($csvFile, 'r');
            $header = fgetcsv($file);

            // Remove BOM if it exists
            if (isset($header[0]) && strpos($header[0], "\ufeff") == 0) {
                $header[0] = substr($header[0], 3); // Remove the BOM
            }
            $header = array_map('trim', $header); // Trim spaces

            // Debugging: Output the header
            $this->command->info('Header: ' . json_encode($header));

            while (($row = fgetcsv($file)) !== false) {
                // Trim the row data as well
                $row = array_map('trim', $row);

                // Check if the row length matches the header length
                if (count($row) !== count($header)) {
                    $this->command->info('Row length does not match header length. Row: ' . json_encode($row));
                    continue; // Skip this row
                }

                $data = array_combine($header, $row);

                // Debugging: Output the row data
                $this->command->info('Row data: ' . json_encode($data));

                // Check for existence of 'name' and 'address' keys
                if (isset($data['name']) && isset($data['address'])) {
                    $existingSchool = DB::table('schools')
                        ->where('name', $data['name'])
                        ->first();

                    if (!$existingSchool) {
                        DB::table('schools')->insert([
                            'name' => $data['name'],
                            'address' => $data['address'],
                        ]);
                    }
                } else {
                    // Log missing keys
                    $this->command->info('Missing keys in row: ' . json_encode($data));
                }
            }

            fclose($file);
        } else {
            $this->command->info('CSV file not found: ' . $csvFile);
        }
    }
}