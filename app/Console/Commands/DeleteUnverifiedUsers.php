<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;

class DeleteUnverifiedUsers extends Command
{
    protected $signature = 'users:delete-unverified';
    protected $description = 'Xóa người dùng hoặc admin chưa xác minh email sau 3 ngày';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy tất cả user chưa xác minh email và đã đăng ký quá 3 ngày
        $users = User::whereNull('email_verified_at')
                      ->where('created_at', '<', Carbon::now()->subDays(3))
                      ->get();

        foreach ($users as $user) {
            $user->delete();  // Xóa user chưa xác minh email
        }

        $this->info('Đã xóa các người dùng và admin chưa xác minh email sau 3 ngày.');
    }
}
