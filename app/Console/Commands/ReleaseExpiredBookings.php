<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class ReleaseExpiredBookings extends Command
{
    protected $signature = 'bookings:release-expired';
    protected $description = 'Release workstations from expired bookings';

    public function handle()
    {
        $now = Carbon::now();
        
        // Находим все активные бронирования, срок которых истек
        $expiredBookings = Booking::where('status', 'active')
            ->where('end_time', '<', $now)
            ->get();
            
        foreach ($expiredBookings as $booking) {
            // Получаем все рабочие станции, связанные с этим бронированием
            $workstations = $booking->workstations;
                
            // Освобождаем рабочие станции
            foreach ($workstations as $workstation) {
                $workstation->status = 'Свободно';
                $workstation->save();
            }
                
            // Обновляем статус бронирования
            $booking->status = 'completed';
            $booking->save();
            
            $this->info("Завершено бронирование #{$booking->id}");
        }
        
        $this->info("Завершено " . $expiredBookings->count() . " истекших бронирований.");
    }
}