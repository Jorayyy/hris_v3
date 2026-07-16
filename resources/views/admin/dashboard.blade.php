<x-app-layout>
    <x-slot name="header">
        <div style="display: flex !important; justify-content: space-between !important; align-items: center !important;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: #1f2937 !important; margin: 0 !important;">
                {{ __('HR Administrative Dashboard') }}
            </h2>
            
            <!-- 🟢 DUAL VIEW SWITCHER: ADMIN CLOCK IN Gateway Link -->
            <a href="{{ route('admin.index', ['view' => 'attendance']) }}" style="background-color: #059669 !important; color: #ffffff !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-size: 0.875rem !important; text-decoration: none !important; display: inline-block !important;">
                <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">⏱️ Clock My Attendance</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" style="background-color: #f9fafb !important;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Status Messages -->
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" style="background-color: #d1fae5 !important; color: #065f46 !important; border-color: #a7f3d0 !important; margin-bottom: 1.5rem;">
                    <span style="display: inline !important; color: inherit !important;">{{ session('status') }}</span>
                </div>
            @endif

            <!-- ADMIN ACTION ROW -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="display: grid; gap: 1.5rem;">
                
                <!-- TIME OFF APPROVALS QUEUE -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200 md:col-span-2" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Pending Leave Applications</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Employee</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Type</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Duration</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important; text-align: right !important;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingLeaves as $leave)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.75rem 0.5rem !important; font-weight: 600 !important; color: #111827 !important;">{{ $leave->user->name }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important;">{{ $leave->leave_type }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; font-size: 0.75rem !important;">{{ $leave->start_date }} to {{ $leave->end_date }}</td>
                                        <td style="padding: 0.75rem 0.5rem !important; text-align: right !important;">
                                            <form action="{{ route('admin.leave.update', [$leave->id, 'Approved']) }}" method="POST" style="display: inline-block !important;">
                                                @csrf
                                                <button type="submit" style="background-color: #059669 !important; color: #ffffff !important; font-size: 0.75rem !important; font-weight: 700 !important; padding: 0.25rem 0.75rem !important; border-radius: 0.25rem !important; margin-right: 0.25rem !important; border: none !important; cursor: pointer !important;">
                                                    <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">Approve</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.leave.update', [$leave->id, 'Denied']) }}" method="POST" style="display: inline-block !important;">
                                                @csrf
                                                <button type="submit" style="background-color: #dc2626 !important; color: #ffffff !important; font-size: 0.75rem !important; font-weight: 700 !important; padding: 0.25rem 0.75rem !important; border-radius: 0.25rem !important; border: none !important; cursor: pointer !important;">
                                                    <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">Deny</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">All clear!</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                                <!-- ADD NEW WORKER REGISTRATION CARD -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Onboard New Employee</h3>
                    <form action="{{ route('admin.employee.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @csrf
                        <input type="text" name="name" placeholder="Full Name" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        <input type="email" name="email" placeholder="Corporate Email Address" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        <input type="password" name="password" placeholder="Temporary System Password" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        <input type="text" name="department" placeholder="Department (e.g. Sales)" style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        <input type="text" name="job_title" placeholder="Job Designation Title" style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">
                        <div>
    <label style="font-size: 0.75rem !important; font-weight: 600 !important; color: #4b5563 !important; display: block !important; margin-bottom: 0.25rem !important;">Assign Payroll Processing Group</label>
    <select name="group_id" style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important; background-color: #ffffff !important;">
        <option value="">No Group (Manual Individual Processing)</option>
        @foreach(\App\Models\Group::all() as $gp)
            <option value="{{ $gp->id }}">{{ $gp->name }} ({{ ucfirst($gp->pay_frequency) }})</option>
        @endforeach
    </select>
</div>

                        <input type="number" name="base_salary" step="0.01" placeholder="Base Salary (e.g. 35000.00)" required style="width: 100% !important; border: 1px solid #d1d5db !important; border-radius: 0.375rem !important; padding: 0.5rem !important; font-size: 0.875rem !important;">

                        <button type="submit" style="width: 100% !important; background-color: #4f46e5 !important; color: #ffffff !important; font-weight: 600 !important; padding: 0.5rem 1rem !important; border-radius: 0.375rem !important; font-size: 0.875rem !important; margin-top: 0.5rem !important; border: none !important; cursor: pointer !important;">
                            <span style="display: inline !important; color: #ffffff !important; visibility: visible !important;">Register & Activate Profile</span>
                        </button>
                    </form>
                </div>

            </div>

            <!-- MASTER DATA LISTS LOWER WRAPPER -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6" style="display: grid; gap: 1.5rem; margin-top: 1.5rem;">

                            <!-- EMPLOYEE ROSTER REGISTRY -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Active Staff Roster</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Name</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Department</th>
                                    <th style="padding: 0.5rem !important; color: #374151 !important; font-weight: 600 !important;">Role Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $emp)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.5rem !important; font-weight: 500 !important; color: #111827 !important;">{{ $emp->name }}</td>
                                        <td style="padding: 0.5rem !important; font-size: 0.75rem !important;">{{ $emp->department ?? 'Unassigned' }}</td>
                                        <td style="padding: 0.5rem !important; font-size: 0.75rem !important; font-family: monospace !important;">{{ $emp->job_title ?? 'Staff Member' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- DAILY 8-POINT ATTENDANCE MONITOR FEED -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200" style="background-color: #ffffff !important; border: 1px solid #e5e7eb !important; padding: 1.5rem !important; border-radius: 0.5rem !important;">
                    <h3 class="text-lg font-bold text-gray-700 mb-4" style="color: #374151 !important; font-size: 1.125rem !important; font-weight: 700 !important; margin-bottom: 1rem !important;">Today's Attendance Feed</h3>
                    <div class="overflow-x-auto" style="overflow-x: auto !important;">
                        <table class="w-full text-left text-xs text-gray-500" style="width: 100% !important; text-align: left !important; border-collapse: collapse !important; font-size: 0.70rem !important;">
                            <thead style="background-color: #f3f4f6 !important;">
                                <tr>
                                    <th style="padding: 0.25rem !important; color: #374151 !important; font-weight: 600 !important;">Employee</th>
                                    <th style="padding: 0.25rem !important; color: #059669 !important; font-weight: 600 !important;">IN</th>
                                    <th style="padding: 0.25rem !important; color: #b45309 !important; font-weight: 600 !important;">B1_O</th>
                                    <th style="padding: 0.25rem !important; color: #4338ca !important; font-weight: 600 !important;">B1_I</th>
                                    <th style="padding: 0.25rem !important; color: #c2410c !important; font-weight: 600 !important;">LN_O</th>
                                    <th style="padding: 0.25rem !important; color: #4338ca !important; font-weight: 600 !important;">LN_I</th>
                                    <th style="padding: 0.25rem !important; color: #b45309 !important; font-weight: 600 !important;">B2_O</th>
                                    <th style="padding: 0.25rem !important; color: #4338ca !important; font-weight: 600 !important;">B2_I</th>
                                    <th style="padding: 0.25rem !important; color: #b91c1c !important; font-weight: 600 !important;">OUT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayLogs as $log)
                                    <tr style="border-bottom: 1px solid #e5e7eb !important;">
                                        <td style="padding: 0.5rem 0.25rem !important; font-weight: 600 !important; color: #111827 !important;">{{ $log->user->name }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->clock_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->break1_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->break1_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->lunch_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->lunch_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->break2_out ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important;">{{ $log->break2_in ?? '-' }}</td>
                                        <td style="padding: 0.5rem 0.25rem !important; font-weight: 600 !important;">{{ $log->clock_out ?? 'On Clock' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" style="padding: 1rem !important; text-align: center !important; color: #9ca3af !important;">No logs yet today.</td></tr>
                                @endforelse
                            </tbody>
                        </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
