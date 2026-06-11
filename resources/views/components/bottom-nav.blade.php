<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 safe-area-bottom">
    <div class="max-w-3xl mx-auto flex items-center justify-around h-16">

        {{-- Fixture --}}
        <a href="{{ route('fixtures.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('fixtures.*')
                      ? 'text-indigo-600 dark:text-indigo-400'
                      : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-xs font-medium">Fixture</span>
        </a>

        {{-- Live & Prediksi --}}
        <a href="{{ route('predictions.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('predictions.*')
                      ? 'text-indigo-600 dark:text-indigo-400'
                      : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs font-medium">Prediksi</span>
        </a>

        {{-- Ranking --}}
        <a href="{{ route('rankings.global') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('rankings.*')
                      ? 'text-indigo-600 dark:text-indigo-400'
                      : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="text-xs font-medium">Ranking</span>
        </a>

        {{-- History --}}
        <a href="{{ route('history.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('history.*')
                      ? 'text-indigo-600 dark:text-indigo-400'
                      : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs font-medium">History</span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition
                  {{ request()->routeIs('profile.*') || request()->routeIs('statistics.*')
                      ? 'text-indigo-600 dark:text-indigo-400'
                      : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs font-medium">Profil</span>
        </a>

    </div>
</nav>

{{-- Spacer agar konten tidak tertutup bottom nav --}}
<div class="h-20"></div>