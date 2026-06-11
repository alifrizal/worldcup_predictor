@if ($rankings->isEmpty())
    <div class="empty-state">
        <div class="icon">🏆</div>
        <p>Belum ada data ranking.</p>
    </div>
@else
    <div style="display:flex;flex-direction:column;gap:6px">
        @foreach ($rankings as $index => $row)
            @php
                $rank          = $index + 1;
                $isCurrentUser = $row->user_id === Auth::id();
            @endphp
            <div style="border-radius:12px;border:1px solid;padding:12px 14px;display:flex;align-items:center;gap:10px;
                        {{ $isCurrentUser ? 'background:rgba(99,102,241,0.08);border-color:rgba(99,102,241,0.3)' : 'background:#111827;border-color:#1e2d45' }}">
                <div style="width:32px;text-align:center;flex-shrink:0">
                    @if ($rank === 1) <span style="font-size:20px">🥇</span>
                    @elseif ($rank === 2) <span style="font-size:20px">🥈</span>
                    @elseif ($rank === 3) <span style="font-size:20px">🥉</span>
                    @else <span style="font-size:13px;font-weight:700;color:#475569">#{{ $rank }}</span>
                    @endif
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:14px;font-weight:700;color:#f0f4f8;display:flex;align-items:center;gap:6px">
                        {{ $row->nickname }}
                        @if ($isCurrentUser)
                            <span style="font-size:10px;color:#6366f1;font-weight:600">(kamu)</span>
                        @endif
                    </div>
                    <div style="font-size:11px;color:#475569;margin-top:2px">
                        {{ $row->team_flag }} {{ $row->team_name }} · {{ $row->city_name }}
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <div style="font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:900;color:#f0f4f8;line-height:1">
                        {{ number_format($row->total_points, 1) }}
                        <span style="font-size:11px;font-weight:400;color:#475569">pts</span>
                    </div>
                    <div style="font-size:10px;color:#475569;margin-top:2px">
                        {{ $row->total_predictions }}x · {{ $row->exact_count }}x exact
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif