<x-admin-layout>
    <div class="space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">IT Service Desk Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">Live overview of tickets recorded in the NEUST Ticketing System.</p>
            </div>
            <div class="text-sm text-gray-500">Updated {{ now()->format('M d, Y · h:i A') }}</div>
        </div>

        @php
            $cards = [
                ['label' => 'Total Tickets', 'value' => $totalTickets, 'icon' => 'ticket', 'tone' => 'blue'],
                ['label' => 'For Approval', 'value' => $forApproval, 'icon' => 'clipboard-check', 'tone' => 'amber'],
                ['label' => 'Work In Progress', 'value' => $workInProgress, 'icon' => 'activity', 'tone' => 'violet'],
                ['label' => 'Pending', 'value' => $pending, 'icon' => 'clock', 'tone' => 'orange'],
                ['label' => 'Completed', 'value' => $completed, 'icon' => 'check-circle', 'tone' => 'green'],
                ['label' => 'Accepted', 'value' => $accepted, 'icon' => 'check', 'tone' => 'cyan'],
                ['label' => 'Acknowledged', 'value' => $acknowledged, 'icon' => 'bell-ring', 'tone' => 'slate'],
            ];
            $toneClasses = [
                'blue' => 'bg-blue-50 text-blue-700 ring-blue-100',
                'amber' => 'bg-amber-50 text-amber-700 ring-amber-100',
                'violet' => 'bg-violet-50 text-violet-700 ring-violet-100',
                'orange' => 'bg-orange-50 text-orange-700 ring-orange-100',
                'green' => 'bg-green-50 text-green-700 ring-green-100',
                'cyan' => 'bg-cyan-50 text-cyan-700 ring-cyan-100',
                'slate' => 'bg-slate-100 text-slate-700 ring-slate-200',
            ];
        @endphp

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($cards as $card)
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ $card['label'] }}</p>
                            <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($card['value']) }}</p>
                        </div>
                        <div class="rounded-xl p-3 ring-1 {{ $toneClasses[$card['tone']] }}">
                            @switch($card['icon'])
                                @case('ticket')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 8V5h16v3a3 3 0 0 0 0 6v5H4v-5a3 3 0 0 0 0-6Z"/><path d="M9 8v2m0 4v2"/></svg>
                                    @break
                                @case('clipboard-check')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5h6V7H9zM8 14l2.2 2.2L16 10.5"/></svg>
                                    @break
                                @case('activity')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 12h4l3-8 4 16 3-8h4"/></svg>
                                    @break
                                @case('clock')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    @break
                                @case('check-circle')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/></svg>
                                    @break
                                @case('check')
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 12 4 4L19 6"/></svg>
                                    @break
                                @default
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M10 21h4"/></svg>
                            @endswitch
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-900">Ticket Status Distribution</h2>
                    <p class="mt-1 text-sm text-gray-500">Current count of tickets grouped by status.</p>
                </div>
                <div class="relative h-72">
                    <canvas id="statusChart" aria-label="Ticket status distribution chart"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-900">Monthly Ticket Trend</h2>
                    <p class="mt-1 text-sm text-gray-500">Tickets created in the last six calendar months.</p>
                </div>
                <div class="relative h-72">
                    <canvas id="monthlyChart" aria-label="Monthly ticket trend chart"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-900">Tickets by Department</h2>
                    <p class="mt-1 text-sm text-gray-500">Top eight departments by ticket volume.</p>
                </div>
                <div class="relative h-80">
                    <canvas id="departmentChart" aria-label="Tickets by department chart"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-900">Tickets by Category</h2>
                    <p class="mt-1 text-sm text-gray-500">Top eight categories by ticket volume.</p>
                </div>
                <div class="relative h-80">
                    <canvas id="categoryChart" aria-label="Tickets by category chart"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm xl:col-span-2">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-900">Tickets by Priority</h2>
                    <p class="mt-1 text-sm text-gray-500">Classification counts for High, Medium, and Low priority tickets.</p>
                </div>
                <div class="relative h-64">
                    <canvas id="priorityChart" aria-label="Tickets by priority chart"></canvas>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900">Recent Tickets</h2>
                    <p class="mt-1 text-sm text-gray-500">The eight most recently created tickets.</p>
                </div>
                @if (Route::has('admin.ticket.index'))
                    <a href="{{ route('admin.ticket.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">View all tickets <span aria-hidden="true">→</span></a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Ticket No.</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Department</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Category</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Assigned To</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Priority</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($latestTickets as $ticket)
                            @php
                                $statusStyles = [
                                    'For Approval' => 'bg-amber-50 text-amber-700',
                                    'Accepted' => 'bg-cyan-50 text-cyan-700',
                                    'Work In Progress' => 'bg-violet-50 text-violet-700',
                                    'Pending' => 'bg-orange-50 text-orange-700',
                                    'Completed' => 'bg-green-50 text-green-700',
                                    'Aknowledged' => 'bg-slate-100 text-slate-700',
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-gray-900">{{ $ticket->ticket_number ?: ('#' . $ticket->ticket_id) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $ticket->department->department_name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $ticket->category->category_name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">{{ $ticket->classification ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyles[$ticket->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $ticket->status }}</span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $ticket->created_at?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center">
                                    <div class="font-medium text-gray-700">No tickets yet</div>
                                    <p class="mt-1 text-sm text-gray-500">Ticket statistics and charts will populate when records are added.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Chart.js is loaded here so this page does not require a new npm dependency. --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js did not load. Check internet access or install Chart.js through npm.');
                return;
            }

            const statusLabels = @json($statusLabels);
            const statusValues = @json($statusValues);
            const monthlyLabels = @json($monthlyLabels);
            const monthlyValues = @json($monthlyData);
            const departmentLabels = @json($departmentLabels);
            const departmentValues = @json($departmentValues);
            const categoryLabels = @json($categoryLabels);
            const categoryValues = @json($categoryValues);
            const priorityLabels = @json($priorityLabels);
            const priorityValues = @json($priorityValues);

            Chart.defaults.font.family = 'Figtree, ui-sans-serif, system-ui, sans-serif';
            Chart.defaults.color = '#6b7280';
            Chart.defaults.plugins.legend.labels.usePointStyle = true;

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusValues,
                        backgroundColor: ['#f59e0b', '#06b6d4', '#8b5cf6', '#f97316', '#22c55e', '#64748b'],
                        borderWidth: 0,
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Tickets Created',
                        data: monthlyValues,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('departmentChart'), {
                type: 'bar',
                data: {
                    labels: departmentLabels,
                    datasets: [{
                        label: 'Tickets',
                        data: departmentValues,
                        backgroundColor: '#3b82f6',
                        borderRadius: 6,
                        maxBarThickness: 28
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { precision: 0 } },
                        y: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Tickets',
                        data: categoryValues,
                        backgroundColor: '#14b8a6',
                        borderRadius: 6,
                        maxBarThickness: 32
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('priorityChart'), {
                type: 'bar',
                data: {
                    labels: priorityLabels,
                    datasets: [{
                        label: 'Tickets',
                        data: priorityValues,
                        backgroundColor: ['#ef4444', '#f59e0b', '#22c55e'],
                        borderRadius: 6,
                        maxBarThickness: 72
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
