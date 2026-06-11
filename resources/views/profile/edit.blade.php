<x-app-layout>
    <x-slot name="header">Profil</x-slot>

    {{-- TAB: Profil / Statistik --}}
    <div style="display:flex;gap:8px;margin-bottom:20px">
        <a href="{{ route('profile.edit') }}"
            @style([ 'flex:1; text-align:center; padding:10px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; border:1px solid;' , 'background:#00ff87; color:#0a0f1e; border-color:#00ff87'=> request()->routeIs('profile.*'),
            'background:transparent; color:#64748b; border-color:#1e2d45' => !request()->routeIs('profile.*'),
            ])>
            👤 Profil
        </a>
        <a href="{{ route('statistics.index') }}"
            @style([ 'flex:1; text-align:center; padding:10px; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; border:1px solid;' , 'background:#00ff87; color:#0a0f1e; border-color:#00ff87'=> request()->routeIs('statistics.*'),
            'background:transparent; color:#64748b; border-color:#1e2d45' => !request()->routeIs('statistics.*'),
            ])>
            📊 Statistik
        </a>
    </div>

    {{-- INFO PROFIL --}}
    <div class="card" style="margin-bottom:16px">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:4px">
            Informasi Akun
        </div>
        <div style="font-size:12px;color:#64748b;margin-bottom:20px">
            ⚠️ Data di bawah tidak dapat diubah setelah registrasi
        </div>

        <div style="display:flex;flex-direction:column;gap:14px">

            {{-- Email --}}
            <div>
                <div class="field-label">Email</div>
                <div style="background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;font-size:14px;color:#94a3b8">
                    {{ auth()->user()->email }}
                </div>
            </div>

            {{-- Nickname --}}
            <div>
                <div class="field-label">Nickname</div>
                <div style="background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;font-size:14px;color:#94a3b8">
                    {{ auth()->user()->nickname }}
                </div>
            </div>

            {{-- Akun X --}}
            <div>
                <div class="field-label">Akun X (Twitter)</div>
                <div style="background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;font-size:14px;color:#94a3b8">
                    {{ auth()->user()->x_account }}
                </div>
            </div>

            {{-- Location --}}
            <div>
                <div class="field-label">Kota / Location</div>
                <div style="background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;font-size:14px;color:#94a3b8">
                    {{ auth()->user()->city->name }}
                    @if(auth()->user()->city->region === 'international')
                    , {{ auth()->user()->city->country }}
                    @endif
                </div>
            </div>

            {{-- Supported Team --}}
            <div>
                <div class="field-label">Tim yang Didukung</div>
                <div style="background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px 14px;font-size:14px;color:#94a3b8;display:flex;align-items:center;gap:8px">
                    <span style="font-size:22px">{{ auth()->user()->supportedTeam->flag_emoji }}</span>
                    <span>
                        {{ auth()->user()->supportedTeam->name }}
                        <span style="color:#475569;font-size:12px">(Grup {{ auth()->user()->supportedTeam->group }})</span>
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- GANTI PASSWORD --}}
    <div class="card" style="margin-bottom:16px">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:20px">
            Ganti Password
        </div>

        @if (session('status') === 'password-updated')
        <div class="flash-success">✅ Password berhasil diperbarui.</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:14px">
            @csrf
            @method('PUT')

            <div>
                <label class="field-label" for="current_password">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password"
                    class="field-input" placeholder="••••••••" autocomplete="current-password">
                @error('current_password', 'updatePassword')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="field-label" for="password">Password Baru</label>
                <input id="password" name="password" type="password"
                    class="field-input" placeholder="••••••••" autocomplete="new-password">
                @error('password', 'updatePassword')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="field-input" placeholder="••••••••" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-green" style="margin-top:4px">
                Simpan Password
            </button>
        </form>
    </div>

    {{-- LOGOUT --}}
    <div class="card">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:6px">
            Keluar Akun
        </div>
        <p style="font-size:13px;color:#64748b;margin-bottom:16px">
            Kamu akan keluar dari sesi ini di perangkat yang sedang digunakan.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-danger">Keluar dari Akun</button>
        </form>
    </div>

</x-app-layout>