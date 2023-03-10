<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UsersController extends Controller {
    /**
     * Display the user's profile form.
     */
    public function index(): View {
        return view('users.index', [
            'users' => User::with('company')
                ->search(request('search'))
                //->orderBy('name') Ep2
                ->paginate()
        ]);
    }
}
