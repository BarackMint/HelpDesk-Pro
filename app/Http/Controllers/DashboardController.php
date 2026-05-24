<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match($user->role) {
            'admin'    => $this->adminDashboard(),
            'agent'    => $this->agentDashboard($user),
            'employee' => $this->employeeDashboard($user),
            default    => abort(403, 'Unauthorized'),
        };
    }

    // --- Admin ---
    private function adminDashboard()
    {
        $stats = [
            'total_tickets'    => Ticket::count(),
            'open_tickets'     => Ticket::where('status', 'open')->count(),
            'in_progress'      => Ticket::where('status', 'in_progress')->count(),
            'resolved_tickets' => Ticket::where('status', 'resolved')->count(),
            'closed_tickets'   => Ticket::where('status', 'closed')->count(),
            'total_users'      => User::count(),
            'total_agents'     => User::where('role', 'agent')->count(),
            'total_categories' => Category::count(),
        ];

        $recentTickets = Ticket::with(['creator', 'assignee', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentTickets'));
    }

    // --- Agent ---
    private function agentDashboard(User $user)
    {
        $stats = [
            'assigned_tickets'  => Ticket::where('assigned_to', $user->id)->count(),
            'open_tickets'      => Ticket::where('assigned_to', $user->id)
                                         ->where('status', 'open')->count(),
            'in_progress'       => Ticket::where('assigned_to', $user->id)
                                         ->where('status', 'in_progress')->count(),
            'resolved_tickets'  => Ticket::where('assigned_to', $user->id)
                                         ->where('status', 'resolved')->count(),
        ];

        $recentTickets = Ticket::with(['creator', 'category'])
            ->where('assigned_to', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.agent', compact('stats', 'recentTickets'));
    }

    // --- Employee ---
    private function employeeDashboard(User $user)
    {
        $stats = [
            'total_tickets'    => Ticket::where('created_by', $user->id)->count(),
            'open_tickets'     => Ticket::where('created_by', $user->id)
                                        ->where('status', 'open')->count(),
            'in_progress'      => Ticket::where('created_by', $user->id)
                                        ->where('status', 'in_progress')->count(),
            'resolved_tickets' => Ticket::where('created_by', $user->id)
                                        ->where('status', 'resolved')->count(),
        ];

        $recentTickets = Ticket::with(['category', 'assignee'])
            ->where('created_by', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.employee', compact('stats', 'recentTickets'));
    }
}