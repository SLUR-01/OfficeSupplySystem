@extends('layouts.admin')

@section('content')
    <div class="main-container h-full bg-gray-100 p-3">

        <!-- Request Management Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 md:mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Request Management</h1>
                <p class="text-sm md:text-base text-gray-600 mt-1 mb-3">Review, Approve, and Track Requests</p>

            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-3 md:p-4 rounded-lg bg-green-100 border border-green-300 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="gap-3 rounded-md flex items-start">
            <select id="department"
                class="w-30 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                onchange="filterByDept(this)">
                <option value="all">All Dept</option>
                <option value="cot">COT</option>
                <option value="coed">COED</option>
                <option value="cohtm">COHTM</option>
            </select>

            <div class="relative w-full flex-grow sm:flex-grow-0">
                <input type="text" id="searchInput"
                    class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search request by name...">
                <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="overflow-x-auto px-3">
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-white tracking-wide font-medium">
                        <tr>
                            <th class="px-2 py-3 text-left text-sm text-gray-600">ID</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Name</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Dept.</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Item name</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Variant</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Quantity.</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Signature</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Submitted</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Needed</th>
                            <th class="px-3 py-3 text-left text-sm text-gray-600 ">Purpose</th>
                            <th class="px-3 py-3 text-center text-sm text-gray-600 ">Action</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTbody" class="bg-white divide-y divide-gray-200">
                        @php
                            $filteredRequests = $requests->filter(function ($request) {
                                return $request->admin_status !== 'Approved';
                            });
                        @endphp


                        @foreach ($filteredRequests as $request)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-2 py-4 text-sm text-gray-800 text-left">{{ $request->user_id }}</td>
                                <td class="px-3 py-4 text-sm text-gray-800 capitalize">{{ $request->requester_name }}</td>
                                <td class="px-3 py-4 text-sm text-gray-800 capitalize">{{ $request->department }}</td>
                                <!-- Item Name Column -->
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-dark capitalize">
                                    @if ($request->items && $request->items->count() > 0)
                                        @foreach ($request->items as $item)
                                            <div class="mb-1">{{ $item->item_name }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <!-- Variant Column -->
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                    @if ($request->items && $request->items->count() > 0)
                                        @foreach ($request->items as $item)
                                            <div class="mb-1">{{ $item->variant_value }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <!-- Quantity Column -->
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-800 capitalize">
                                    @if ($request->items && $request->items->count() > 0)
                                        @foreach ($request->items as $item)
                                            <div class="mb-1">{{ $item->quantity }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-800 max-w-xs truncate">
                                    @if ($request->signature)
                                        <img src="{{ $request->signature }}" alt="Signature"
                                            class="h-12 w-auto border rounded">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>


                                <td class="px-3 py-4 whitespace-nowrap capitalize">
                                    <div class="text-sm text-gray-800">
                                        <!-- Date (top line) -->
                                        <div>{{ \Carbon\Carbon::parse($request->datetime)->format('F j, Y') }}</div>
                                        <!-- Time (bottom line, slightly lighter) -->
                                        <div class="text-gray-500 text-xs mt-0.5">
                                            {{ \Carbon\Carbon::parse($request->datetime)->format('g:i A') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-800">
                                    <span class="border-b border-gray-500">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('Y-m-d') }}
                                    </span>
                                    <br>
                                    <span class="text-blue-500 font-semibold">
                                        {{ \Carbon\Carbon::parse($request->date_needed)->format('l') }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-800 max-w-xs truncate capitalize"
                                    title="{{ $request->description }}">
                                    {{ $request->description }}
                                </td>

                                <td class="px-3 py-4 text-sm">
                                    <div class="flex justify-center">
                                        <button
                                            class="approve-btn px-3 py-2 rounded-md text-white bg-teal-600 hover:bg-teal-700 transition shadow-sm"
                                            data-id="{{ $request->id }}" title="Approve">
                                            Approve
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tr id="no-requests-row" style="display: none;">
                        <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                            No requests found.
                        </td>
                    </tr>
                </table>

                <!-- Confirm Approval Modal -->
                <div id="confirmApprovalModal"
                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-auto p-6 m-4">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Confirm Approval</h3>
                        <p class="text-gray-700 mb-6">Are you sure you want to approve this request?</p>
                        <div class="flex justify-end space-x-2">
                            <button id="cancelApproval"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>
                            <form id="approveForm">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded-md transition">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const approveButtons = document.querySelectorAll('.approve-btn');
            const modal = document.getElementById('confirmApprovalModal');
            const cancelBtn = document.getElementById('cancelApproval');
            const approveForm = document.getElementById('approveForm');
            let selectedId = null;

            approveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectedId = this.getAttribute('data-id');
                    modal.classList.remove('hidden');
                });
            });

            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                selectedId = null;
            });

            approveForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!selectedId) return;

                fetch(`/admin/requests/${selectedId}/approve`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(async response => {
                        modal.classList.add('hidden');

                        if (!response.ok) {
                            const error = await response.json();
                            throw new Error(error.error || 'Approval failed.');
                        }

                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: data.message || 'Request Approved Successfully!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message,
                        });
                    });
            });
        });

        const searchInput = document.getElementById('searchInput');
        const deptSelect = document.getElementById('department');

        searchInput.addEventListener('input', filterRequests);
        deptSelect.addEventListener('change', filterRequests);

        function filterRequests() {
            const selectedDept = deptSelect.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('requestsTbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                // Skip the "No request" row
                if (row.id === 'no-requests-row') return;

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
            const noResultsRow = document.getElementById('no-requests-row');
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



        //Approcal steps function
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



        // Open the modal and save the form ID for later submission
        function openDeleteModal(formId) {
            currentFormId = `delete-form-${formId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        // Close the modal
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            currentFormId = null;
        }

        // Listen for Cancel click
        document.getElementById('cancel-btn').addEventListener('click', function() {
            closeDeleteModal();
        });

        // Listen for Confirm click
        document.getElementById('confirm-btn').addEventListener('click', function() {
            if (currentFormId) {
                document.getElementById(currentFormId).submit();
            }
        });

        // Optional: close modal if clicking outside of the modal content
        document.getElementById('delete-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
