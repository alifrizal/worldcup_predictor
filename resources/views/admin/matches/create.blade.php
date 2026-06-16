<x-app-layout>
    <x-slot name="header">Tambah Fixture</x-slot>

    <div class="card">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:20px">
            Fixture Babak Gugur
        </div>

        <form method="POST" action="{{ route('admin.matches.store') }}"
              style="display:flex;flex-direction:column;gap:16px">
            @csrf

            {{-- Stage --}}
            <div>
                <label class="field-label">Babak / Stage</label>
                <select name="stage" class="field-input" required>
                    <option value="">-- Pilih Babak --</option>
                    @foreach ($stages as $key => $label)
                        <option value="{{ $key }}" {{ old('stage') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('stage')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tim Kandang --}}
            <div>
                <label class="field-label">Tim Kandang (Home)</label>
                <select name="home_team_id" class="field-input" required>
                    <option value="">-- Pilih Tim --</option>
                    @foreach ($teams->groupBy('group') as $group => $groupTeams)
                        <optgroup label="Grup {{ $group }}">
                            @foreach ($groupTeams as $team)
                                <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->flag_emoji }} {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('home_team_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tim Tamu --}}
            <div>
                <label class="field-label">Tim Tamu (Away)</label>
                <select name="away_team_id" class="field-input" required>
                    <option value="">-- Pilih Tim --</option>
                    @foreach ($teams->groupBy('group') as $group => $groupTeams)
                        <optgroup label="Grup {{ $group }}">
                            @foreach ($groupTeams as $team)
                                <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->flag_emoji }} {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('away_team_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Waktu --}}
            <div>
                <label class="field-label">Tanggal & Waktu (WIB)</label>
                <input type="datetime-local" name="match_time"
                       value="{{ old('match_time') }}"
                       class="field-input"
                       required>
                @error('match_time')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Venue --}}
            <div>
                <label class="field-label">Venue (Opsional)</label>
                <input type="text" name="venue"
                       value="{{ old('venue') }}"
                       placeholder="contoh: MetLife Stadium"
                       class="field-input">
                @error('venue')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Info --}}
            <div style="background:rgba(99,102,241,0.06);border:1px solid rgba(99,102,241,0.2);border-radius:10px;padding:12px 14px;font-size:12px;color:#94a3b8">
                💡 Tim bisa diubah nanti setelah babak grup selesai dan tim yang lolos sudah diketahui.
            </div>

            {{-- Buttons --}}
            <div style="display:flex;gap:10px;margin-top:4px">
                <button type="submit" class="btn-green">
                    Tambah Fixture
                </button>
                <a href="{{ route('admin.matches.index') }}" class="btn-outline">
                    Batal
                </a>
            </div>

        </form>
    </div>

</x-app-layout>