<x-app-layout>
    <x-slot name="header">Ranking</x-slot>
 
    @include('rankings.partials.tabs', ['active' => 'global'])
 
    @if ($userRank)
        <div style="text-align:center;font-size:13px;color:#64748b;margin-bottom:16px">
            Posisi kamu:
            <strong style="color:#00ff87">#{{ $userRank }}</strong>
            dari <strong style="color:#94a3b8">{{ $rankings->count() }}</strong> player
        </div>
    @endif
 
    @include('rankings.partials.table', ['rankings' => $rankings, 'userRank' => $userRank])
</x-app-layout>