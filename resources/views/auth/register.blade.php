<x-guest-layout>
    <div style="margin-bottom:24px">
        <h1 style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:28px;color:#f0f4f8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">
            Buat Akun
        </h1>
        <p style="font-size:13px;color:#64748b">Data tidak dapat diubah setelah registrasi</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px">
        @csrf

        {{-- FULLNAME --}}
        <div>
            <label class="field-label" for="name">Full Name</label>
            <input
                id="name" name="name" type="text"
                class="field-input"
                value="{{ old('name') }}"
                placeholder="contoh: Alif Rizal"
                required autocomplete="off"
                x-data @input="$el.value">
            @error('name')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

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

        {{-- Nickname --}}
        <div>
            <label class="field-label" for="nickname">Nickname</label>
            <input
                id="nickname" name="nickname" type="text"
                class="field-input"
                value="{{ old('nickname') }}"
                placeholder="contoh: alifrizal"
                required autocomplete="off"
                x-data @input="$el.value = $el.value.toLowerCase()">
            <div style="font-size:11px;color:#64748b;margin-top:4px">
                Hanya huruf, angka, dan underscore. Tidak bisa diubah.
            </div>
            @error('nickname')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Akun X --}}
        <div>
            <label class="field-label" for="x_account">Akun X (Twitter)</label>
            <div style="position:relative">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748b;font-size:14px;pointer-events:none">@</span>
                <input
                    id="x_account" name="x_account" type="text"
                    class="field-input"
                    style="padding-left:28px"
                    value="{{ old('x_account') }}"
                    placeholder="username_x"
                    required autocomplete="off"
                    x-data @input="$el.value = $el.value.toLowerCase()">
            </div>
            <div style="font-size:11px;color:#64748b;margin-top:4px">
                Hanya huruf, angka, dan underscore. Tidak bisa diubah.
            </div>
            @error('x_account')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Location --}}
        <div>
            <label class="field-label" for="location_id">Kota / Location</label>
            <select id="location_id" name="location_id" class="field-input" required>
                <option value="">-- Pilih Kota --</option>
                <optgroup label="🇮🇩 Indonesia">
                    @foreach ($cities->where('region', 'indonesia') as $city)
                    <option value="{{ $city->id }}" {{ old('location_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                    @endforeach
                </optgroup>
                <optgroup label="🌍 Internasional">
                    @foreach ($cities->where('region', 'international') as $city)
                    <option value="{{ $city->id }}" {{ old('location_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}, {{ $city->country }}
                    </option>
                    @endforeach
                </optgroup>
            </select>
            <div style="font-size:11px;color:#64748b;margin-top:4px">Tidak bisa diubah setelah daftar.</div>
            @error('location_id')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Supported Team --}}
        <div>
            <label class="field-label" for="supported_team_id">Tim yang Didukung</label>
            <select id="supported_team_id" name="supported_team_id" class="field-input" required>
                <option value="">-- Pilih Tim --</option>
                @foreach ($teams->groupBy('group') as $group => $groupTeams)
                <optgroup label="Grup {{ $group }}">
                    @foreach ($groupTeams as $team)
                    <option value="{{ $team->id }}" {{ old('supported_team_id') == $team->id ? 'selected' : '' }}>
                        {{ $team->flag_emoji }} {{ $team->name }}
                    </option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
            <div style="font-size:11px;color:#64748b;margin-top:4px">Tidak bisa diubah setelah daftar.</div>
            @error('supported_team_id')
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
                required autocomplete="new-password">
            @error('password')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
            <input
                id="password_confirmation" name="password_confirmation" type="password"
                class="field-input"
                placeholder="••••••••"
                required autocomplete="new-password">
            @error('password_confirmation')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-green" style="margin-top:4px">
            Buat Akun →
        </button>

        {{-- Login link --}}
        <p style="text-align:center;font-size:13px;color:#64748b">
            Sudah punya akun?
            <a href="{{ route('login') }}"
                style="color:#00ff87;font-weight:600;text-decoration:none">
                Masuk di sini
            </a>
        </p>
    </form>
</x-guest-layout>