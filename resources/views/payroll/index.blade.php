<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: #1f2937 !important;">
            {{ __('Group Financial Terminal & Payroll Hub') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" style="background-color: #f9fafb !important;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- System Activity Notifications -->
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" style="background-color: #d1fae5 !important; color: #065f46 !important; border-color: #a7f3d0 !important; margin-bottom: 1.5rem;">
                    <span style="display: inline !important; color: inherit !important;">{{ session('status') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" style="background-color: #fee2e2 !important; color: #991b1b !important; border-color: #fca5a5 !important; margin-bottom: 1.5rem;">
                    <span style="display: inline !important; color: inherit !important;">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="display: grid; gap: 1.5rem;">
                
                <!-- ACCOUNTING COMPONENT: GROUP BULK SUBMISSION MODULE -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-2" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important;">Process Group Payroll</h3>
                    <p class="text-xs text-gray-500 mb-6" style="color: #6b7280 !important; margin-bottom: 1.5rem !important;">Select an operational employee group network to execute batch net salary calculations based on their cycle frequency.</p>
                    
                    <form action="{{ route('payroll.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @csrf
                        <div>
                            <label style="font-size: 0.75rem !important; font-weight: 600 !important; color: #4b5563 !important; display: block !important; margin-bottom: 0.25rem !important;">Target Employee Group</label>
                            <select name="group_id" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important; background-color: #ffffff !important;">
                                @foreach($groups as $gp)
                                    <option value="{{ $gp->id }}">{{ $gp->name }} ({{ strtoupper($gp->pay_frequency) }} • {{ $gp->users_count }} Staff)</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label style="font-size: 0.75rem !important; font-weight: 600 !important; color: #4b5563 !important; display: block !important; margin-bottom: 0.25rem !important;">Pay Period Cycle Label</label>
                            <input type="text" name="pay_period" placeholder="e.g., Week 29, July 2026" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        </div>

                        <div>
                            <label style="font-size: 0.75rem !important; font-weight: 600 !important; color: #4b5563 !important; display: block !important; margin-bottom: 0.25rem !important;">Batch Allowances / Bonus ($)</label>
                            <input type="number" name="bonus" step="0.01" value="0.00" style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        </div>

                        <div>
                            <label style="font-size: 0.75rem !important; font-weight: 600 !important; color: #4b5563 !important; display: block !important; margin-bottom: 0.25rem !important;">Batch Deductions / Absences ($)</label>
                            <input type="number" name="deductions" step="0.01" value="0.00" style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        </div>

                        <button type="submit" style="width: 100% !important; background-color: #4f46e5 !important; color: #ffffff !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-size: 0.875rem !important; margin-top: 0.5rem !important; border: none !important; cursor: pointer !important;">
                            <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">⚙️ Run Batch Payout Calculations</span>
                        </button>
                    </form>
                </div>

                                <!-- MASTER LEDGER COLUMN: HISTORICAL COMPENSATION RECORDS -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200 md:col-span-2" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Compensation Disbursement Log</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important; font-size: 0.75rem !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Employee</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Period & Cycle</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Base Rate</th>
                                    <th style="padding: 0.5rem !important; color: #059669 !important; font-weight: 600 !important;">Bonus</th>
                                    <th style="padding: 0.5rem !important; color: #dc2626 !important; font-weight: 600 !important;">Deductions</th>
                                    <th style="padding: 0.5rem !important; color: #4f46e5 !important; font-weight: 600 !important;">Net Paid</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important; text-align: right !important;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payrollHistory as $pay)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.75rem 0.5rem !important; font-weight: 600 !important; color: #111827 !important;">{{ $pay->user->name }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; font-family: monospace !important;">{{ $pay->pay_period }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important;">${{ number_format($pay->base_salary, 2) }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; color: #059669 !important;">+${{ number_format($pay->bonus, 2) }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; color: #dc2626 !important;">-${{ number_format($pay->deductions, 2) }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; font-weight: 700 !important; color: #4f46e5 !important;">${{ number_format($pay->net_pay, 2) }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; text-align: right !important;">
                                            <span style="padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; font-weight: 600 !important; background-color: #d1fae5 !important; color: #065f46 !important; border-radius: 9999px !important; display: inline-block !important;">
                                                Paid
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">No historical payroll payouts processed yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
