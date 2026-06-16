<x-app-layout>
    <x-slot name="header">Prediksi</x-slot>

    {{-- FLASH --}}
    @if (session('success'))
    <div class="flash-success">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="flash-error">⚠️ {{ session('error') }}</div>
    @endif

    {{-- ── UPCOMING & LIVE ──────────────────── --}}
    <div style="margin-bottom:28px">
        <div class="section-eyebrow">Tebak Sekarang</div>
        <div class="section-title">Upcoming & Live</div>

        @forelse ($upcomingFixtures as $fixture)
        @php
        $prediction = $userPredictions[$fixture->id] ?? null;
        $isLocked = $fixture->isLocked();
        @endphp

        <div class="card" style="margin-bottom:10px">

            {{-- Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                <div>
                    <span style="font-size:11px;color:#64748b">
                        {{ $fixture->match_time->timezone('Asia/Jakarta')->format('d M · H:i') }} WIB
                    </span>
                    {{-- Label babak --}}
                    @if ($fixture->stage === 'group')
                        <span style="font-size:11px;color:#64748b"> · Grup {{ $fixture->group }}</span>
                    @else
                        <div style="margin-top:3px">
                            @php
                                $stageColor = match($fixture->stage) {
                                    'round_of_32'   => ['bg' => 'rgba(99,102,241,0.1)',  'border' => 'rgba(99,102,241,0.3)',  'color' => '#818cf8'],
                                    'round_of_16'   => ['bg' => 'rgba(59,130,246,0.1)',  'border' => 'rgba(59,130,246,0.3)',  'color' => '#60a5fa'],
                                    'quarter_final' => ['bg' => 'rgba(245,158,11,0.1)',  'border' => 'rgba(245,158,11,0.3)',  'color' => '#fbbf24'],
                                    'semi_final'    => ['bg' => 'rgba(239,68,68,0.1)',   'border' => 'rgba(239,68,68,0.3)',   'color' => '#f87171'],
                                    'third_place'   => ['bg' => 'rgba(100,116,139,0.1)', 'border' => 'rgba(100,116,139,0.3)', 'color' => '#94a3b8'],
                                    'final'         => ['bg' => 'rgba(255,215,0,0.1)',   'border' => 'rgba(255,215,0,0.3)',   'color' => '#ffd700'],
                                    default         => ['bg' => 'rgba(100,116,139,0.1)', 'border' => 'rgba(100,116,139,0.3)', 'color' => '#94a3b8'],
                                };
                            @endphp
                            <span style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:2px 8px;border-radius:6px;
                                        background:{{ $stageColor['bg'] }};border:1px solid {{ $stageColor['border'] }};color:{{ $stageColor['color'] }}">
                                {{ $fixture->stages_label }}
                            </span>
                        </div>
                    @endif
                </div>

                @if ($fixture->status === 'live')
                    <span class="live-badge">
                        <span class="live-dot"></span> LIVE
                    </span>
                @elseif ($isLocked)
                    <span style="font-size:11px;color:#475569;font-weight:600">🔒 Terkunci</span>
                @else
                    <span style="font-size:11px;color:#00ff87;font-weight:600">Buka</span>
                @endif
            </div>

            {{-- Tim --}}
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <div style="flex:1;display:flex;align-items:center;gap:8px">
                    <span style="font-size:24px">{{ $fixture->homeTeam->flag_emoji }}</span>
                    <span style="font-size:13px;font-weight:600;color:#f0f4f8">{{ $fixture->homeTeam->name }}</span>
                </div>
                <span style="font-size:11px;font-weight:700;color:#475569">VS</span>
                <div style="flex:1;display:flex;align-items:center;justify-content:flex-end;gap:8px">
                    <span style="font-size:13px;font-weight:600;color:#f0f4f8">{{ $fixture->awayTeam->name }}</span>
                    <span style="font-size:24px">{{ $fixture->awayTeam->flag_emoji }}</span>
                </div>
            </div>

            {{-- Form / Tebakan --}}
            @if (!$isLocked)
            @php
                $homeVal   = old('home_score', $prediction?->home_score ?? null);
                $awayVal   = old('away_score', $prediction?->away_score ?? null);
                $hasValues = !is_null($homeVal) && !is_null($awayVal);
            @endphp
            <form method="POST" action="{{ route('predictions.store') }}">
                @csrf
                <input type="hidden" name="match_id" value="{{ $fixture->id }}">
                <div style="display:flex;align-items:center;gap:8px">
                    <input type="number" name="home_score"
                        id="home-{{ $fixture->id }}"
                        value="{{ $homeVal ?? '' }}"
                        min="0" max="99" step="1"
                        placeholder="0"
                        inputmode="numeric"
                        style="flex:1;background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px;color:#f0f4f8;font-size:22px;font-weight:900;text-align:center;outline:none;font-family:'Barlow Condensed',sans-serif"
                        onfocus="this.style.borderColor='#00ff87'" onblur="this.style.borderColor='#1e2d45'">
                    <span style="color:#475569;font-weight:900;font-size:18px">–</span>
                    <input type="number" name="away_score"
                        id="away-{{ $fixture->id }}"
                        value="{{ $awayVal ?? '' }}"
                        min="0" max="99" step="1"
                        placeholder="0"
                        inputmode="numeric"
                        style="flex:1;background:#0a0f1e;border:1px solid #1e2d45;border-radius:10px;padding:10px;color:#f0f4f8;font-size:22px;font-weight:900;text-align:center;outline:none;font-family:'Barlow Condensed',sans-serif"
                        onfocus="this.style.borderColor='#00ff87'" onblur="this.style.borderColor='#1e2d45'">
                    <button type="submit"
                        id="btn-{{ $fixture->id }}"
                        {{ !$hasValues ? 'disabled' : '' }}
                        style="padding:10px 18px;font-size:13px;font-weight:700;border:none;border-radius:10px;white-space:nowrap;
                           {{ !$hasValues ? 'background:#1e2d45;color:#475569;cursor:not-allowed' : 'background:#00ff87;color:#0a0f1e;cursor:pointer' }}">
                        {{ $prediction ? 'Ubah' : 'Tebak' }}
                    </button>
                </div>
                @if ($prediction)
                <div style="text-align:center;font-size:11px;color:#475569;margin-top:8px">
                    Tebakan kamu: <strong style="color:#94a3b8">{{ $prediction->home_score }} – {{ $prediction->away_score }}</strong>
                </div>
                @endif
            </form>
            @else
            <div style="text-align:center">
                @if ($prediction)
                <div style="font-size:11px;color:#475569;margin-bottom:4px">Tebakan kamu</div>
                <div style="font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:900;color:#94a3b8">
                    {{ $prediction->home_score }} – {{ $prediction->away_score }}
                </div>
                @else
                <div style="font-size:13px;color:#475569;font-style:italic">Tidak memasang tebakan</div>
                @endif
            </div>
            @endif

        </div>
        @empty
        <div class="empty-state">
            <div class="icon">🎉</div>
            <p>Tidak ada pertandingan mendatang saat ini.</p>
        </div>
        @endforelse

        <script>
        function checkBtn(id) {
            const home = document.getElementById('home-' + id);
            const away = document.getElementById('away-' + id);
            const btn  = document.getElementById('btn-' + id);

            if (!home || !away || !btn) return;

            const filled = home.value !== '' && away.value !== '';

            btn.disabled         = !filled;
            btn.style.background = filled ? '#00ff87' : '#1e2d45';
            btn.style.color      = filled ? '#0a0f1e' : '#475569';
            btn.style.cursor     = filled ? 'pointer'  : 'not-allowed';
        }
        function sanitizeInput(el) {
            el.value = el.value.replace(/[^0-9]/g, '');
        }
        document.addEventListener('DOMContentLoaded', function () {
            // Attach event ke semua input home & away
            document.querySelectorAll('input[id^="home-"], input[id^="away-"]').forEach(function (input) {
                const id = input.id.replace('home-', '').replace('away-', '');

                input.addEventListener('input', function () {
                    sanitizeInput(this);
                    checkBtn(id);
                });
            });

            // Cek semua tombol saat halaman load
            document.querySelectorAll('button[id^="btn-"]').forEach(function (btn) {
                const id = btn.id.replace('btn-', '');
                checkBtn(id);
            });
        });
        </script>
    </div>

    {{-- ── HASIL TERBARU ─────────────────────── --}}
    @if ($finishedFixtures->isNotEmpty())
    <div>
        <div class="section-eyebrow">Selesai</div>
        <div class="section-title">Hasil Terbaru</div>

        <div style="display:flex;flex-direction:column;gap:8px">
            @foreach ($finishedFixtures as $fixture)
                @php
                    $prediction = $fixture->predictions->first();
                    $badgeClass = match($prediction?->result_type) {
                        'exact' => 'badge-exact',
                        'close' => 'badge-close',
                        'result' => 'badge-result',
                        'wrong' => 'badge-wrong',
                        default => 'badge-pending',
                    };
                    $badgeLabel = match($prediction?->result_type) {
                        'exact' => 'Exact +3',
                        'close' => 'Close +1.5',
                        'result' => 'Result +1',
                        'wrong' => 'Wrong +0',
                        default => $prediction ? 'Menunggu' : 'Tidak Menebak',
                    };
                @endphp
            
                <div class="card" style="padding:14px 16px">

                    {{-- Baris 1: Tanggal & Stage --}}
                    <div style="font-size:11px;color:#475569;margin-bottom:8px">
                        {{ $fixture->match_time->timezone('Asia/Jakarta')->format('d M · H:i') }} WIB
                        @if ($fixture->stage === 'group')
                            · Grup {{ $fixture->group }}
                        @else
                            · {{ $fixture->stages_label }}
                        @endif
                    </div>

                    {{-- Baris 2: Tim & Skor Aktual --}}
                    <div style="display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:8px;margin-bottom:10px">
                        {{-- Home --}}
                        <div style="display:flex;align-items:center;gap:6px">
                            <span style="font-size:20px;flex-shrink:0">{{ $fixture->homeTeam->flag_emoji }}</span>
                            <span style="font-size:13px;font-weight:600;color:#f0f4f8;line-height:1.2">
                                {{ $fixture->homeTeam->name }}
                            </span>
                        </div>

                        {{-- Skor --}}
                        <div style="text-align:center;min-width:60px">
                            <span style="font-family:'Barlow Condensed',sans-serif;font-size:24px;font-weight:900;color:#f0f4f8">
                                {{ $fixture->home_score }} – {{ $fixture->away_score }}
                            </span>
                        </div>

                        {{-- Away --}}
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
                            <span style="font-size:13px;font-weight:600;color:#f0f4f8;line-height:1.2;text-align:right">
                                {{ $fixture->awayTeam->name }}
                            </span>
                            <span style="font-size:20px;flex-shrink:0">{{ $fixture->awayTeam->flag_emoji }}</span>
                        </div>
                    </div>

                    {{-- Baris 3: Tebakan & Badge --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;padding-top:8px;border-top:1px solid #1e2d45">
                        <div style="font-size:12px;color:#475569">
                            @if ($prediction)
                                Tebakan kamu:
                                <strong style="color:#94a3b8">
                                    {{ $prediction->home_score }} – {{ $prediction->away_score }}
                                </strong>
                            @else
                                <span style="font-style:italic">Tidak memasang tebakan</span>
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;gap:8px">
                            @if ($prediction && $prediction->points !== null)
                                <span style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:900;color:#f0f4f8">
                                    +{{ number_format($prediction->points, 1) }}
                                </span>
                            @endif
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </div>
                    </div>

                </div>
                
            @endforeach
        </div>
    </div>
    @endif

</x-app-layout>