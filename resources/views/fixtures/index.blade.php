<x-app-layout>
    <x-slot name="header">Fixture</x-slot>

    {{-- FILTER STAGE --}}
    <div style="display:flex;gap:6px;overflow-x:auto;padding-bottom:8px;margin-bottom:10px;scrollbar-width:none">
        @foreach ($stages as $key => $label)
        <a href="{{ route('fixtures.index', ['stage' => $key]) }}"
            @style([ 'white-space:nowrap; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none; border:1px solid; flex-shrink:0; transition:all 0.2s;' , 'background:#00ff87; color:#0a0f1e; border-color:#00ff87'=> $stage === $key,
            'background:transparent; color:#64748b; border-color:#1e2d45' => $stage !== $key,
            ])

            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- FILTER GRUP --}}
    @if ($stage === 'group')
    <div style="display:flex;gap:6px;overflow-x:auto;padding-bottom:8px;margin-bottom:16px;scrollbar-width:none">
        <a href="{{ route('fixtures.index', ['stage' => 'group']) }}"
            @style([ 'white-space:nowrap; padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; border:1px solid; flex-shrink:0;' , 'background:#f0f4f8; color:#0a0f1e; border-color:#f0f4f8'=> !$group,
            'background:transparent; color:#64748b; border-color:#1e2d45' => $group,
            ])
            Semua
        </a>
        @foreach ($groups as $key => $label)
        <a href="{{ route('fixtures.index', ['stage' => 'group', 'group' => $key]) }}"
            @style([ 'white-space:nowrap; padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; border:1px solid; flex-shrink:0;' , 'background:#f0f4f8; color:#0a0f1e; border-color:#f0f4f8'=> $group === $key,
            'background:transparent; color:#64748b; border-color:#1e2d45' => $group !== $key,
            ])
            {{ $label }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- LIST FIXTURE --}}
    @forelse ($fixtures as $date => $matches)
    {{-- Date Header --}}
    <div style="font-size:10px;font-weight:700;color:#475569;letter-spacing:2px;text-transform:uppercase;margin:16px 0 8px;padding-left:2px">
        {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
    </div>

    <div style="display:flex;flex-direction:column;gap:8px">
        @foreach ($matches as $match)
        <div class="card" style="padding:14px 16px">

            {{-- Tim & Skor --}}
            <div style="display:flex;align-items:center;gap:8px">

                {{-- Home --}}
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;text-align:center">
                    <span style="font-size:28px">{{ $match->homeTeam->flag_emoji }}</span>
                    <span style="font-size:12px;font-weight:600;color:#f0f4f8;line-height:1.2">
                        {{ $match->homeTeam->name }}
                    </span>
                </div>

                {{-- Tengah --}}
                <div style="min-width:80px;text-align:center">
                    @if ($match->status === 'finished')
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:900;color:#f0f4f8">
                        {{ $match->home_score }} – {{ $match->away_score }}
                    </div>
                    <div style="font-size:10px;color:#475569;margin-top:2px">Selesai</div>
                    @elseif ($match->status === 'live')
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:900;color:#00ff87">
                        {{ $match->home_score ?? 0 }} – {{ $match->away_score ?? 0 }}
                    </div>
                    <span class="live-badge" style="margin-top:4px;display:inline-flex">
                        <span class="live-dot"></span> LIVE
                    </span>
                    @else
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:900;color:#f0f4f8">
                        {{ $match->match_time->timezone('Asia/Jakarta')->format('H:i') }}
                    </div>
                    <div style="font-size:10px;color:#475569">WIB</div>
                    @endif

                    @if ($match->stage === 'group')
                    <div style="font-size:10px;color:#475569;margin-top:4px">Grup {{ $match->group }}</div>
                    @else
                    <div style="font-size:10px;color:#6366f1;margin-top:4px">{{ $match->stages_label }}</div>
                    @endif
                </div>

                {{-- Away --}}
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;text-align:center">
                    <span style="font-size:28px">{{ $match->awayTeam->flag_emoji }}</span>
                    <span style="font-size:12px;font-weight:600;color:#f0f4f8;line-height:1.2">
                        {{ $match->awayTeam->name }}
                    </span>
                </div>

            </div>

            {{-- Venue --}}
            @if ($match->venue)
            <div style="text-align:center;margin-top:10px;font-size:11px;color:#475569">
                📍 {{ $match->venue }}
            </div>
            @endif

        </div>
        @endforeach
    </div>
    @empty
    <div class="empty-state">
        <div class="icon">📭</div>
        <p>Belum ada jadwal untuk tahap ini.</p>
    </div>
    @endforelse

</x-app-layout>