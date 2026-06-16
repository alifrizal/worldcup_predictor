<x-app-layout>
    <x-slot name="header">Admin</x-slot>

    {{-- Flash --}}
    @if (session('success'))
        <div class="flash-success">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="flash-error">⚠️ {{ session('error') }}</div>
    @endif

    {{-- Quick link ke profil untuk admin --}}
    <div style="display:flex;justify-content:flex-end;margin-bottom:12px">
        <a href="{{ route('profile.edit') }}"
        style="font-size:12px;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:6px">
            👤 {{ Auth::user()->nickname }}
        </a>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <div style="font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:700;text-transform:uppercase;color:#f0f4f8">
            Kelola Match
        </div>
        <a href="{{ route('admin.matches.create') }}"
        style="padding:8px 16px;background:#00ff87;color:#0a0f1e;font-size:13px;font-weight:700;border-radius:8px;text-decoration:none">
            + Tambah Fixture
        </a>
    </div>

    {{-- Filter Status --}}
    <div style="display:flex;gap:6px;overflow-x:auto;padding-bottom:8px;margin-bottom:16px;scrollbar-width:none">
        @foreach (['' => 'Semua', 'scheduled' => 'Terjadwal', 'live' => 'Live', 'finished' => 'Selesai'] as $key => $label)
            <a href="{{ route('admin.matches.index', $key ? ['status' => $key] : []) }}"
               style="white-space:nowrap;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;text-decoration:none;border:1px solid;flex-shrink:0;
                      {{ request('status', '') === $key ? 'background:#00ff87;color:#0a0f1e;border-color:#00ff87' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- List Match --}}
    <div style="display:flex;flex-direction:column;gap:8px">
        @forelse ($fixtures as $fixture)
            <div class="card" style="padding:14px 16px">
                <div style="display:flex;align-items:center;gap:10px">

                    {{-- Info --}}
                    <div style="flex:1;min-width:0">
                        <div style="font-size:11px;color:#475569;margin-bottom:6px">
                            {{ $fixture->match_time->timezone('Asia/Jakarta')->format('d M Y · H:i') }} WIB
                            @if ($fixture->group)
                                · Grup {{ $fixture->group }}
                            @else
                                · {{ $fixture->stages_label }}
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:13px">
                            <span>{{ $fixture->homeTeam->flag_emoji }}</span>
                            <span style="font-weight:600;color:#f0f4f8">{{ $fixture->homeTeam->name }}</span>
                            <span style="font-family:'Barlow Condensed',sans-serif;font-size:18px;font-weight:900;color:#f0f4f8;margin:0 4px">
                                @if (!is_null($fixture->home_score))
                                    {{ $fixture->home_score }} – {{ $fixture->away_score }}
                                @else
                                    vs
                                @endif
                            </span>
                            <span style="font-weight:600;color:#f0f4f8">{{ $fixture->awayTeam->name }}</span>
                            <span>{{ $fixture->awayTeam->flag_emoji }}</span>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div style="flex-shrink:0">
                        @if ($fixture->status === 'finished')
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px;background:rgba(100,116,139,0.12);color:#94a3b8;border:1px solid rgba(100,116,139,0.2)">
                                Selesai
                            </span>
                        @elseif ($fixture->status === 'live')
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px;background:rgba(0,255,135,0.1);color:#00ff87;border:1px solid rgba(0,255,135,0.3)">
                                LIVE
                            </span>
                        @else
                            <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px;background:rgba(99,102,241,0.1);color:#818cf8;border:1px solid rgba(99,102,241,0.2)">
                                Terjadwal
                            </span>
                        @endif
                    </div>

                    {{-- Edit Button --}}
                    <a href="{{ route('admin.matches.edit', $fixture) }}"
                       style="flex-shrink:0;font-size:12px;font-weight:600;color:#00ff87;text-decoration:none;padding:6px 12px;border:1px solid rgba(0,255,135,0.3);border-radius:8px">
                        Edit
                    </a>

                    @if ($fixture->stage !== 'group')
                        <form method="POST" action="{{ route('admin.matches.destroy', $fixture) }}"
                            onsubmit="return confirm('Hapus fixture ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="font-size:12px;font-weight:600;color:#f87171;padding:6px 12px;border:1px solid rgba(248,113,113,0.3);border-radius:8px;background:transparent;cursor:pointer">
                                Hapus
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="icon">📭</div>
                <p>Belum ada data fixture.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($fixtures->hasPages())
        <div style="margin-top:16px">{{ $fixtures->links() }}</div>
    @endif

</x-app-layout>