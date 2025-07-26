
 {{-- Withdrawals-Content --}}
 <form method="GET" action="{{ route('user.history.history') }}" class="mb-4">
    <label for="month" class="text-md text-gray-700 mr-2">Filter by Month:</label>
    <input type="month" name="month" id="month" value="{{ request('month') ?? now()->format('Y-m') }}"
           class="border border-gray-300 rounded px-2 py-1 text-sm">
    <button type="submit" class="ml-2 px-3 py-1 bg-teal-600 text-white rounded text-sm">Filter</button>
</form>


<div id="withdrawal-content" class="bg-white shadow rounded-md mx-auto">
    <div id="noDataMessageWithdrawal" class="hidden text-center p-5 text-gray-500">
        No matching requests found.
    </div>

    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide">
                    <tr>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Quantity</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Submitted</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Completed</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Withdrawal</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Withdrawn By</th>
                    </tr>
                </thead>
                <tbody id="withdrawalTableBody" class="bg-white divide-y divide-gray-200">
                    @foreach($requests as $request)
                    <tr class="hover:bg-gray-50" 
                        data-completed="{{ \Carbon\Carbon::parse($request->completed_at)->format('Y-m-d') }}">
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-dark capitalize">
                            <div>
                              <!-- Bold item name -->
                              <span class="font-bold">{{ $request->item_name }}</span>
                              
                              <!-- Colored variant value on new line -->
                              @if($request->variant_value)
                                <div class="text-gray-500">{{ $request->variant_value }}</div>
                              @endif
                            </div>
                        </td>
                        <td class="px-3 py-3 text-sm text-dark">
                            {{ $request->net_quantity }}
                        </td>
                        
                        
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">
                            {{ \Carbon\Carbon::parse($request->datetime)->format('m/d/y h:i A') }}
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">
                            {{ \Carbon\Carbon::parse($request->completed_at)->format('m/d/y h:i A') }}
                        </td>
                        
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $request->withdrawal_status }}
                            </span>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">{{ $request->withdrawn_by}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('filterDate').addEventListener('input', function () {
        filterWithdrawals(this.value);
    });

    document.getElementById('showAllWithdrawals').addEventListener('click', function () {
        document.getElementById('filterDate').value = "";
        filterWithdrawals(""); // reset filter
    });

    function filterWithdrawals(selectedDate) {
        const rows = document.querySelectorAll('#withdrawalTableBody tr');
        let hasMatch = false;

        rows.forEach(row => {
            const completedAt = row.getAttribute('data-completed'); // get formatted date 'Y-m-d'

            if (selectedDate === "" || selectedDate === completedAt) {
                row.style.display = "";
                hasMatch = true;
            } else {
                row.style.display = "none";
            }
        });

        // Show the "No matching requests found." message if no matches are found
        document.getElementById('noDataMessageWithdrawal').classList.toggle('hidden', hasMatch);
    }
</script>



