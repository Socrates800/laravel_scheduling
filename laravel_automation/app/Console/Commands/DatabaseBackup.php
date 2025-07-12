<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class DatabaseBackup extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup the database and email the admin';

    public function handle()
    {
        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $fileName = "backup_{$date}.sql";
        $backupPath = storage_path("app/backups/{$fileName}");

        try {
            // Make sure backups directory exists
            if (!file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0777, true);
            }

            // DB credentials
            $db = config('database.connections.mysql');
            $command = "mysqldump --user=\"{$db['username']}\" --password=\"{$db['password']}\" --host=\"{$db['host']}\" \"{$db['database']}\" > \"{$backupPath}\"";


            $result = null;
            system($command, $result);

            if ($result !== 0) {
                throw new Exception("Backup command failed with code: {$result}");
            }

            Log::info("Database backup successful: {$fileName}");

            Mail::to('admin@example.com')->send(new \App\Mail\BackupStatusMail(true, $fileName));

            return Command::SUCCESS;
        } catch (Exception $e) {
            Log::error("Database backup failed: " . $e->getMessage());

            Mail::to('admin@example.com')->send(new \App\Mail\BackupStatusMail(false, '', $e->getMessage()));

            return Command::FAILURE;
        }
    }
}
