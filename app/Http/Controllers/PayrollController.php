<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Payroll;
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

        $bonus = $request->input('bonus', 0) ?? 0;
        $deductions = $request->input('deductions', 0) ?? 0;

        // Process bulk payout entries for each employee in the target group loop
        foreach ($users as $user) {
            $netPay = $user->base_salary + $bonus - $deductions;

            Payroll::create([
                'user_id' => $user->id,
                'pay_period' => "({$group->pay_frequency}) " . $request->pay_period,
                'base_salary' => $user->base_salary,
                'bonus' => $bonus,
                'deductions' => $deductions,
                'net_pay' => $netPay,
                'status' => 'Paid',
            ]);
        }

        return back()->with('status', "Bulk payroll successfully processed for {$users->count()} employees inside the '{$group->name}' network!");
    }
}
