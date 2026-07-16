<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: #1f2937 !important;">
            {{ __('Employee Attendance & Self-Service Portal') }}
        </h2>

         @if(in_array(auth()->user()->role, ['super_admin', 'admin', 'hr']))
                <a href="{{ route('admin.index') }}" style="background-color: #4f46e5 !important; color: #ffffff !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-size: 0.875rem !important; text-decoration: none !important; display: inline-block !important;">
                    <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">💼 Switch to Admin Panel</span>
                </a>
            @endif

    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" style="background-color: #f9fafb !important;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notification Messages -->
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
                
                <!-- ATTENDANCE STATE ENGINE WIDGET -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-2" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important;">Shift Tracker</h3>
                    <p class="text-sm text-gray-500 mb-6" style="color: #6b7280 !important; font-size: 0.875rem !important; margin-bottom: 1.5rem !important;">Click below to log your current milestone.</p>
                    
                    <form action="{{ route('clock.toggle') }}" method="POST">
                        @csrf
                        @if (!$todayLog)
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #059669 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">🟢 CLOCK IN</span>
                            </button>
                        @elseif (is_null($todayLog->break1_out))
                            <button type="submit" class="w-full bg-amber-500 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #f59e0b !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">☕ 1st BREAK OUT</span>
                            </button>
                        @elseif (is_null($todayLog->break1_in))
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #4f46e5 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">↩️ 1st BREAK IN</span>
                            </button>
                        @elseif (is_null($todayLog->lunch_out))
                            <button type="submit" class="w-full bg-orange-500 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #f97316 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">🍱 LUNCH BREAK OUT</span>
                            </button>
                        @elseif (is_null($todayLog->lunch_in))
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #4f46e5 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">↩️ LUNCH BREAK IN</span>
                            </button>
                        @elseif (is_null($todayLog->break2_out))
                            <button type="submit" class="w-full bg-amber-500 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #f59e0b !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">☕ 2nd BREAK OUT</span>
                            </button>
                        @elseif (is_null($todayLog->break2_in))
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #4f46e5 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">↩️ 2nd BREAK IN</span>
                            </button>
                        @elseif (is_null($todayLog->clock_out))
                            <button type="submit" class="w-full bg-rose-600 text-white font-bold py-4 px-4 rounded-lg shadow" style="width: 100% !important; background-color: #dc2626 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important; font-weight: 700 !important;">🛑 CLOCK OUT</span>
                            </button>
                        @else
                            <button type="button" disabled class="w-full bg-gray-300 text-gray-600 font-bold py-4 px-4 rounded-lg cursor-not-allowed" style="width: 100% !important; background-color: #e5e7eb !important; color: #4b5563 !important; padding: 1rem !important; border-radius: 0.5rem !important; display: block !important; text-align: center !important; cursor: not-allowed !important; border: none !important;">
                                <span style="display: inline !important; color: #4b5563 !important; visibility: visible !important; font-weight: 700 !important;">🎉 Shift Completed</span>
                            </button>
                        @endif
                    </form>
                </div>

                                <!-- COLUMN 2: LEAVE REQUEST FORM -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 md:col-span-2" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Request Time Off</h3>
                    
                    <form action="{{ route('leave.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="display: grid; gap: 1rem;">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700" style="color: #374151 !important; font-size: 0.875rem !important; font-weight: 500 !important;">Leave Type</label>
                            <select name="leave_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" style="width: 100% !important; margin-top: 0.25rem !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important;">
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Vacation">Vacation</option>
                                <option value="Personal Leave">Personal Leave</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700" style="color: #374151 !important; font-size: 0.875rem !important; font-weight: 500 !important;">Start Date</label>
                            <input type="date" name="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" style="width: 100% !important; margin-top: 0.25rem !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important;">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700" style="color: #374151 !important; font-size: 0.875rem !important; font-weight: 500 !important;">End Date</label>
                            <input type="date" name="end_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" style="width: 100% !important; margin-top: 0.25rem !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important;">
                        </div>
                        <div style="text-align: right !important; margin-top: 1rem !important;">
                            <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md shadow" style="background-color: #4f46e5 !important; color: #ffffff !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-weight: 600 !important; border: none !important; cursor: pointer !important;">
                                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">Submit Leave Request</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- LOWER DATA SECTION: HISTORICAL VIEWS -->
            <div class="space-y-6" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">

                            <!-- COMPLETE 8-POINT TIMECARDS MATRIX -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Recent Shift Logs</h3>
                    <div class="overflow-x-auto" style="overflow-x: auto !important;">
                        <table class="w-full text-left text-xs text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important; font-size: 0.75rem !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Date</th>
                                    <th style="padding: 0.5rem !important; color: #059669 !important; font-weight: 600 !important;">IN</th>
                                    <th style="padding: 0.5rem !important; color: #b45309 !important; font-weight: 600 !important;">BRK1 OUT</th>
                                    <th style="padding: 0.5rem !important; color: #4338ca !important; font-weight: 600 !important;">BRK1 IN</th>
                                    <th style="padding: 0.5rem !important; color: #c2410c !important; font-weight: 600 !important;">LUNCH OUT</th>
                                    <th style="padding: 0.5rem !important; color: #4338ca !important; font-weight: 600 !important;">LUNCH IN</th>
                                    <th style="padding: 0.5rem !important; color: #b45309 !important; font-weight: 600 !important;">BRK2 OUT</th>
                                    <th style="padding: 0.5rem !important; color: #4338ca !important; font-weight: 600 !important;">BRK2 IN</th>
                                    <th style="padding: 0.5rem !important; color: #b91c1c !important; font-weight: 600 !important;">OUT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($timeLogs as $log)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.5rem !important; color: #111827 !important; font-weight: 600 !important;">{{ $log->date }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->clock_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->break1_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->break1_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->lunch_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->lunch_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->break2_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important;">{{ $log->break2_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem !important; font-weight: 600 !important;">{{ $log->clock_out ?? ($log->clock_in ? 'Active' : '-') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">No records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TIME OFF STATUSES -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Leave History</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Type</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Dates</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $req)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.5rem !important; color: #111827 !important; font-weight: 500 !important;">{{ $req->leave_type }}</td>
                                        <td style="padding: 0.5rem !important; font-size: 0.75rem !important;">{{ $req->start_date }} to {{ $req->end_date }}</td>
                                        <td style="padding: 0.5rem !important;">
                                            <span style="padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; font-weight: 600 !important; border-radius: 9999px !important; display: inline-block !important;
                                                {{ $req->status === 'Approved' ? 'background-color: #d1fae5 !important; color: #065f46 !important;' : ($req->status === 'Denied' ? 'background-color: #fee2e2 !important; color: #991b1b !important;' : 'background-color: #fef3c7 !important; color: #92400e !important;') }}">
                                                {{ $req->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">No requests found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                                <!-- 💰 MY PAYSLIPS LEDGER BLOCK -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important; margin-top: 1.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">My Payroll Statements</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Pay Period</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Base Salary</th>
                                    <th style="padding: 0.5rem !important; color: #059669 !important; font-weight: 600 !important;">Bonus</th>
                                    <th style="padding: 0.5rem !important; color: #dc2626 !important; font-weight: 600 !important;">Deductions</th>
                                    <th style="padding: 0.5rem !important; color: #4f46e5 !important; font-weight: 600 !important;">Net Paid</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important; text-align: right !important;">Status</th>
                                </tr>
                            </thead>
                                                        <tbody>
                                @forelse($payrolls as $pay)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.5rem !important; font-weight: 600 !important; color: #111827 !important;">{{ $pay->pay_period }}</td>
                                        <td style="padding: 0.5rem !important;">${{ number_format($pay->base_salary, 2) }}</td>
                                        <td style="padding: 0.5rem !important; color: #059669 !important;">+${{ number_format($pay->bonus, 2) }}</td>
                                        <td style="padding: 0.5rem !important; color: #dc2626 !important;">-${{ number_format($pay->deductions, 2) }}</td>
                                        <td style="padding: 0.5rem !important; font-weight: 700 !important; color: #4f46e5 !important;">${{ number_format($pay->net_pay, 2) }}</td>
                                        <td style="padding: 0.5rem !important; text-align: right !important; space-x: 2px;">
                                            <!-- 👁️ INTERACTIVE POPUP VIEW TRIGGER -->
                                            <button onclick="openPayslipModal('{{ $pay->pay_period }}', '{{ number_format($pay->base_salary, 2) }}', '{{ number_format($pay->bonus, 2) }}', '{{ number_format($pay->deductions, 2) }}', '{{ number_format($pay->net_pay, 2) }}')" style="background-color: #f3f4f6 !important; color: #374151 !important; border: 1px solid #d1d5db !important; padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; border-radius: 0.25rem !important; cursor: pointer !important; margin-right: 0.5rem !important;">
                                                View Slip
                                            </button>
                                            
                                            <span style="padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; font-weight: 600 !important; background-color: #d1fae5 !important; color: #065f46 !important; border-radius: 9999px !important; display: inline-block !important;">
                                                Received
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">No payslips generated for your profile yet.</td></tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>


            </div>

        </div>
    </div>

        <!-- 📄 MODAL DISPLAY CANVAS WRAPPER -->
    <div id="payslipModal" style="display: none; position: fixed !important; z-index: 9999 !important; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
        <div style="background-color: #ffffff !important; padding: 2rem !important; border-radius: 0.5rem !important; width: 100% !important; max-width: 500px !important; border: 1px solid #e5e7eb !important; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
            
            <!-- Invoice Header Header -->
            <div style="display: flex !important; justify-content: space-between !important; align-items: center !important; border-bottom: 2px dashed #e5e7eb !important; padding-bottom: 1rem !important; margin-bottom: 1.5rem !important;">
                <div>
                    <h4 style="font-size: 1.25rem !important; font-weight: 700 !important; color: #111827 !important; margin: 0 !important;">OFFICIAL PAYSLIP</h4>
                    <p style="font-size: 0.75rem !important; color: #6b7280 !important; margin: 0 !important;">Corporate Compensation Breakdown Statement</p>
                </div>
                <button onclick="closePayslipModal()" style="background: none !important; border: none !important; font-size: 1.5rem !important; color: #9ca3af !important; cursor: pointer !important;">&times;</button>
            </div>

            <!-- Profile Info Metrics -->
            <div style="margin-bottom: 1rem !important; font-size: 0.875rem !important; color: #4b5563 !important;">
                <p style="margin: 0.25rem 0 !important;"><strong>Employee:</strong> {{ auth()->user()->name }}</p>
                <p style="margin: 0.25rem 0 !important;"><strong>Designation:</strong> {{ auth()->user()->job_title ?? 'Staff Member' }}</p>
                <p style="margin: 0.25rem 0 !important;"><strong>Pay Cycle:</strong> <span id="modalPeriod" style="font-family: monospace !important; font-weight: bold !important;"></span></p>
            </div>

            <!-- Detailed Breakdown Item Ledger Grid -->
            <div style="border: 1px solid #e5e7eb !important; border-radius: 0.375rem !important; overflow: hidden !important; margin-bottom: 1.5rem !important;">
                <div style="display: flex !important; justify-content: space-between !important; padding: 0.5rem 1rem !important; background-color: #f3f4f6 !important; font-size: 0.75rem !important; font-weight: 600 !important; color: #374151 !important;">
                    <span>DESCRIPTION</span>
                    <span>AMOUNT</span>
                </div>
                <div style="display: flex !important; justify-content: space-between !important; padding: 0.75rem 1rem !important; border-bottom: 1px solid #e5e7eb !important; font-size: 0.875rem !important;">
                    <span style="color: #4b5563 !important;">Base Contract Salary Rate</span>
                    <span style="font-weight: 600 !important;" id="modalBase"></span>
                </div>
                <div style="display: flex !important; justify-content: space-between !important; padding: 0.75rem 1rem !important; border-bottom: 1px solid #e5e7eb !important; font-size: 0.875rem !important;">
                    <span style="color: #059669 !important;">Performance Incentives / Bonuses</span>
                    <span style="color: #059669 !important; font-weight: 600 !important;">+$<span id="modalBonus"></span></span>
                </div>
                <div style="display: flex !important; justify-content: space-between !important; padding: 0.75rem 1rem !important; font-size: 0.875rem !important;">
                    <span style="color: #dc2626 !important;">Absence Penalty / Account Deductions</span>
                    <span style="color: #dc2626 !important; font-weight: 600 !important;">-$<span id="modalDeductions"></span></span>
                </div>
            </div>

            <!-- Net Disbursed Grand Total Footer -->
            <div style="background-color: #eef2ff !important; padding: 1rem !important; border-radius: 0.375rem !important; display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 1.5rem !important;">
                <span style="font-weight: 700 !important; color: #374151 !important; font-size: 0.875rem !important;">NET DISBURSED AMOUNT</span>
                <span style="font-size: 1.5rem !important; font-weight: 800 !important; color: #4f46e5 !important;">$<span id="modalNet"></span></span>
            </div>

            <!-- Close Action Button -->
            <button onclick="closePayslipModal()" style="width: 100% !important; background-color: #374151 !important; color: #ffffff !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-size: 0.875rem !important; border: none !important; cursor: pointer !important;">
                Dismiss Statement View
            </button>
        </div>
    </div>

    <!-- 🧠 MODAL INTERACTION CONTROLLER SCRIPT -->
    <script>
        function openPayslipModal(period, base, bonus, deductions, net) {
            document.getElementById('modalPeriod').innerText = period;
            document.getElementById('modalBase').innerText = '$' + base;
            document.getElementById('modalBonus').innerText = bonus;
            document.getElementById('modalDeductions').innerText = deductions;
            document.getElementById('modalNet').innerText = net;
            
            document.getElementById('payslipModal').style.display = 'flex';
        }

        function closePayslipModal() {
            document.getElementById('payslipModal').style.display = 'none';
        }
    </script>

</x-app-layout>
