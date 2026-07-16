<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payroll;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        if (!\Illuminate\Support\Facades\Gate::allows('is-accounting')) {
            abort(403, 'Unauthorized access to payroll terminal records.');
        }

        $groups = Group::withCount('users')->get();
        $payrollHistory = Payroll::with('user')->latest()->get();

        // 🛑 FIXED: Changed $payrollHistory to 'payrollHistory' string mapping inside compact()
        return view('payroll.index', compact('groups', 'payrollHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'pay_period' => 'required|string',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        $group = Group::findOrFail($request->group_id);
        $users = User::where('group_id', $group->id)->get();

        if ($users->isEmpty()) {
            return back()->with('error', 'The selected payroll group contains no active employees to process.');
        }

        $manualBonus = $request->input('bonus', 0) ?? 0;
        $manualDeductions = $request->input('deductions', 0) ?? 0;

        foreach ($users as $user) {
            // ⏱️ 1. CALCULATE AUTOMATIC PENALTIES FROM TIME LOGS
            $totalLateMins = TimeLog::where('user_id', $user->id)->sum('late_minutes') ?? 0;
            $totalUndertimeMins = TimeLog::where('user_id', $user->id)->sum('undertime_minutes') ?? 0;
            $totalPenaltyMins = $totalLateMins + $totalUndertimeMins;

            // 💰 2. CONVERT MINUTES TO CASH DEDUCTIONS (Based on 160 working hours/month)
            $hourlyRate = $user->base_salary / 160;
            $perMinuteRate = $hourlyRate / 60;
            $autoAttendanceDeduction = round($totalPenaltyMins * $perMinuteRate, 2);

            // Combine manual accounting deductions with auto-calculated penalties
            $finalDeductions = $manualDeductions + $autoAttendanceDeduction;
            $netPay = $user->base_salary + $manualBonus - $finalDeductions;

            // 🗄️ 3. SAVE THE PAYROLL STATEMENT
            Payroll::create([
                'user_id' => $user->id,
                'pay_period' => "({$group->pay_frequency}) " . $request->pay_period,
                'base_salary' => $user->base_salary,
                'bonus' => $manualBonus,
                'deductions' => $finalDeductions,
                'net_pay' => $netPay,
                'status' => 'Paid',
            ]);
        }

        return back()->with('status', "Bulk payroll successfully processed! Attendance penalties were automatically computed and deducted for '{$group->name}'.");
    }
}
