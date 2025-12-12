<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('sql/test.sql');

        if (!file_exists($sqlPath)) {
            $this->command->error("SQL file not found at: {$sqlPath}");
            return;
        }

        $this->command->info("Reading SQL file from: {$sqlPath}");
        $fileSize = filesize($sqlPath);
        $this->command->info("File size: " . number_format($fileSize) . " bytes (" . round($fileSize / 1024 / 1024, 2) . " MB)");

        // Get database connection details
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        $this->command->info("Importing SQL dump using psql...");
        $this->command->warn("This may take several minutes for large files.");

        // Use psql to import the dump (handles COPY ... FROM stdin properly)
        $command = sprintf(
            'PGPASSWORD=%s psql -h %s -p %s -U %s -d %s -f %s 2>&1',
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($database),
            escapeshellarg($sqlPath)
        );

        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            $this->command->info("✓ Database seeded successfully!");

            // Show summary of last few lines
            $lastLines = array_slice($output, -5);
            if (!empty($lastLines)) {
                $this->command->info("Last output lines:");
                foreach ($lastLines as $line) {
                    $this->command->line("  " . $line);
                }
            }
        } else {
            $this->command->error("✗ Error executing SQL dump:");
            $this->command->error("Return code: " . $returnCode);

            // Show error output
            $errorLines = array_slice($output, -20);
            foreach ($errorLines as $line) {
                if (!empty(trim($line))) {
                    $this->command->error($line);
                }
            }

            $this->command->error("\nSeeding failed. Please check the SQL file and database connection.");
            exit(1);
        }
    }
}
