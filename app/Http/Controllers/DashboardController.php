<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match($user->role) {
            'admin'    => view('dashboard.admin'),
            'agent'    => view('dashboard.agent'),
            'employee' => view('dashboard.employee'),
            default    => abort(403, 'Unauthorized'),
        };
    }
}