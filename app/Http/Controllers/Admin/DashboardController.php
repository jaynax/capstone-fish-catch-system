<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FishCatch;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'pendingUsers' => User::where('status', 'pending')->count(),
            'approvedUsers' => User::where('status', 'approved')->count(),
            'totalCatches' => FishCatch::count(),
            'uniqueSpecies' => FishCatch::distinct('species')->count(),
        ];

        return view('admin-dashboard', compact('stats'));
    }
}
