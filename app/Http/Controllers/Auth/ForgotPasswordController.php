<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ForgotPasswordController extends Controller
{
    protected int $otpLength = 6;
    protected int $otpExpiryMinutes = 5;
    protected int $maxAttempts = 5;

    /**
     * Step 1: show the "enter your email" form.
     */
    public function showEmailForm()
    {
        return view('auth.forgot-password-email');
    }

    /**
     * Step 1: look up the account by email, send an OTP to that email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'We could not find an account with that email.',
            ]);
        }

        $this->issueOtp($user);

        session([
            'otp_user_id' => $user->user_id,
            'otp_verified' => false,
        ]);

        return redirect()->route('password.otp.verify.show');
    }

    /**
     * Step 2: show the "enter the code" form.
     */
    public function showVerifyForm()
    {
        if (! session('otp_user_id')) {
            return redirect()->route('password.otp.request');
        }

        $user = User::find(session('otp_user_id'));

        return view('auth.forgot-password-verify', [
            'maskedEmail' => $this->maskEmail($user->email),
            'expiryMinutes' => $this->otpExpiryMinutes,
        ]);
    }

    /**
     * Step 2: check the submitted code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:' . $this->otpLength],
        ]);

        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('password.otp.request');
        }

        $otp = PasswordOtp::where('user_id', $userId)->first();

        if (! $otp || $otp->expires_at->isPast()) {
            return back()->withErrors([
                'code' => 'This code has expired. Please request a new one.',
            ]);
        }

        if ($otp->attempts >= $this->maxAttempts) {
            return back()->withErrors([
                'code' => 'Too many incorrect attempts. Please request a new code.',
            ]);
        }

        if (! Hash::check($request->code, $otp->code_hash)) {
            $otp->increment('attempts');

            return back()->withErrors([
                'code' => 'Incorrect code. Please try again.',
            ]);
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.otp.reset.show');
    }

    /**
     * Step 2b: resend a fresh code (invalidates the old one).
     */
    public function resend()
    {
        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('password.otp.request');
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('password.otp.request');
        }

        $this->issueOtp($user);

        return back()->with('status', 'A new code has been sent.');
    }

    /**
     * Step 3: show the "set new password" form. Only reachable
     * after a code has been verified this session.
     */
    public function showResetForm()
    {
        if (! session('otp_verified')) {
            return redirect()->route('password.otp.request');
        }

        return view('auth.forgot-password-reset');
    }

    /**
     * Step 3: save the new password.
     */
    public function resetPassword(Request $request)
    {
        if (! session('otp_verified') || ! session('otp_user_id')) {
            return redirect()->route('password.otp.request');
        }

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::findOrFail(session('otp_user_id'));

        $user->forceFill([
            'password_hash' => Hash::make($request->password),
        ])->save();

        PasswordOtp::where('user_id', $user->user_id)->delete();

        session()->forget(['otp_user_id', 'otp_verified']);

        return redirect()->route('login')
            ->with('status', 'Your password has been reset. Please log in.');
    }

    /**
     * Generate a fresh code, store its hash, and email it.
     */
    protected function issueOtp(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), $this->otpLength, '0', STR_PAD_LEFT);

        PasswordOtp::where('user_id', $user->user_id)->delete();

        PasswordOtp::create([
            'user_id' => $user->user_id,
            'code_hash' => Hash::make($code),
            'attempts' => 0,
            'expires_at' => now()->addMinutes($this->otpExpiryMinutes),
        ]);

        Mail::to($user->email)->send(
            new PasswordOtpMail($code, $this->otpExpiryMinutes)
        );
    }

    protected function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email);

        $visible = min(2, strlen($name));
        $masked = substr($name, 0, $visible) . str_repeat('•', max(strlen($name) - $visible, 1));

        return $masked . '@' . $domain;
    }
}