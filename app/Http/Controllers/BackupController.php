<?php

namespace App\Http\Controllers;

class BackupController extends Controller
{
    //
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create backup');
    }
    // Create a backup of the database and return it as a downloadable file.
    public function createBackup()
    {
        $fileName = 'backup_'.date('Y_m_d_H_i_s').'.sql';
        $path = storage_path('app/backup/'.$fileName);
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $mysqldump = "D:\\xampp\\mysql\\bin\\mysqldump.exe";
        if ($password) {
            $command = "\"{$mysqldump}\" --user={$user} --password={$password} {$database} > \"{$path}\"";
        } else {
            $command = "\"{$mysqldump}\" --user={$user} {$database} > \"{$path}\"";
        }system($command, $result);
        if ($result != 0) {
            return back()->with('error', 'Backup failed');
        }
        return response()->download($path);
    }
}
