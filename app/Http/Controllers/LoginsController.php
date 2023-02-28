<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\View\View;

class LoginsController extends Controller {
    /**
     * Display the user's profile form.
     */
    public function index(): View {
        return view('logins.index', [
            'users' => User::withLastLogin()
                ->orderBy('name')
                ->paginate()
        ]);
    }
}
