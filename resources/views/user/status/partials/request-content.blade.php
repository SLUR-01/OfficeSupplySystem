    {{-- Request-content --}}
    <div class="gap-2 rounded-md gap-30 flex items-start mb-3">
   
        <div class="relative w-full flex-grow sm:flex-grow-0">
          <input type="text" id="requestSearchInput"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search request by Item Name">
          <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
          </svg>
        </div>
    </div>

    <div class="bg-white rounded-lg overflow-hidden shadow-md">

        <div class="overflow-x-auto px-3">
  
        
          <table id="requestTable" class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-white tracking-wide">
                    <tr>
                        <th class="py-3 text-left text-sm text-gray-600 uppercase">REQUEST ID</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Quantity</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date &amp; Time</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Needed</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Approval</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Withdrawal</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody id="requestTbody" class="bg-white divide-y divide-gray-200">
                    @php
                        $hasRequests = false;
                    @endphp
                    
                    @foreach($requests as $request)
                    @if ($request->department === auth()->user()->department && $request->withdrawal_status !== 'Completed')
                            @php
                                $hasRequests = true;
                            @endphp
                            <tr>
                                <td class="py-3 whitespace-nowrap text-sm font-semibold text-dark uppercase">
                                 
                                    REQ#: {{ $request->id }}
                                </td>
                            
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
                                 <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-700">{{ $request->quantity }}</td>
                                 <td class="px-3 text-sm text-dark">
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('d/m/Y') }}                                            <br>
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('h:i A') }}
                                </td>
                                <td class="px-3 text-sm ">
                                    <span class="border-b border-dark">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                                    </span>
                                    <br>
                                    <span class="text-blue-500 font-semibold">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('l') }}
                                    </span>
                                </td>  
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex items-center space-x-4">
                                        <!-- Chairman Progress Bar -->
                                        <div class="w-full">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="{{ strpos($request->chairman_status, 'Approved') !== false ? 'bg-teal-500' : 'bg-gray-300' }} h-2.5 rounded-full" 
                                                    style="width: {{ strpos($request->chairman_status, 'Approved') !== false ? '100%' : '0%' }}"></div>
                                            </div>
                                            <span class="block mt-2 text-md text-center font-medium {{ strpos($request->chairman_status, 'Approved') !== false ? 'text-teal-600 font-semibold' : 'text-gray-500' }}">
                                                <i class="fas fa-user-tie"></i>
                                            </span>
                                        </div>
                                
                                        <!-- Dean Progress Bar -->
                                        <div class="w-full">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="{{ strpos($request->dean_status, 'Approved') !== false ? 'bg-teal-500' : 'bg-gray-300' }} h-2.5 rounded-full" 
                                                    style="width: {{ strpos($request->dean_status, 'Approved') !== false ? '100%' : '0%' }}"></div>
                                            </div>
                                            <span class="block text-center mt-2 text-md font-medium {{ strpos($request->dean_status, 'Approved') !== false ? 'text-teal-600 font-semibold' : 'text-gray-500' }}">
                                                <i class="fas fa-user-graduate"></i>
                                            </span>
                                        </div>
                                
                                        <!-- Admin Progress Bar -->
                                        <div class="w-full">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="{{ strpos($request->admin_status, 'Approved') !== false ? 'bg-teal-500' : 'bg-gray-300' }} h-2.5 rounded-full" 
                                                    style="width: {{ strpos($request->admin_status, 'Approved') !== false ? '100%' : '0%' }}"></div>
                                            </div>
                                            <span class="block text-center mt-2 text-md font-medium {{ strpos($request->admin_status, 'Approved') !== false ? 'text-teal-600 font-semibold' : 'text-gray-500' }}">
                                                <i class="fas fa-user-shield"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm  flex justify-center items-center space-x-2">
                                    <span class="inline-flex px-2 py-1 leading-5 font-semibold rounded-full
                                        @if($request->withdrawal_status === 'Pending')
                                          bg-yellow-100 text-yellow-700
                                        @elseif($request->withdrawal_status === 'Processing')
                                            bg-orange-100 text-orange-700 
                                        @elseif($request->withdrawal_status === 'Ready to Pick Up')
                                            bg-blue-100 text-blue-700 animate-beat    
                                        @else
                                            bg-green-100 text-green-800
                                        @endif">
                                        {{ $request->withdrawal_status }}
                                    </span>
                                
                          
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-md font-medium text-center">
                                    @if($request->withdrawal_status === 'Ready to Pick Up')
                                        <button onclick="showPrintModal('{{ $request->id }}')" 
                                                class="px-3 py-2 bg-teal-500 text-white rounded hover:bg-teal-700">
                                                Print Receipt
                                                {{-- <i class="fas fa-print mr-2 text-white"></i>Print --}}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    
                    @if(!$hasRequests)
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="mt-2 text-lg font-medium text-gray-600">No requests found</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tr id="no-requests-row" style="display: none;">
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                      No requests found.
                    </td>
                </tr>
          </table>
            
            <!-- Print Modal -->
            <div id="printModal" class="fixed inset-0 z-50 hidden overflow-y-auto  mt-2">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class=" text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modalTitle">
                                        Request Details - REQ#<span id="modalRequestId"></span>
                                    </h3>
                                    <div class="mt-4">
                                        <div id="printContent" class="bg-gray-50 p-4 rounded-lg">
                                            <!-- Content will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 flex justify-end h-50 gap-2">
                            <button type="button" onclick="closePrintModal()" 
                                        class="px-4 py-2 inline-flex justify-center text-white rounded-md bg-gray-500 hover:bg-gray-700">
                                Cancel
                            </button>
                            <button type="button" onclick="printRequest()"
                                 class="flex justify-center items-center text-white bg-teal-600 hover:bg-teal-700 px-4 rounded-md ">

                                <i class="fas fa-print mr-2 text-white"></i> Print
                            </button>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>

  
   

    </div>


<script>

    const requestSearchInput = document.getElementById('requestSearchInput');
    requestSearchInput.addEventListener('input', filterRequests);


  function filterRequests() {

    const searchValue = requestSearchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#requestTbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
      // Skip the "No request" row
      if (row.id === 'no-requests-row') return;

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
    const noResultsRow = document.getElementById('no-requests-row');
    if (visibleCount === 0) {
      noResultsRow.style.display = '';
      if (searchValue !== 'all') {
        noResultsRow.querySelector('td').textContent = `No requests found.`;
      }
    } else {
      noResultsRow.style.display = 'none';
    }
  }

    
        function showPrintModal(requestId) {
            const request = @json($requests->keyBy('id'));
            const reqData = request[requestId];
            const requesterName = document.querySelector('input[name="requester_name"]')?.value || reqData.requestor_name || 'N/A';
    
            document.getElementById('modalRequestId').textContent = requestId;
    
            const printContent = document.getElementById('printContent');
            printContent.innerHTML = `
                <div class="overflow-y-auto">
                    <div class="mb-4">
                        <h4 class="font-bold text-lg mb-2">Requester Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-start"><span class="font-semibold">ID:</span> ${requestId}</p>
                                <p class="text-sm text-start"><span class="font-semibold">Requester Name:</span> ${requesterName}</p>
                                <p class="text-sm text-start"><span class="font-semibold">Department:</span> ${reqData.department}</p>
                            </div>
                            <div>
                                <p class="text-sm text-start"><span class="font-semibold">Date Requested:</span> ${new Date(reqData.datetime).toLocaleString()}</p>
                                <p class="text-sm text-start"><span class="font-semibold">Date Withdrawn:</span> ${reqData.withdrawn_at ? new Date(reqData.withdrawn_at).toLocaleString() : new Date().toLocaleString()}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold text-lg mb-2">Item Details</h4>
                        <table class="min-w-full border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 text-start py-2 text-left">Item Name</th>
                                    <th class="border px-4 text-start py-2 text-left">Quantity</th>
                                    <th class="border px-4 text-start py-2 text-left">Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 text-start py-2">${reqData.item_name}</td>
                                    <td class="border px-4 text-start py-2">${reqData.quantity}</td>
                                    <td class="border px-4 text-start py-2">${reqData.unit || 'N/A'}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-center text-xs text-gray-500">
                        <p>This is an official document. Please present this when picking up your items.</p>
                        <p class="mt-1">Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                </div>
            `;
    
            document.getElementById('printModal').classList.remove('hidden');
        }
    
        function closePrintModal() {
            document.getElementById('printModal').classList.add('hidden');
        }
    
        function printRequest() {
            closePrintModal();
    
            const printStyles = `
                <style>
                    @media print {
                        body * { visibility: hidden; background: white !important; }
                        .print-receipt, .print-receipt * { visibility: visible; background: white !important; }
                        .print-receipt { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        @page { size: letter; margin: 10mm; }
                    }
                    .print-receipt { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; }
                    .print-receipt table { width: 100%; border-collapse: collapse; margin: 15px 0; }
                    .print-receipt th, .print-receipt td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .print-receipt th { background-color: #f2f2f2 !important; }
                </style>
            `;
    
            const printDiv = document.createElement('div');
            printDiv.className = 'print-receipt';
            printDiv.innerHTML = `
                <h3 style="color: #1a365d; margin-bottom: 15px; text-align: center;">
                    Request Details - REQ#${document.getElementById('modalRequestId').textContent}
                </h3>
                ${document.getElementById('printContent').innerHTML}
            `;
            document.body.appendChild(printDiv);
            document.head.insertAdjacentHTML('beforeend', printStyles);
    
            setTimeout(() => {
                window.print();
                setTimeout(() => {
                    printDiv.remove();
                    document.querySelectorAll('style[media="print"]').forEach(style => style.remove());
                }, 100);
            }, 200);
        }
    
       

    </script>
    