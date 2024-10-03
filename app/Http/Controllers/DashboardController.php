<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Golongan;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role->name === 'Member') {
                return redirect()->intended('/profile');
            }
        }

        $activeMembersCount = User::where('status_active', true)
                            ->whereHas('role', function($query) {
                                $query->where('name', 'Member');
                            })
                            ->count();

        $users = User::select('role_id')
            ->with('role')
            ->groupBy('role_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->role->name => User::where('role_id', $item->role_id)->count()];
            });

        $totalSavings = Tabungan::sum('simp_pokok') + Tabungan::sum('simp_wajib') + Tabungan::sum('simp_sukarela');

        $minSavings = Tabungan::min('simp_sukarela') + Tabungan::min('simp_pokok') + Tabungan::min('simp_wajib');
        $maxSavings = Tabungan::max('simp_sukarela') + Tabungan::max('simp_pokok') + Tabungan::max('simp_wajib');

        $golonganCount = Golongan::count();

        return view('dashboard.pages.dashboard', [
            'activeMembersCount' => $activeMembersCount,
            'users' => $users,
            'totalSavings' => $totalSavings,
            'minSavings' => $minSavings,
            'maxSavings' => $maxSavings,
            'golonganData' => $golonganCount,
            'title' => "Dashboard"
        ]);
    }
}
