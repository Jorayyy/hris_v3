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

            </div>

        </div>
    </div>
</x-app-layout>
