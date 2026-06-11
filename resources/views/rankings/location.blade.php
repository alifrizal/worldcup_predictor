<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ranking per Kota
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @include('rankings.partials.tabs', ['active' => 'location'])

            {{-- PILIH KOTA --}}
            <form method="GET" action="{{ route('rankings.location') }}" class="mb-4">
                <select name="city_id" onchange="this.form.submit()"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <optgroup label="🇮🇩 Indonesia">
                        @foreach ($cities->where('region', 'indonesia') as $c)
                        <option value="{{ $c->id }}" {{ $city?->id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="🌍 Internasional">
                        @foreach ($cities->where('region', 'international') as $c)
                        <option value="{{ $c->id }}" {{ $city?->id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}, {{ $c->country }}
                        </option>
                        @endforeach
                    </optgroup>
                </select>
            </form>

            @if ($city)
            <div class="mb-4 text-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    Ranking di <strong class="text-gray-700 dark:text-gray-200">{{ $city->name }}</strong>
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