<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $credentials = ['email' => $this->email, 'password' => $this->password];

        $loggedIn = false;

        // Intentar con el guard 'web' (users)
        if (Auth::guard('web')->attempt($credentials, $this->remember)) {
            $loggedIn = true;
            Auth::setDefaultDriver('web');
        }

        // Intentar con el guard 'patient' (patients)
        elseif (Auth::guard('patient')->attempt($credentials, $this->remember)) {
            $loggedIn = true;
            Auth::setDefaultDriver('patient');
        }

        if (! $loggedIn) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());


        $user = Auth::user();

        if ($user instanceof \App\Models\Patient) {
            $this->redirectIntended('/patient-dashboard', navigate: true);
        } elseif ($user->role === 'Administrativo') {
            $this->redirectIntended('/dashboard-reports', navigate: true);

        } else {
            $this->redirectIntended('/xrex', navigate: true);
        }
        Session::regenerate();
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
