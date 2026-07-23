<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function logs()
    {
        $logPath = storage_path('logs/laravel.log');
        $logContent = '';

        if (File::exists($logPath)) {
            // ফাইল অনেক বড় হতে পারে, তাই শেষ ৫০০ লাইন দেখাচ্ছি
            $lines = File::lines($logPath)->toArray();
            $logContent = implode("\n", array_slice($lines, -500));
        }

        return view('super-admin.system.logs', compact('logContent'));
    }

    public function backup()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (File::exists($backupPath)) {
            $backups = collect(File::files($backupPath))
                ->map(fn ($file) => [
                    'name' => $file->getFilename(),
                    'size' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                ])
                ->sortByDesc('date')
                ->values();
        }

        return view('super-admin.system.backup', compact('backups'));
    }

    public function info()
    {
        $info = [
            'php_version'     => phpversion(),
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'database_driver' => DB::connection()->getDriverName(),
            'storage_used'    => $this->formatBytes(disk_total_space(storage_path()) - disk_free_space(storage_path())),
            'storage_free'    => $this->formatBytes(disk_free_space(storage_path())),
        ];

        return view('super-admin.system.info', compact('info'));
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}