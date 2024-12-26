<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $path = storage_path('app/backup/' . $filename); // Ścieżka do zapisu kopii

        $dbHost = "127.0.0.1";
        $dbUsername = "root";
        $dbPassword = "password";
        $dbName = "przychodnia";

        $command = "mysqldump -u{$dbUsername} -p{$dbPassword} -h {$dbHost} {$dbName} > {$path}";

        $process = Process::fromShellCommandline($command);
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Backup created successfully at: ' . $path);
        } else {
            $this->error('Error during backup process: ' . $process->getErrorOutput());
        }

    }
}
