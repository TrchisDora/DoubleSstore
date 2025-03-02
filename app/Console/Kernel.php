<?php

namespace App\Console;

use App\Console\Commands\DeleteUnverifiedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Các lệnh Artisan của ứng dụng.
     *
     * @var array
     */
    protected $commands = [
        DeleteUnverifiedUsers::class, // Đăng ký lệnh mới
    ];

    /**
     * Định nghĩa các tác vụ cần chạy theo lịch.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Xử lý tác vụ định kỳ để xóa người dùng chưa xác thực sau 3 ngày
        $schedule->command('users:delete-unverified')->daily(); // Chạy mỗi ngày
    }

    /**
     * Đăng ký các lệnh Artisan của ứng dụng.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
