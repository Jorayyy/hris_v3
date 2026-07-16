<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now()->toDateString();

        // 🔄 If the admin clicks the toggle link to view their own attendance:
        if (request()->has('view') && request()->get('view') === 'attendance') {
            // Load the exact same 8-point attendance dataset for this admin account
            $todayLog = \App\Models\TimeLog::where('user_id', $user->id)->where('date', $today)->first();
            $timeLogs = \App\Models\TimeLog::where('user_id', $user->id)->latest()->take(10)->get();
            $leaveRequests = \App\Models\LeaveRequest::where('user_id', $user->id)->latest()->get();

            return view('dashboard', compact('todayLog', 'timeLogs', 'leaveRequests'));
        }

        // Standard operational dashboard view for management tasks
        $employees = User::whereIn('role', ['employee', 'accounting'])->get();
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->with('user')->get();
        $todayLogs = TimeLog::where('date', now()->toDateString())->with('user')->get();

        return view('admin.dashboard', compact('employees', 'pendingLeaves', 'todayLogs'));
    }

    public function updateLeave($id, $status)
    {
        $request = LeaveRequest::findOrFail($id);
        $request->update(['status' => $status]);

        return back()->with('status', "Leave request has been {$status}.");
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'department' => 'nullable|string',
            'job_title' => 'nullable|string',
            'base_salary' => 'required|numeric|min:0',
            
            // 🛡️ 1. ADDED VALIDATION RULE FOR GROUPS:
            'group_id' => 'nullable|exists:groups,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee', 
            'department' => $request->department,
            'job_title' => $request->job_title,
            'base_salary' => $request->base_salary,
            
            // 🔗 2. ADDED ASSIGNMENT LINE TO STORE GROUP ASSIGNMENT NATIVELY:
            'group_id' => $request->group_id,
            
            'hire_date' => now()->toDateString(),
        ]);

        return back()->with('status', 'New profile record registered successfully!');
    }
}
