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
        $user = auth()->user();
        $today = now()->toDateString();
        $nowTime = now()->toTimeString();

        $log = TimeLog::where('user_id', $userId)->where('date', $today)->first();
        $schedule = $user->group?->schedule;

        // Stage 1: Initial System Entry (IN) with Late Calculation
        if (!$log) {
            $lateMinutes = 0;

            if ($schedule && $schedule->shift_in) {
                $expectedIn = \Carbon\Carbon::createFromTimeString($schedule->shift_in);
                $actualIn = \Carbon\Carbon::createFromTimeString($nowTime);

                // If they clock in past the scheduled shift time + grace period
                if ($actualIn->greaterThan($expectedIn->copy()->addMinutes($schedule->grace_period))) {
                    $lateMinutes = $actualIn->diffInMinutes(\Carbon\Carbon::createFromTimeString($schedule->shift_in));
                }
            }

            TimeLog::create([
                'user_id' => $userId,
                'date' => $today,
                'clock_in' => $nowTime,
                'late_minutes' => $lateMinutes,
            ]);

            $msg = 'Shift started successfully (IN).';
            if ($lateMinutes > 0) {
                $msg .= " Flagged Late: {$lateMinutes} mins.";
            }

            return back()->with('status', $msg);
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

        // Stage 8: Shift Completed (OUT) with Undertime Calculation
        if (is_null($log->clock_out)) {
            $undertimeMinutes = 0;

            if ($schedule && $schedule->shift_out) {
                $expectedOut = \Carbon\Carbon::createFromTimeString($schedule->shift_out);
                $actualOut = \Carbon\Carbon::createFromTimeString($nowTime);

                // If they clock out earlier than the scheduled shift end time
                if ($actualOut->lessThan($expectedOut)) {
                    $undertimeMinutes = $actualOut->diffInMinutes($expectedOut);
                }
            }

            $log->update([
                'clock_out' => $nowTime,
                'undertime_minutes' => $undertimeMinutes,
            ]);

            $msg = 'Shift completed successfully (OUT).';
            if ($undertimeMinutes > 0) {
                $msg .= " Flagged Undertime: {$undertimeMinutes} mins.";
            }

            return back()->with('status', $msg);
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
