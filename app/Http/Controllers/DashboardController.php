<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
    {
        $user = auth()->user();
        $today = now()->toDateString();

        $todayLog = TimeLog::where('user_id', $user->id)->where('date', $today)->first();
        $timeLogs = TimeLog::where('user_id', $user->id)->latest()->take(10)->get();
        $leaveRequests = LeaveRequest::where('user_id', $user->id)->latest()->get();
        
        // 💰 ADDED THIS LINE TO FETCH THE PAYROLL SLIPS:
        $payrolls = \App\Models\Payroll::where('user_id', $user->id)->latest()->get();

        return view('dashboard', compact('todayLog', 'timeLogs', 'leaveRequests', 'payrolls'));
    }


    public function toggleClock()
    {
        $userId = auth()->id();
        $today = now()->toDateString();
        $nowTime = now()->toTimeString();

        $log = TimeLog::where('user_id', $userId)->where('date', $today)->first();

        // Stage 1: Initial System Entry (IN)
        if (!$log) {
            TimeLog::create([
                'user_id' => $userId,
                'date' => $today,
                'clock_in' => $nowTime,
            ]);
            return back()->with('status', 'Shift started successfully (IN).');
        }

        // Sequential Chronological State Tracker Matchers
        if (is_null($log->break1_out)) {
            $log->update(['break1_out' => $nowTime]);
            return back()->with('status', 'Started 1st Break (OUT).');
        } 
        
        if (is_null($log->break1_in)) {
            $log->update(['break1_in' => $nowTime]);
            return back()->with('status', 'Returned from 1st Break (IN).');
        }

        if (is_null($log->lunch_out)) {
            $log->update(['lunch_out' => $nowTime]);
            return back()->with('status', 'Started Lunch Break (OUT).');
        }

        if (is_null($log->lunch_in)) {
            $log->update(['lunch_in' => $nowTime]);
            return back()->with('status', 'Returned from Lunch Break (IN).');
        }

        if (is_null($log->break2_out)) {
            $log->update(['break2_out' => $nowTime]);
            return back()->with('status', 'Started 2nd Break (OUT).');
        }

        if (is_null($log->break2_in)) {
            $log->update(['break2_in' => $nowTime]);
            return back()->with('status', 'Returned from 2nd Break (IN).');
        }

        if (is_null($log->clock_out)) {
            $log->update(['clock_out' => $nowTime]);
            return back()->with('status', 'Shift completed successfully (OUT).');
        }

        return back()->with('error', 'All shift parameters for today are locked.');
    }

    public function storeLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('status', 'Leave request submitted successfully.');
    }
}
