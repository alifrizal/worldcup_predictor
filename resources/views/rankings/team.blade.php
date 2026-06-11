<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ranking per Tim
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @include('rankings.partials.tabs', ['active' => 'team'])

            {{-- PILIH TIM --}}
            <form method="GET" action="{{ route('rankings.team') }}" class="mb-4">
                <select name="team_id" onchange="this.form.submit()"
                    class="field-input">
                    @foreach ($teams->groupBy('group') as $group => $groupTeams)
                    <optgroup label="Grup {{ $group }}">
                        @foreach ($groupTeams as $t)
                        <option value="{{ $t->id }}" {{ $team?->id == $t->id ? 'selected' : '' }}>
                            {{ $t->flag_emoji }} {{ $t->name }}
                        </option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </form>

            @if ($team)
            <div class="mb-4 text-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    Supporter {{ $team->flag_emoji }} <strong class="text-gray-700 dark:text-gray-200">{{ $team->name }}</strong>
                    — {{ $rankings->count() }} player
                    @if ($userRank)
                    · posisi kamu <strong class="text-indigo-600 dark:text-indigo-400">#{{ $userRank }}</strong>
                    @endif
                </span>
            </div>
            @endif

            @include('rankings.partials.table', ['rankings' => $rankings, 'userRank' => $userRank])

        </div>
    </div>
</x-app-layout>