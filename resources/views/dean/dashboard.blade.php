@extends('layouts.dean')

@section('content')
    
    
<div class="main-container h-full bg-gray-100 p-3">
        
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 mb-5">

        <div>
            <h1 class="text-[25px] font-extrabold text-dark">Dean dashboard</h1>
            <p class="text-base text-dark mt-2">Approve /  Update Requests</p>
        </div>
        
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="gap-3 rounded-md flex items-start">

        <div class="relative w-full flex-grow sm:flex-grow-0">
        <input type="text" id="searchInput"
                class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search request by name...">
        <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
        </svg>
        </div>
    </div>

    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide">
                    <tr> 
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Id.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Req. Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Dept</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Submitted</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Needed</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Desc.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Approval </th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                    $hasRequests = false;
                    @endphp
                
                    @foreach($requests as $request)
                        @if ($request->department === auth()->user()->department && $request->dean_status !== 'Approved' 
                             && $request->chairman_status === "Approved") 
                              @php $hasRequests = true; @endphp {{-- Ensure correct department --}}
                            <tr>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">{{ $request->user_id }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800">{{ $request->requester_name }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800">{{ $request->department }}</td>
                                <td class="px-3 py-3 whitespace-nowrap text-sm text-dark capitalize">
                                    <div>
                                      <!-- Bold item name -->
                                      <span class="font-bold">{{ $request->item_name }}</span>
                                      
                                      <!-- Colored variant value on new line -->
                                      @if($request->variant_value)
                                        <div class="text-gray-500">{{ $request->variant_value }}</div>
                                      @endif
                                    </div>
                                  </td> 
                                <td class="px-3 py-3 text-sm text-gray-800">{{ $request->quantity }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('Y-m-d') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('H:i:s') }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-800">
                                    <span class="border-b border-dark">

                                    {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                                   </span>
                                     <br>
                                    <span class="text-blue-500 font-semibold">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('l') }}
                                    </span>
                                </td>                                
                                <td class="px-3 py-3text-md text-gray-800 max-w-[10px] truncate" title="{{ $request->description }}">
                                    {{ $request->description }}
                                </td>
                                <td class="px-3 py-3 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="w-full flex justify-center items-center space-x-2">
                                            {{-- Chairman Progress Bar  --}}
                                        <div class="w-50 text-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="{{ strpos($request->chairman_status, 'Approved') !== false ? 'bg-teal-500' : 'bg-gray-300' }} h-2.5 rounded-full" 
                                                        style="width: {{ strpos($request->chairman_status, 'Approved') !== false ? '100%' : '0%' }}"></div>
                                            </div>
                                            <span class="block mt-2 text-md font-medium {{ strpos($request->chairman_status, 'Approved') !== false ? 'text-teal-600 font-semibold' : 'text-gray-500' }}">
                                                Chair.
                                            </span>
                                        </div>
                                
                                    </div>
                                </td>
                                <td class="px-3 py-3 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col items-center space-y-1 p-2">
                                        @if(strpos($request->dean_status, 'Approved') === false)
                                            <button type="button" 
                                                    onclick="showApprovalModal({{ $request->id }})"
                                                    class="px-3 py-2 bg-teal-500 text-white rounded hover:bg-teal-700">
                                                Approve
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if(!$hasRequests)
                    <tr>
                        <td colspan="9" class="px-3 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="mt-2 text-lg font-medium">No requests found</span>
                                <p class="text-sm text-gray-500">There are currently no pending requests.</p>
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
            <!-- Confirm Approval Modal -->
                
        <!-- Confirm Approval Modal -->
        <div id="confirmApprovalModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-auto p-6 m-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Confirm Approval</h3>
                <p class="text-gray-700 mb-6">Are you sure you want to approve this request?</p>
                <div class="flex justify-end space-x-2">
                    <button id="cancelDeanApproval" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>
                    <button id="confirmDeanApproval" class="px-4 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded-md transition">Confirm</button>
                </div>
            </div>
        </div>
                
        </div>     
    </div>     

</div>
  
<script>

    let currentRequestId = null;

    function showApprovalModal(requestId) {
    currentRequestId = requestId;
    document.getElementById('confirmApprovalModal').classList.remove('hidden');
    }

    document.getElementById('cancelDeanApproval').addEventListener('click', function() {
    document.getElementById('confirmApprovalModal').classList.add('hidden');
    });

    document.getElementById('confirmDeanApproval').addEventListener('click', function() {
    document.getElementById('confirmApprovalModal').classList.add('hidden');

    // Show loading indicator
    Swal.fire({
    title: 'Processing',
    html: 'Approving request...',
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading();
    }
    });

    // Send AJAX request
    fetch(`/approve-request/${currentRequestId}`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
    })
    .then(response => response.json())
    .then(data => {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: data.message,
        timer: 3000, // 3 seconds
        timerProgressBar: true,
        showConfirmButton: false,
        willClose: () => {
            window.location.reload();
        }
    });
    })
    .catch(error => {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'An error occurred while approving the request.',
        timer: 3000,
        timerProgressBar: true
    });
    console.error('Error:', error);
    });
    });

    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', filterRequests);

    function filterRequests() {
    const searchValue = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
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
    noResultsRow.querySelector('td').textContent = `No requests found.`;
    } else {
    noResultsRow.style.display = 'none';
    }
    }




    document.addEventListener('DOMContentLoaded', () => {
    // Check if Admin has approved
    const adminApproved = document.querySelector('.step .approved[data-step="admin"]');

    if (adminApproved) {
    // Add reset class to the progress steps and lines
    const steps = document.querySelectorAll('.step .circle');
    const lines = document.querySelectorAll('.line');

    steps.forEach((step) => step.classList.add('reset'));
    lines.forEach((line) => line.classList.add('reset'));
    }
    });

</script>

       
@endsection
