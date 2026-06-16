<x-app-layout>
    <x-slot name="header">Update Skor</x-slot>

    <div class="card">
        {{-- Info Match --}}
        <div style="text-align:center;margin-bottom:24px">
            <div style="font-size:12px;color:#475569;margin-bottom:12px">
                {{ $fixture->match_time->timezone('Asia/Jakarta')->format('d M Y · H:i') }} WIB
                @if ($fixture->group) · Grup {{ $fixture->group }} @endif
            </div>
            <div style="display:flex;align-items:center;justify-content:center;gap:20px">
                <div style="text-align:center">
                    <div style="font-size:36px">{{ $fixture->homeTeam->flag_emoji }}</div>
                    <div style="font-size:13px;font-weight:600;color:#f0f4f8;margin-top:6px">
                        {{ $fixture->homeTeam->name }}
                    </div>
                </div>
                <div style="font-size:18px;font-weight:900;color:#475569">VS</div>
                <div style="text-align:center">
                    <div style="font-size:36px">{{ $fixture->awayTeam->flag_emoji }}</div>
                    <div style="font-size:13px;font-weight:600;color:#f0f4f8;margin-top:6px">
                        {{ $fixture->awayTeam->name }}
                    </div>
                </div>
            </div>
        </div>

        <hr class="divider">

        @if ($isKnockout)
            {{-- Update Tim (khusus babak gugur) --}}
            <div style="margin-bottom:16px">
                <label class="field-label">Tim Kandang (Home)</label>
                <select name="home_team_id" class="field-input">
                    @foreach ($teams->groupBy('group') as $group => $groupTeams)
                        <optgroup label="Grup {{ $group }}">
                            @foreach ($groupTeams as $team)
                                <option value="{{ $team->id }}"
                                    {{ $fixture->home_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->flag_emoji }} {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:16px">
                <label class="field-label">Tim Tamu (Away)</label>
                <select name="away_team_id" class="field-input">
                    @foreach ($teams->groupBy('group') as $group => $groupTeams)
                        <optgroup label="Grup {{ $group }}">
                            @foreach ($groupTeams as $team)
                                <option value="{{ $team->id }}"
                                    {{ $fixture->away_team_id == $team->id ? 'selected' : '' }}>
                                    {{ $team->flag_emoji }} {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:16px">
                <label class="field-label">Tanggal & Waktu (WIB)</label>
                <input type="datetime-local" name="match_time"
                    value="{{ $fixture->match_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}"
                    class="field-input">
            </div>

            <div style="margin-bottom:16px">
                <label class="field-label">Venue</label>
                <input type="text" name="venue"
                    value="{{ old('venue', $fixture->venue) }}"
                    placeholder="contoh: MetLife Stadium"
                    class="field-input">
            </div>

            <hr class="divider">
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.matches.update', $fixture) }}">
            @csrf
            @method('PATCH')

            {{-- Status --}}
            <div style="margin-bottom:16px">
                <label class="field-label">Status Pertandingan</label>
                <select name="status" class="field-input">
                    <option value="scheduled" {{ $fixture->status === 'scheduled' ? 'selected' : '' }}>
                        🔵 Terjadwal
                    </option>
                    <option value="live" {{ $fixture->status === 'live' ? 'selected' : '' }}>
                        🟢 Live / Sedang Berlangsung
                    </option>
                    <option value="finished" {{ $fixture->status === 'finished' ? 'selected' : '' }}>
                        ⚫ Selesai
                    </option>
                </select>
                @error('status')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Skor --}}
            <div style="margin-bottom:24px">
                <label class="field-label">Skor Akhir</label>
                <div style="display:grid;grid-template-columns:1fr auto 1fr;gap:10px;align-items:center">
                    <div>
                        <div style="font-size:11px;color:#475569;text-align:center;margin-bottom:6px">
                            {{ $fixture->homeTeam->name }}
                        </div>
                        <input type="number" name="home_score"
                               value="{{ old('home_score', $fixture->home_score ?? 0) }}"
                               min="0" max="99" step="1"
                               inputmode="numeric"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                               class="field-input"
                               style="text-align:center;font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;padding:12px">
                        @error('home_score')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:900;color:#475569;padding-top:20px">
                        –
                    </div>

                    <div>
                        <div style="font-size:11px;color:#475569;text-align:center;margin-bottom:6px">
                            {{ $fixture->awayTeam->name }}
                        </div>
                        <input type="number" name="away_score"
                               value="{{ old('away_score', $fixture->away_score ?? 0) }}"
                               min="0" max="99" step="1"
                               inputmode="numeric"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                               class="field-input"
                               style="text-align:center;font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;padding:12px">
                        @error('away_score')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Info evaluasi --}}
            <div style="background:rgba(255,215,0,0.06);border:1px solid rgba(255,215,0,0.2);border-radius:10px;padding:12px 14px;margin-bottom:20px;font-size:12px;color:#94a3b8">
                💡 Jika status diset ke <strong style="color:#ffd700">Selesai</strong>, poin semua prediksi untuk match ini akan dievaluasi otomatis.
            </div>

            {{-- Buttons --}}
            <div style="display:flex;gap:10px">
                <button type="submit" class="btn-green">
                    Simpan
                </button>
                <a href="{{ route('admin.matches.index') }}" class="btn-outline">
                    Batal
                </a>
            </div>

        </form>
    </div>

</x-app-layout>