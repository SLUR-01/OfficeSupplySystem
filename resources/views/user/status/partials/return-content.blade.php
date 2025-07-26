 {{-- Returns-Content --}}

    
    @if (session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
    @endif

            
    <div class="gap-2 rounded-md gap-30 flex items-start mb-3">
   
        <div class="relative w-full flex-grow sm:flex-grow-0">
          <input type="text" id="returnSearchInput"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search request by Item Name">
          <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
          </svg>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3">
        
       
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide">
                    <th class="py-3 text-left text-sm text-gray-600 uppercase">Return ID</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty. Returned</th>

                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Return Date</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Condition</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Status</th>
           
                    </tr>
                </thead>
                <tbody id="returnTbody" class="bg-white divide-y divide-gray-200">
                    @foreach($returns as $return)
                    @if($return->replacement_status !== 'completed' && $return->return_status !== 'rejected')

                            <tr>
                                <td class="py-4 whitespace-nowrap text-sm font-semibold text-dark uppercase">RETURN#: {{ $return->id }}</td>
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
                                <td class="px-3 py-3 whitespace-nowrap text-sm textdark capitalize">{{ $return->quantity }}</td>
                                <td class="px-3 py-3 whitespace-nowrap text-sm textdark capitalize">
                                    {{ \Carbon\Carbon::parse($return->return_date)->format('m/d/Y') }}
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-sm textdark capitalize">
                                    @switch($return->condition)
                                    @case('defective')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{$return->condition}} </span>
                                        @break
                                    @case('damaged')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">{{$return->condition}}</span>
                                        @break
                                    @case('wrong_item')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Wrong Item</span>
                                    @break
                                    @default
                                @endswitch
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap text-sm textdark capitalize">
                                    
                                    @switch($return->return_status)
                                    @case('approved')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @break
                                    @case('rejected')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-green-800">Rejected</span>
                                    @break
                          
                          
                                    @default
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endswitch
                                </td>
                            

                    
                            </tr>
                        @endif
                    @endforeach
                    
                
                </tbody>
                <tr id="no-return-row" style="display: none;">
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                      No requests found.
                    </td>
                </tr>
            </table>
        </div>

   </div>



    <script>
         const returnSearchInput = document.getElementById('returnSearchInput');
         returnSearchInput.addEventListener('input', filterRequests);

function filterRequests() {
    const searchValue = returnSearchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#returnTbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
        // Skip the "No request" row
        if (row.id === 'no-return-row') return;

        const nameCell = row.querySelector('td:nth-child(2)');
        const matchesSearch = nameCell.textContent.toLowerCase().includes(searchValue);

        if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Show/hide the "no requests" message
    const noResultsRow = document.getElementById('no-return-row');
    if (visibleCount === 0) {
        noResultsRow.style.display = '';
        noResultsRow.querySelector('td').textContent = 'No requests found.';
    } else {
        noResultsRow.style.display = 'none';
    }
}

    </script>