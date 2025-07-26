@extends('layouts.chairman')

@section('content')


<div class="main-container p-3 bg-gray-100 h-100 overflow-auto">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2  mb-3">

        <div>
            <h1 class="text-[25px] font-extrabold text-dark">Chairman dashboard</h1>
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
            
    <!--Manage Request Table -->
    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3">

            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide">
                    <tr>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Id.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Req. Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Dept.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Submitted</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Needed</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Desc.</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasRequests = false;
                    @endphp
                    
                    @foreach($requests as $request)
                        @if ($request->department === auth()->user()->department && $request->chairman_status !== 'Approved')
                            @php $hasRequests = true; @endphp
                            <tr>
                                <td class="px-3 py-4 text-sm text-gray-800 text-left">{{ $request->user_id }}</td>
                                <td class="px-3 text-sm text-gray-800">{{ $request->requester_name }}</td>
                                <td class="px-3 text-sm text-gray-800">{{ $request->department }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-dark capitalize">
                                    <div>
                                        <span class="font-bold">{{ $request->item_name }}</span>
                                        @if($request->variant_value)
                                            <div class="text-gray-500">{{ $request->variant_value }}</div>
                                        @endif
                                    </div>
                                </td> 
                                <td class="px-3 text-sm text-gray-800">{{ $request->quantity }}</td>
                                <td class="px-3 text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('Y-m-d') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($request->datetime)->format('H:i:s') }}
                                </td>
                                <td class="px-3 text-sm text-gray-800">
                                    <span class="border-b border-dark">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                                    </span>
                                    <br>
                                    <span class="text-blue-500 font-semibold animate-beat">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('l') }}
                                    </span>
                                </td>    
                                <td class="px-3 text-md text-gray-800 max-w-[10px] truncate" title="{{ $request->description }}">
                                    {{ $request->description }}
                                </td>
                                <td class="px-3 text-sm text-gray-800">
                                    <div class="flex justify-center items-center">
                                        @if(strpos($request->chairman_status, 'Approved') === false)
                                            <button type="button" 
                                                    onclick="showApprovalModal({{ $request->id }})"
                                                    class="px-3 py-2 bg-teal-500 text-white rounded hover:bg-teal-700" 
                                                    title="Approve">
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
            <div id="confirmApprovalModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-auto p-6 m-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Confirm Approval</h3>
                    <p class="text-gray-700 mb-6">Are you sure you want to approve this request?</p>
                    <div class="flex justify-end space-x-2">
                        <button id="cancelApproval" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>
                        <button id="confirmApproval" class="px-4 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded-md transition">Confirm</button>
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

document.getElementById('cancelApproval').addEventListener('click', function() {
    document.getElementById('confirmApprovalModal').classList.add('hidden');
});

document.getElementById('confirmApproval').addEventListener('click', function() {
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

    // Send AJAX request to approve
    fetch(`/chairman/requests/${currentRequestId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Network response was not ok');
            });
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            title: 'Success!',
            text: data.message || 'Request approved successfully!',
            icon: 'success',
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
            title: 'Error!',
            text: error.message || 'There was a problem approving the request.',
            icon: 'error',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        console.error('Error:', error);
    });
});

    //Search function only requester name
 
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




    // Check if Admin has approved
    document.addEventListener('DOMContentLoaded', () => {

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
