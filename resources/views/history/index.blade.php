<x-app-layout>
    <x-slot name="header">History</x-slot>

    {{-- FILTER HASIL --}}
    <div style="display:flex;gap:6px;overflow-x:auto;padding-bottom:8px;margin-bottom:8px;scrollbar-width:none">
        @foreach ([null=>'Semua','exact'=>'🟢 Exact','close'=>'🔵 Close','result'=>'🟡 Result','wrong'=>'🔴 Wrong'] as $key => $label)
            <a href="{{ route('history.index', array_filter(['result_type'=>$key,'stage'=>$stage,'group'=>$group])) }}"
               style="white-space:nowrap;padding:6px 12px;border-radius:20px;font-size:11px;font-weight:700;text-decoration:none;border:1px solid;flex-shrink:0;
                      {{ $resultType === $key ? 'background:#f0f4f8;color:#0a0f1e;border-color:#f0f4f8' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- FILTER STAGE --}}
    <div style="display:flex;gap:6px;overflow-x:auto;padding-bottom:8px;margin-bottom:16px;scrollbar-width:none">
        <a href="{{ route('history.index', array_filter(['result_type'=>$resultType])) }}"
           style="white-space:nowrap;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;text-decoration:none;border:1px solid;flex-shrink:0;
                  {{ !$stage ? 'background:#6366f1;color:#fff;border-color:#6366f1' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
            Semua Stage
        </a>
        @foreach ($stages as $key => $label)
            <a href="{{ route('history.index', array_filter(['result_type'=>$resultType,'stage'=>$key])) }}"
               style="white-space:nowrap;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;text-decoration:none;border:1px solid;flex-shrink:0;
                      {{ $stage === $key ? 'background:#6366f1;color:#fff;border-color:#6366f1' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- LIST --}}
    @forelse ($predictions as $prediction)
        @php
            $fixture    = $prediction->fixture;
            $badgeClass = match($prediction->result_type) {
                'exact'  => 'badge-exact',
                'close'  => 'badge-close',
                'result' => 'badge-result',
                'wrong'  => 'badge-wrong',
                default  => 'badge-pending',
            };
            $badgeLabel = match($prediction->result_type) {
                'exact'  => 'Exact', 'close' => 'Close',
                'result' => 'Result', 'wrong' => 'Wrong',
                default  => '–',
            };
        @endphp

        <div class="card" style="padding:14px 16px;margin-bottom:8px">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="flex:1;min-width:0">
                    <div style="font-size:11px;color:#475569;margin-bottom:6px">
                        {{ $fixture->match_time->timezone('Asia/Jakarta')->format('d M Y · H:i') }} WIB
                        · {{ $fixture->stage === 'group' ? 'Grup '.$fixture->group : $fixture->stages_label }}
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:13px;flex-wrap:wrap">
                        <span>{{ $fixture->homeTeam->flag_emoji }}</span>
                        <span style="font-weight:600;color:#f0f4f8">{{ $fixture->homeTeam->name }}</span>
                        <span style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:900;color:#f0f4f8">
                            {{ $fixture->home_score }} – {{ $fixture->away_score }}
                        </span>
                        <span style="font-weight:600;color:#f0f4f8">{{ $fixture->awayTeam->name }}</span>
                        <span>{{ $fixture->awayTeam->flag_emoji }}</span>
                    </div>
                    <div style="font-size:11px;color:#475569;margin-top:5px">
                        Tebakan kamu:
                        <strong style="color:#64748b">{{ $prediction->home_score }} – {{ $prediction->away_score }}</strong>
                    </div>
                </div>
                <div style="flex-shrink:0;text-align:right">
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:24px;font-weight:900;color:#f0f4f8;margin-bottom:4px">
                        +{{ number_format($prediction->points, 1) }}
                    </div>
                    <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>Belum ada riwayat tebakan.</p>
        </div>
    @endforelse

    @if ($predictions->hasPages())
        <div style="margin-top:16px">{{ $predictions->links() }}</div>
    @endif

</x-app-layout>