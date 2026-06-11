<x-guest-layout>
    <div style="margin-bottom:24px">
        <h1 style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:28px;color:#f0f4f8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">
            Masuk
        </h1>
        <p style="font-size:13px;color:#64748b">Masukkan email dan password kamu</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
    <div class="flash-success" style="margin-bottom:20px">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px">
        @csrf

        {{-- Email --}}
        <div>
            <label class="field-label" for="email">Email</label>
            <input
                id="email" name="email" type="email"
                class="field-input"
                value="{{ old('email') }}"
                placeholder="kamu@email.com"
                required autofocus autocomplete="email">
            @error('email')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="field-label" for="password">Password</label>
            <input
                id="password" name="password" type="password"
                class="field-input"
                placeholder="••••••••"
                required autocomplete="current-password">
            @error('password')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div style="display:flex;align-items:center;gap:8px">
            <input id="remember_me" name="remember" type="checkbox"
                style="width:16px;height:16px;accent-color:#00ff87;cursor:pointer">
            <label for="remember_me" style="font-size:13px;color:#64748b;cursor:pointer">
                Ingat saya
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-green" style="margin-top:4px">
            Masuk →
        </button>

        {{-- Register link --}}
        <p style="text-align:center;font-size:13px;color:#64748b">
            Belum punya akun?
            <a href="{{ route('register') }}"
                style="color:#00ff87;font-weight:600;text-decoration:none">
                Daftar sekarang
            </a>
        </p>
    </form>
</x-guest-layout>