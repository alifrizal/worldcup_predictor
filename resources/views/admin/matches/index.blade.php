<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin — Kelola Match
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400">
                {{ session('success') }}
            </div>
            @endif

            <div class="space-y-2">
                @foreach ($fixtures as $fixture)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 px-4 py-3 flex items-center gap-4">

                    {{-- Waktu & Grup --}}
                    <div class="w-24 text-center flex-shrink-0">
                        <div class="text-xs font-bold text-gray-500">
                            {{ $fixture->match_time->format('d M') }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $fixture->match_time->format('H:i') }} WIB
                        </div>
                        @if ($fixture->group)
                        <div class="text-xs text-indigo-400 font-semibold mt-0.5">Grup {{ $fixture->group }}</div>
                        @endif
                    </div>

                    {{-- Match --}}
                    <div class="flex-1 flex items-center justify-between gap-2 text-sm">
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $fixture->homeTeam->flag_emoji }} {{ $fixture->homeTeam->name }}
                        </span>
                        <span class="font-black text-gray-600 dark:text-gray-300 text-base">
                            @if (!is_null($fixture->home_score))
                            {{ $fixture->home_score }} – {{ $fixture->away_score }}
                            @else
                            vs
                            @endif
                        </span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $fixture->awayTeam->name }} {{ $fixture->awayTeam->flag_emoji }}
                        </span>
                    </div>

                    {{-- Status Badge --}}
                    <div class="w-20 text-center flex-shrink-0">
                        @if ($fixture->status === 'finished')
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded-full font-medium">Selesai</span>
                        @elseif ($fixture->status === 'live')
                        <span class="text-xs bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400 px-2 py-0.5 rounded-full font-bold animate-pulse">LIVE</span>
                        @else
                        <span class="text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-500 px-2 py-0.5 rounded-full font-medium">Terjadwal</span>
                        @endif
                    </div>

                    {{-- Edit Button --}}
                    <a href="{{ route('admin.matches.edit', $fixture) }}"
                        class="flex-shrink-0 text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        Edit
                    </a>

                </div>
                @endforeach
            </div>

            <div class="mt-4">{{ $fixtures->links() }}</div>

        </div>
    </div>
</x-app-layout>