<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\City;
use App\Models\WorldCupTeam;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $cities = City::orderByRaw("region = 'international'")
            ->orderBy('country')
            ->orderBy('name')
            ->get(['id', 'name', 'country', 'region']);

        $teams = WorldCupTeam::orderBy('group')
            ->orderBy('name')
            ->get(['id', 'name', 'flag_emoji', 'group']);

        return view('auth.register', compact('cities', 'teams'));
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
