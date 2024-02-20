<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\AppNotify;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ExpireBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:booking:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check if booking is in pending more then 1 minute change booking status to expire.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingBookings =  Booking::where('status', 'pending')->get();
        foreach ($pendingBookings as $booking) {
            $diffInSeconds = $booking->created_at->diffInSeconds(Carbon::now());
            if ($diffInSeconds > 60) {
                $pendingIds = json_decode($booking->pending_ids);
                if ($pendingIds) {
                    $drivers = User::whereIn('id', $pendingIds)->get();
                    foreach ($drivers as $driver) {
                        $token = $driver->push_token;
                        Notification::send($driver, new AppNotify("Request Expire", "booking request expired.", $token, ['type' => "expire", 'data' => $booking]));
                    }
                }
                $rider = User::find($booking->rider_id);
                $riderToken = $rider->push_token;
                Notification::send($rider, new AppNotify("Request Expire", "booking request expired.", $riderToken, ['type' => "expire", 'data' => $booking]));
                $rider->ride_status = 'available';
                $rider->save();
                $booking->status = 'expired';
                $booking->cronjob_at = Carbon::now();
                $booking->save();
                Log::info("booking $booking->booking_nr is expired.");
            }
        }
    }
}
