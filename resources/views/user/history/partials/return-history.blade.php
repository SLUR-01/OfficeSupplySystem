
<div class="flex justify-end mb-3">
    <label for="statusFilter" class="mr-2 text-sm text-gray-700">Filter by Status:</label>
    <select id="statusFilter" class="border border-gray-300 rounded-md text-sm px-2 py-1">
        <option value="all">All</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
        <option value="pending">Pending</option>
    </select>
</div>


  {{-- Returns-Content --}}
  <div id="return-content" class="bg-white shadow rounded-md mx-auto ">
      @if(!$requests->contains('withdrawal_status', 'Completed'))
      <p class="text-center text-gray-500">No completed withdrawals found.</p>
      @else
      <div id="noDataMessageReturn" class="hidden text-center p-5 text-gray-500">
          No matching requests found.
      </div>

      <div class="bg-white rounded-md overflow-hidden shadow-md">
          <div class="overflow-x-auto px-3">
              <table class="min-w-full bg-white divide-y divide-gray-200">
                  <thead class="bg-white tracking-wide">
                      <tr>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty. Returned</th>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty. Recieved</th>

                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Return Date</th>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Condition</th>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Status</th>
                          <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Replacement</th>
                      </tr>
                  </thead>
                  <tbody id="returnTableBody" class="bg-white divide-y divide-gray-200">
                      @foreach($returns as $return)
                      @if(in_array($return->return_status, ['approved', 'rejected', 'pending']))

                          <tr data-status="{{ $return->return_status }}">

                            <td class="px-3 py-4 whitespace-nowrap text-sm text-dark capitalize">
                                <div>
                                  <!-- Bold item name -->
                                  <span class="font-bold">{{ $return->item_name }}</span>
                                  
                                  <!-- Colored variant value on new line -->
                                  @if($return->variant_value)
                                    <div class="text-gray-500">{{ $return->variant_value }}</div>
                                  @endif
                                </div>
                            </td>                              
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $return->quantity }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $return->quantity_received }}</td>
                              <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">
                                  {{ \Carbon\Carbon::parse($return->return_date)->format('m/d/Y') }}
                              </td>
                              <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700 capitalize">
                                @switch($return->condition)
                                @case('defective')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Defective</span>
                                    @break
                                @case('damaged')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Damaged</span>
                                    @break
                                @default
                            @endswitch
                              </td>
                              <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700 capitalize">
                                @switch($return->return_status)
                                @case('approved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @break
                                @case('rejected')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @break
                    
                      
                                @default
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endswitch
                              </td>
                              <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">
                                  <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                
                                      {{ $return->replacement_status }}
                                  </span>
                              </td>
                          </tr>
                          @endif
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
      @endif
  </div>
  <script>
    document.getElementById('statusFilter').addEventListener('change', function () {
        const selected = this.value;
        const rows = document.querySelectorAll('#returnTableBody tr');
        let hasVisibleRow = false;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (selected === 'all' || status === selected) {
                row.style.display = '';
                hasVisibleRow = true;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('noDataMessageReturn').classList.toggle('hidden', hasVisibleRow);
    });
</script>


   

  



