<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Fonnte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    use Fonnte;

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('otp', $request->otp)
                    ->where('otp_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kadaluarsa.']);
        }

        $user->email_verified_at = Carbon::now();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('temp_user_id');
        if (!$userId) {
            return redirect()->route('register')->withErrors(['auth' => 'Sesi telah berakhir. Silakan daftar ulang.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register')->withErrors(['auth' => 'User tidak ditemukan. Silakan daftar ulang.']);
        }

        if (empty($user->phone)) {
            return back()->withErrors(['phone' => 'Nomor telepon tidak tersedia.']);
        }

        try {
            $this->sendOTP($user);
            return back()->with('success', 'OTP baru telah dikirim ke WhatsApp Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    private function sendOTP(User $user)
    {
        $otp = Str::random(6);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        $message = "Kode OTP Anda adalah: {$otp}";
        $response = $this->send_message($user->phone, $message);

        // Handle response jika diperlukan
    }
}