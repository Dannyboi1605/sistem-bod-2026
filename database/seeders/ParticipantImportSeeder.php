<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class ParticipantImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = database_path('seeders/participants.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found at: {$csvFile}");
            return;
        }

        $fileHandle = fopen($csvFile, 'r');
        if ($fileHandle === false) {
            $this->command->error("Could not open the CSV file.");
            return;
        }

        DB::beginTransaction();

        try {
            $isFirstRow = true;
            $count = 0;

            while (($row = fgetcsv($fileHandle)) !== false) {
                // Skip the first row if it contains headers
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }

                // Map the CSV data to fields: 'name', 'position', 'agency'
                // Based on new CSV format: NAME (0), POSITION (1), AGENCY (2), ROLE (3)
                $name     = $row[0] ?? null;
                $position = $row[1] ?? null;
                $agency   = $row[2] ?? null;

                // Basic validation: skip if we don't have a name
                if (empty($name)) {
                    continue;
                }

                // Since phone number is removed, we use 'name' and 'agency' as the unique identifier
                User::firstOrCreate(
                    [
                        'name'   => $name,
                        'agency' => $agency,
                    ],
                    [
                        'position'         => $position,
                        'roles'            => ['peserta'],
                        'is_eligible_cert' => false,
                    ]
                );

                $count++;

                // Log a success message to the console for every 50 users imported
                if ($count % 50 === 0) {
                    $this->command->info("Successfully imported {$count} users...");
                }
            }

            DB::commit();
            $this->command->info("Import completed successfully. Total users imported: {$count}");

        } catch (Exception $e) {
            DB::rollBack();
            $this->command->error("An error occurred during the import: " . $e->getMessage());
        } finally {
            fclose($fileHandle);
        }
    }
}
