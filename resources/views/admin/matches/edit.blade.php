<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Update Skor Match
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">

                {{-- Info Match --}}
                <div class="text-center mb-6">
                    <div class="text-sm text-gray-500 mb-1">
                        {{ $fixture->match_time->format('d M Y · H:i') }} WIB
                        @if ($fixture->group) · Grup {{ $fixture->group }} @endif
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-3">
                        <div class="text-center">
                            <div class="text-3xl">{{ $fixture->homeTeam->flag_emoji }}</div>
                            <div class="text-sm font-semibold mt-1">{{ $fixture->homeTeam->name }}</div>
                        </div>
                        <div class="text-xl font-black text-gray-400">vs</div>
                        <div class="text-center">
                            <div class="text-3xl">{{ $fixture->awayTeam->flag_emoji }}</div>
                            <div class="text-sm font-semibold mt-1">{{ $fixture->awayTeam->name }}</div>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.matches.update', $fixture) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="scheduled" {{ $fixture->status === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="live" {{ $fixture->status === 'live'      ? 'selected' : '' }}>Live</option>
                            <option value="finished" {{ $fixture->status === 'finished'  ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="home_score" :value="$fixture->homeTeam->name" />
                            <x-text-input
                                id="home_score" name="home_score" type="number"
                                class="mt-1 block w-full text-center text-lg font-bold"
                                :value="old('home_score', $fixture->home_score ?? 0)"
                                min="0" max="99" />
                            <x-input-error :messages="$errors->get('home_score')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="away_score" :value="$fixture->awayTeam->name" />
                            <x-text-input
                                id="away_score" name="away_score" type="number"
                                class="mt-1 block w-full text-center text-lg font-bold"
                                :value="old('away_score', $fixture->away_score ?? 0)"
                                min="0" max="99" />
                            <x-input-error :messages="$errors->get('away_score')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button class="flex-1 justify-center">
                            Simpan
                        </x-primary-button>
                        <a href="{{ route('admin.matches.index') }}"
                            class="flex-1 text-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>