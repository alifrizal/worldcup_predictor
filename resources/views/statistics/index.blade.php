<x-app-layout>
    <x-slot name="header">Statistik</x-slot>

    {{-- TAB --}}
    <div style="display:flex;gap:8px;margin-bottom:20px">
        <a href="{{ route('profile.edit') }}"
            style="flex:1;text-align:center;padding:10px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid;
                  background:transparent;color:#64748b;border-color:#1e2d45">
            👤 Profil
        </a>
        <a href="{{ route('statistics.index') }}"
            style="flex:1;text-align:center;padding:10px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;border:1px solid;
                  background:#00ff87;color:#0a0f1e;border-color:#00ff87">
            📊 Statistik
        </a>
    </div>

    {{-- OVERVIEW --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px">
        <div class="card" style="text-align:center;padding:16px 8px">
            <div style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;color:#00ff87;line-height:1">
                {{ number_format($totalPoints, 1) }}
            </div>
            <div style="font-size:10px;color:#64748b;font-weight:600;margin-top:4px;letter-spacing:0.5px">Total Poin</div>
        </div>
        <div class="card" style="text-align:center;padding:16px 8px">
            <div style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;color:#ffd700;line-height:1">
                {{ $overallRank ? '#'.$overallRank : '–' }}
            </div>
            <div style="font-size:10px;color:#64748b;font-weight:600;margin-top:4px;letter-spacing:0.5px">Global Rank</div>
        </div>
        <div class="card" style="text-align:center;padding:16px 8px">
            <div style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;color:#f0f4f8;line-height:1">
                {{ $totalPlayers }}
            </div>
            <div style="font-size:10px;color:#64748b;font-weight:600;margin-top:4px;letter-spacing:0.5px">Total Player</div>
        </div>
    </div>

    {{-- BREAKDOWN --}}
    <div class="card" style="margin-bottom:16px">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:16px">
            Breakdown Tebakan
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:16px">
            @foreach ([
            ['label'=>'Exact', 'count'=>$exact, 'pts'=>'3 pts', 'color'=>'#00ff87', 'bg'=>'rgba(0,255,135,0.06)', 'border'=>'rgba(0,255,135,0.2)'],
            ['label'=>'Close', 'count'=>$close, 'pts'=>'1.5 pts', 'color'=>'#60a5fa', 'bg'=>'rgba(96,165,250,0.06)', 'border'=>'rgba(96,165,250,0.2)'],
            ['label'=>'Result', 'count'=>$result, 'pts'=>'1 pts', 'color'=>'#ffd700', 'bg'=>'rgba(255,215,0,0.06)', 'border'=>'rgba(255,215,0,0.2)'],
            ['label'=>'Wrong', 'count'=>$wrong, 'pts'=>'0 pts', 'color'=>'#f87171', 'bg'=>'rgba(248,113,113,0.06)', 'border'=>'rgba(248,113,113,0.2)'],
            ] as $item)
            @php $pct = $totalEvaluated > 0 ? round($item['count'] / $totalEvaluated * 100) : 0; @endphp
            <div style="background:{{ $item['bg'] }};border:1px solid {{ $item['border'] }};border-radius:12px;padding:14px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                    <span style="font-size:11px;font-weight:700;color:{{ $item['color'] }};letter-spacing:1px;text-transform:uppercase">
                        {{ $item['label'] }}
                    </span>
                    <span style="font-size:10px;color:#475569">{{ $item['pts'] }}</span>
                </div>
                <div style="font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:900;color:#f0f4f8;line-height:1;margin-bottom:8px">
                    {{ $item['count'] }}
                    <span style="font-size:14px;font-weight:400;color:#64748b">/ {{ $pct }}%</span>
                </div>
                <div style="height:4px;background:#1e2d45;border-radius:2px;overflow:hidden">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $item['color'] }};border-radius:2px;transition:width 0.5s"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="display:flex;justify-content:space-between;font-size:11px;color:#475569;padding-top:12px;border-top:1px solid #1e2d45">
            <span>Dievaluasi: <strong style="color:#94a3b8">{{ $totalEvaluated }}</strong></span>
            <span>Total tebakan: <strong style="color:#94a3b8">{{ $totalPredictions }}</strong></span>
        </div>
    </div>

    {{-- POIN PER STAGE --}}
    @if (!empty($pointsPerStage))
    <div class="card">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:700;text-transform:uppercase;color:#f0f4f8;margin-bottom:16px">
            Poin per Stage
        </div>
        @php $maxStagePoints = max(array_values($pointsPerStage) ?: [1]); @endphp
        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach ($stageLabels as $key => $label)
            @php $pts = $pointsPerStage[$key] ?? 0; @endphp
            <div>
                <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px">
                    <span style="color:#64748b">{{ $label }}</span>
                    <span style="font-weight:700;color:#f0f4f8">{{ $pts > 0 ? number_format($pts, 1) : '–' }}</span>
                </div>
                <div style="height:6px;background:#1e2d45;border-radius:3px;overflow:hidden">
                    <div style="height:100%;width:{{ $maxStagePoints > 0 ? ($pts / $maxStagePoints * 100) : 0 }}%;background:#6366f1;border-radius:3px"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</x-app-layout>