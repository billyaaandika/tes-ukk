<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use App\Models\Tool;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
    return view('admin.dashboard');
   }

   public function officerIndex()
   {
    $totalUsers = User::count();
    $totalCategories = Category::count();
    $totalTools = Tool::count();
    $recentLogs = ActivityLog::orderBy('created_at', 'desc')->take(5)->get();

    return view('officer.dashboard', compact('totalUsers', 'totalCategories', 'totalTools', 'recentLogs'));
   }
}
