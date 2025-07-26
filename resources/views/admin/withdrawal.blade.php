
@extends('layouts.admin')

@section('content')


     
<div class="main-container h-full bg-gray-100 p-3">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 md:mb-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Withdrawal Management</h1>
          <p class="text-sm md:text-base text-gray-600 mt-1 mb-3">Manage withdrawal & update withdrawal status</p>
          
        </div>
    </div>
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="gap-3 rounded-md flex items-start">
        <select id="department" class="w-30 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" onchange="filterByDept(this)">
            <option value="all">All Dept</option>
            <option value="cot">COT</option>
            <option value="coed">COED</option>
            <option value="cohtm">COHTM</option>
        </select>
        
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
                <thead class="bg-white tracking-wide font-medium">
                    <tr>
                        <th class="py-3 text-center text-sm text-gray-600 uppercase">Id.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Req. Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Dept.</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Quantity</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Needed</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Purpose</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Withdrawal</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($requests as $request)
                        @if(in_array($request->withdrawal_status, ['Processing', 'Ready to Pick Up']))
                            <tr class="hover:bg-gray-50 transition" data-request-id="{{ $request->id }}">
                                <td class="px-2 py-4 text-sm text-gray-800 text-left">{{ $request->user_id }}</td>
            
                                <td class="px-3 text-md text-gray-800">{{ $request->requester_name }}</td>
                                <td class="px-3 text-md text-gray-800">{{ $request->department }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-dark capitalize">
                                    <div>
                                    <!-- Bold item name -->
                                    <span class="font-bold ">{{ $request->item_name }}</span>
                                    
                                    <!-- Colored variant value on new line -->
                                    @if($request->variant_value)
                                        <div class="text-gray-500">{{ $request->variant_value }}</div>
                                    @endif
                                    </div>
                                </td> 
                                <td class="px-3 text-md text-gray-800">{{ $request->quantity }}</td>
                                <td class="px-3 text-sm text-gray-800">
                                    <span class="border-b border-dark">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                                    </span>
                                    <br>
                                    <span class="text-blue-500 font-semibold">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('l') }}
                                    </span>
                                </td>    
                                <td class="px-3 text-md text-gray-800 max-w-[10px] truncate" title="{{ $request->description }}">
                                    {{ $request->description }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="w-full flex justify-center items-center space-x-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            {{ $request->withdrawal_status === 'Processing' ? 'bg-yellow-100 text-yellow-800' :
                                            ($request->withdrawal_status === 'Ready to Pick Up' ? 'bg-blue-100 text-blue-800 animate-beat' :
                                            'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($request->withdrawal_status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm relative text-center">
                                    <!-- Three Dots Button -->
                                    <button class="action-btn px-3 py-2 rounded-md text-white bg-teal-600 hover:bg-teal-700" onclick="toggleDropdown('dropdown-{{ $request->id }}')">
                                    Update
                                    </button>
                                
                                    <!-- Dropdown Menu -->
                                    <div id="dropdown-{{ $request->id }}" class="dropdown hidden absolute right-7 w-48 bg-white shadow-md border rounded-lg z-50" style="top: -20px; right: 50px;">
                                        @if($request->withdrawal_status === 'Processing')
                                        <button type="button" onclick="confirmReadyToPickUp('{{ $request->id }}')" class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100">
                                            <i class="fas fa-box-open mr-2"></i> Ready to Pick Up
                                        </button>
                                        @endif
                                        
                                        @if($request->withdrawal_status === 'Ready to Pick Up')
                                        <button class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100" 
                                            onclick="openWithdrawModal('{{ $request->id }}')">
                                            <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
              
                </tbody>
                
                <tr id="no-withdrawal-row" style="display: none;">
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                      No requests found.
                    </td>
                </tr>
            </table>
        
            <!-- Withdrawn By Modal -->
            <div id="withdraw-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
                <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center pb-2">
                        <h1 class="text-lg font-semibold">Withdrawal Details</h1>
                        <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800 text-xl focus:outline-none">&times;</button>
                    </div>
                    <form id="withdraw-form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="withdrawal_status" value="Completed">
                        <input type="hidden" name="request_id" id="current-request-id">
            
                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold">Withdrawn By:</label>
                            <input type="text" name="withdrawn_by" id="withdrawn-by" class="w-full  border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold">Completion Date & Time:</label>
                            <input type="datetime-local" name="completed_at" id="completed-at" class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        </div>
            
                        <div class="mt-5 flex justify-end gap-2">
                            <button type="button" onclick="closeModal()" 
                                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none transition duration-200">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 focus:outline-none transition duration-200">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>   

<script>
   // Toggle dropdown
   function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        // Close all other dropdowns first
        document.querySelectorAll('.dropdown').forEach(d => {
            if (d.id !== dropdownId) d.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
    }

    // Update the confirmReadyToPickUp function
    function confirmReadyToPickUp(requestId) {
        Swal.fire({
            title: 'Confirm Status Change',
            html: 'Are you sure you want to mark this request as <br><strong>"Ready to Pick Up"</strong>?',
            icon: 'question',
            showCancelButton: true,
            customClass: {
                confirmButton: 'bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded',
                cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded'
            },
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request
                fetch(`/admin/requests/${requestId}/update-withdrawal`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        withdrawal_status: 'Ready to Pick Up'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                            confirmButton:'bg-teal-600 hover:bg-teal-700'
                            }
                        }).then(() => {
                            // Update the UI
                            const statusElement = document.querySelector(`tr[data-request-id="${requestId}"] .inline-flex`);
                            statusElement.textContent = 'Ready to Pick Up';
                            statusElement.className = `inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${data.status_class}`;
                            
                            // Reload the page to reflect changes
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the status.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    }

    // Update the withdraw form submission
    document.getElementById('withdraw-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const requestId = formData.get('request_id');
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                            confirmButton:'bg-teal-600 hover:bg-teal-700'
                            }
                }).then(() => {
                    closeModal();
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while completing the request.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
    // Withdraw modal functions
    function openWithdrawModal(requestId) {
        document.getElementById('current-request-id').value = requestId;
        document.getElementById('withdraw-form').action = `/admin/requests/${requestId}/update-withdrawal`;
        
        const withdrawnByInput = document.getElementById('withdrawn-by');
        withdrawnByInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
        const now = new Date();

        // Get current UTC time and add 8 hours (UTC+8)
        const phTime = new Date(now.getTime() + (8 * 60 * 60 * 1000));

        // Format to "yyyy-MM-ddTHH:mm" (required for datetime-local input)
        const formattedDateTime = phTime.toISOString().slice(0, 16);
        

    document.getElementById('completed-at').value = formattedDateTime;
        document.getElementById('withdraw-modal').classList.remove('hidden');
    }   

    function closeModal() {
        document.getElementById('withdraw-modal').classList.add('hidden');
    }

    const searchInput = document.getElementById('searchInput');
  const deptSelect = document.getElementById('department');

  searchInput.addEventListener('input', filterRequests);
  deptSelect.addEventListener('change', filterRequests);

  function filterRequests() {
    const selectedDept = deptSelect.value.toLowerCase();
    const searchValue = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
      // Skip the "No request" row
      if (row.id === 'no-withdrawal-row') return;

      const deptCell = row.querySelector('td:nth-child(3)');
      const nameCell = row.querySelector('td:nth-child(2)');

      const matchesDept = selectedDept === 'all' || deptCell.textContent.toLowerCase() === selectedDept;
      const matchesSearch = nameCell.textContent.toLowerCase().includes(searchValue);

      if (matchesDept && matchesSearch) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Show/hide the "no requests" message
    const noResultsRow = document.getElementById('no-withdrawal-row');
    if (visibleCount === 0) {
      noResultsRow.style.display = '';
      if (selectedDept !== 'all') {
        noResultsRow.querySelector('td').textContent = `No requests found in this department.`;
      } else {
        noResultsRow.querySelector('td').textContent = `No requests found.`;
      }
    } else {
      noResultsRow.style.display = 'none';
    }
  }
</script>
@endsection
