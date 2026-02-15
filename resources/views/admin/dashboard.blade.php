@extends('layouts.admin')

@section('content')
    <div class="main-container h-full bg-gray-100 p-3">

        <div class="p-6">

            <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

            <!-- Summary Cards -->
            <div class="mb-6 flex flex-wrap lg:flex-nowrap gap-6 mb-10 w-full">

                <!-- Total Stocks -->
                <div
                    class="flex-1 min-w-[260px] bg-white border border-gray-200 rounded-md p-6 shadow-sm hover:shadow-md transition duration-200">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Total Stock Items
                            </p>

                            <h2 class="text-3xl font-semibold text-gray-900 mt-2">
                                {{ $totalStocks }}
                            </h2>

                            <p class="text-xs text-gray-400 mt-2">
                                Current inventory count
                            </p>
                        </div>

                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-md flex items-center justify-center">
                            <i class='bx bx-box text-2xl'></i>
                        </div>

                    </div>
                </div>


                <!-- Low Stocks -->
                <div
                    class="flex-1 min-w-[260px] bg-white border border-gray-200 rounded-md p-6 shadow-sm hover:shadow-md transition duration-200">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Low Stock Items
                            </p>

                            <h2 class="text-3xl font-semibold text-gray-900 mt-2">
                                {{ $lowStocks }}
                            </h2>

                            <p class="text-xs text-gray-400 mt-2">
                                Items below reorder level
                            </p>
                        </div>

                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-md flex items-center justify-center">
                            <i class='bx bx-error-circle text-2xl'></i>
                        </div>

                    </div>
                </div>


                <!-- Pending Requests -->
                <div
                    class="flex-1 min-w-[260px] bg-white border border-gray-200 rounded-md p-6 shadow-sm hover:shadow-md transition duration-200">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Pending
                            </p>

                            <h2 class="text-3xl font-semibold text-gray-900 mt-2">
                                {{ $pendingRequests }}
                            </h2>

                            <p class="text-xs text-gray-400 mt-2">
                                Awaiting approval
                            </p>
                        </div>

                        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-md flex items-center justify-center">
                            <i class='bx bx-time-five text-2xl'></i>
                        </div>

                    </div>
                </div>


                <!-- Completed Requests -->
                <div
                    class="flex-1 min-w-[260px] bg-white border border-gray-200 rounded-md p-6 shadow-sm hover:shadow-md transition duration-200">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Completed
                            </p>

                            <h2 class="text-3xl font-semibold text-gray-900 mt-2">
                                {{ $completedRequests }}
                            </h2>

                            <p class="text-xs text-gray-400 mt-2">
                                Successfully processed
                            </p>
                        </div>

                        <div class="w-16 h-16 bg-green-100 text-teal-600 rounded-md flex items-center justify-center">
                            <i class='bx bx-check-circle text-2xl'></i>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Withdrawal History Table -->
            <div class="mt-10 bg-white border border-gray-200 rounded-md shadow-sm">

                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Recent Withdrawal History
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Latest completed supply withdrawals
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">

                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Requester</th>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Department</th>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Items Withdrawn</th>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Quantity</th>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Date Completed</th>
                                <th class="text-left px-6 py-3 font-md text-gray-600">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($withdrawalHistory as $request)
                                <tr class="hover:bg-gray-50 transition">

                                    <!-- Requester -->
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $request->requester_name }}
                                    </td>

                                    <!-- Department -->
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $request->department }}
                                    </td>

                                    <!-- Items -->
                                    <td class="px-6 py-4 text-gray-700">
                                        <ul class="space-y-1">
                                            @foreach ($request->items as $item)
                                                <li>
                                                    {{ $item->item_name }}
                                                    @if ($item->variant_value)
                                                        ({{ $item->variant_value }})
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <!-- Quantity -->
                                    <td class="px-6 py-4 text-gray-700">
                                        <ul class="space-y-1">
                                            @foreach ($request->items as $item)
                                                <li class="font-medium">
                                                    {{ $item->quantity }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>


                                    <!-- Date -->
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Carbon\Carbon::parse($request->completed_at)->format('M d, Y h:i A') }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">
                                            Completed
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                        No completed withdrawals yet.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                    @if ($withdrawalHistory->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $withdrawalHistory->links() }}
                        </div>
                    @endif

                </div>
            </div>


            <!-- Filter & Print -->
            <div class="flex justify-between items-center mt-4 mb-4">
                <form method="GET" class="flex gap-2">
                    <input type="month" name="month" value="{{ $month }}" class="border p-2 rounded">
                    <button
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 transition duration-200">
                        <i class='bx bx-filter-alt text-lg'></i>
                        <span class="font-medium">Filter</span>
                    </button>

                </form>

                <button onclick="printReport()"
                    class="inline-flex items-center gap-2 bg-teal-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-teal-700 transition duration-200">

                    <i class='bx bx-printer text-lg'></i>
                    <span class="font-medium">Print Report</span>

                </button>

            </div>

            <!-- Printable Area -->
            <div id="printArea" class="bg-white p-6 rounded shadow">

                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold">
                        Monthly Inventory Report
                    </h2>
                    <p class="text-sm">
                        {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                    </p>
                </div>

                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2">Item Name</th>
                            <th class="border px-3 py-2">Variant</th>
                            <th class="border px-3 py-2">Current Stock</th>
                            <th class="border px-3 py-2">Total Withdrawn</th>
                            <th class="border px-3 py-2">Remaining Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyReport as $item)
                            <tr class="text-center">
                                <td class="border px-3 py-2 text-left">{{ $item->item_name }}</td>
                                <td class="border px-3 py-2 text-left">{{ $item->variant_value ?? '-' }}</td>
                                <td class="border px-3 py-2 text-left">{{ $item->current_stock }}</td>
                                <td class="border px-3 py-2 text-left">{{ $item->total_withdrawn }}</td>
                                <td class="border px-3 py-2 font-semibold text-left">
                                    {{ $item->remaining_stocks }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No records found for this month.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 text-xs text-gray-500">
                    Generated on {{ now()->format('F d, Y h:i A') }}
                </div>

            </div>

        </div>


        <script>
            function printReport() {

                var printContents = document.getElementById('printArea').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = `
        <div style="padding:40px;">
            ${printContents}
        </div>
    `;

                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }
        </script>


    </div>
@endsection
