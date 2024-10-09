<?php

namespace App\Console\Commands;

use App\Models\Jadwal;
use App\Models\Notification;
use App\Traits\Fonnte;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendBookingNotification extends Command
{
    use Fonnte;

    protected $signature = 'app:send-booking-notification';
    protected $description = 'Send notifications based on user settings before the futsal match starts.';

    public function handle()
    {
        try {
            $now = Carbon::now('Asia/Jakarta');
            
            // Ambil semua pengaturan notifikasi yang aktif
            $notifications = Notification::where('is_active', true)->get();

            Jadwal::where('status', 'booked')
                ->where('date', '>=', $now->toDateString())
                ->with(['bookingItem.booking', 'bookingItem.booking.user.notifications'])
                ->chunk(100, function ($jadwals) use ($now, $notifications) {
                    foreach ($jadwals as $jadwal) {
                        $this->processJadwal($jadwal, $now, $notifications);
                    }
                });

            $this->info('Proses pengingat pemesanan selesai.');
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Error in SendBookingNotification: ' . $e->getMessage());
        }
    }

    private function processJadwal($jadwal, $now, $notifications)
    {
        $jadwalDateTime = Carbon::parse($jadwal->date . ' ' . $jadwal->start_time);
        
        foreach ($jadwal->bookingItem as $bookingItem) {
            $user = $bookingItem->booking->user;
            $phoneNumber = $bookingItem->booking->phone;

            foreach ($user->notifications as $notification) {
                if (!$notification->is_active) continue;

                $notificationTime = $jadwalDateTime->copy()->subMinutes($notification->minutes_before);
                
                // Cek apakah sekarang adalah waktu untuk mengirim notifikasi
                if ($now->between($notificationTime->copy()->subMinutes(1), $notificationTime->copy()->addMinutes(1))) {
                    $cacheKey = "notification_sent_{$jadwal->id}_{$notification->id}_{$notificationTime->format('YmdHi')}";
                    
                    if (!Cache::has($cacheKey)) {
                        $this->sendNotification($jadwal, $phoneNumber, $notification->minutes_before);
                        Cache::put($cacheKey, true, now()->addHours(1));
                    }
                }
            }
        }
    }

    private function sendNotification($jadwal, $phoneNumber, $minutesBefore)
    {
        $jadwalDateTime = Carbon::parse($jadwal->date . ' ' . $jadwal->start_time);
        
        if ($minutesBefore <= 1) {
            $message = "Pengingat: Pertandingan futsal Anda pada {$jadwalDateTime->format('d-m-Y')} pukul {$jadwalDateTime->format('H:i')} akan dimulai sekarang!";
        } else {
            $message = "Pengingat: Pertandingan futsal Anda pada {$jadwalDateTime->format('d-m-Y')} pukul {$jadwalDateTime->format('H:i')} akan dimulai dalam {$minutesBefore} menit!";
        }

        $result = $this->send_message($phoneNumber, $message);

        if ($result) {
            $this->info("Pengingat terkirim untuk jadwal yang dimulai pada {$jadwalDateTime->format('d-m-Y H:i')} ke nomor {$phoneNumber}");
        } else {
            $this->warn("Gagal mengirim pengingat ke nomor {$phoneNumber}");
        }
        Log::info("Pengingat berhasil dikirim ke nomor {$phoneNumber}");
    }
}