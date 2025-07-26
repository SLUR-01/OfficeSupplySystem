

@if (session('success'))
<div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md">
    {{ session('error') }}
</div>
@endif

<div class="gap-3 rounded-md flex items-start mb-3">
    <select id="approvedDepartment" class="w-30 border cursor-pointer border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" onchange="filterByDept(this)">
        <option value="all">All Dept</option>
        <option value="COT">COT</option>
        <option value="COED">COED</option>
        <option value="COHTM">COHTM</option>
    </select>

    <div class="relative w-full flex-grow sm:flex-grow-0">
        <input type="text" id="approvedSearchInput"
            class="w-full px-4 py-2 cursor-pointer border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Search returns by requester name...">
        <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
        </svg>
    </div>
</div>




{{-- Returns Pickups content --}}
<div class="bg-white shadow rounded-lg">
    
    <div class="px-3 overflow-y-hidden">
        <table id="approved-table" class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-white tracking-wide font-medium">
                <tr>
                    <th class="px-2 py-3 text-left text-sm text-gray-600 uppercase">Return Id</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Name</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Dept</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty Returned</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Returned</th>
                    <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Condition</th>
                    <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Status</th>
                    <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody id="approvedTbody" class="divide-y divide-gray-200">
                @foreach($approvedReturns as $return)
                    @if($return->return_status === 'approved' && $return->replacement_status !== 'completed')
                        <tr class="hover:bg-gray-50 transition duration-200" id="row-{{ $return->id }}">
                            <td class="px-2 py-4 whitespace-nowrap text-sm font-semibold text-dark uppercase">
                                Return#: {{ $return->id }}
                            </td>                                   
                            <td class="px-3 py-4 text-gray-800 text-sm capitalize">{{ $return->requester_name }}</td>
                            <td class="px-3 py-4 text-gray-800 text-sm capitalize">{{ $return->department}}</td>
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
        
                            <td class="px-3 py-4 text-gray-800 text-sm capitalize" id="received-{{ $return->id }}">
                                {{ $return->quantity}}
                            </td>
                            <td class="px-3 py-4 text-gray-800 text-sm capitalize">
                                <div class="flex flex-col">
                                    <span>{{ \Carbon\Carbon::parse($return->return_date)->format('F j, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-center whitespace-nowrap text-sm">
                                @switch($return->condition)
                                    @case('defective')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Defective</span>
                                        @break
                                    @case('damaged')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Damaged</span>
                                        @break
                                    @case('wrong_item')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Wrong Item</span>
                                    @break
                                    @default
                                @endswitch
                            </td>
                            <td class="px-3 py-4 text-center whitespace-nowrap text-sm" id="replacement-status-{{ $return->id }}">
                                @if($return->replacement_status)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                                        @if($return->replacement_status === 'pending') 
                                            bg-yellow-100 text-yellow-800
                                        @elseif($return->replacement_status === 'completed')
                                            bg-green-100 text-green-800
                                        @endif">
                                        {{ $return->replacement_status }}
                                    </span>
                    
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm">
                                <button onclick="openReceiveModal('{{ $return->id }}', '{{ $return->item_name }}' , '{{ $return->variant_value }}', '{{ $return->quantity }}')" 
                                        class="px-3 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Update
                                </button>
                            </td>
                        </tr>
                  
                    @endif
                @endforeach
            </tbody>
            <tr id="no-approved-row" style="display: none;">
                <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                    No requests found.
                </td>
            </tr>
        </table>

        
        <!-- Receive Modal -->
        <div id="receiveModal"  class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
            <div class="relative  mx-auto p-3 border w-96 shadow-lg rounded-md bg-white">
                <form id="receiveForm" method="POST" action="{{ route('admin.completedReturn.update') }}">
                    @csrf
                    <div class="mt-2">
                        <h3 class="text-lg font-semibold text-gray-900">Received Item</h3>
                            <p class="text-md text-gray-800">
                                Item:
                                <span id="modalItemName" class="font-semibold"></span>
                            </p>
                            <p class="text-start">
                                Variant:
                                <span id="modalItemVariant" class="font-semibold capitalize "></span>
                            </p>


                            <p class="text-md text-gray-800 mb-4">Quantity Returned: <span id="modalQuantityReturned" class="font-semibold"></span></p>
                            
                            <label for="quantity_received" class="block text-md font-semibold text-gray-700 mb-1">Quantity Received:</label>
                            <input type="number" id="quantity_received" name="quantity_received" 
                                class="border rounded p-2 w-full" min="0" value="0" required>
                            <input type="hidden" id="return_id" name="return_id">
                            <p id="errorMessage" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                        <div class="flex justify-end items-center py-2">
                            <button type="submit" id="confirmReceive" class="px-4 py-2 bg-teal-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Confirm
                            </button>
                            <button type="button" id="cancelReceive" class="ml-2 px-4 py-2 bg-gray-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
 
const approvedSearchInput = document.getElementById('approvedSearchInput');
const approvedDepartment = document.getElementById('approvedDepartment');

approvedSearchInput.addEventListener('input', filterRequests);
approvedDepartment.addEventListener('change', filterRequests);

function filterRequests() {
  const selectedDept = approvedDepartment.value.toLowerCase();
  const searchValue = approvedSearchInput.value.toLowerCase();
  const rows = document.querySelectorAll('#approvedTbody tr');
  let visibleCount = 0;

  rows.forEach(row => {
    if (row.id === 'no-approved-row') return;

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

  const noResultsRow = document.getElementById('no-approved-row');
  if (noResultsRow) {
    noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
    if (visibleCount === 0) {
      noResultsRow.querySelector('td').textContent =
        selectedDept !== 'all'
          ? `No requests found in this department.`
          : `No requests found.`;
    }
  }
}
       // Receive Modal functionality
const receiveModal = document.getElementById('receiveModal');
const receiveForm = document.getElementById('receiveForm');
const cancelReceiveBtn = document.getElementById('cancelReceive');
const quantityInput = document.getElementById('quantity_received');
const errorMessage = document.getElementById('errorMessage');

// Define globally so it's callable from buttons
window.openReceiveModal = function(returnId, itemName, itemVariant, quantityReturned) {
    document.getElementById('modalItemName').textContent = itemName;
    document.getElementById('modalItemVariant').textContent = itemVariant;

    document.getElementById('modalQuantityReturned').textContent = quantityReturned;
    document.getElementById('return_id').value = returnId;
    quantityInput.value = quantityReturned;
    quantityInput.max = quantityReturned;
    errorMessage.classList.add('hidden');
    receiveModal.classList.remove('hidden');
};

function closeReceiveModal() {
    receiveModal.classList.add('hidden');
}

if (cancelReceiveBtn) {
    cancelReceiveBtn.addEventListener('click', closeReceiveModal);
}

if (receiveForm) {
    receiveForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const returnId = document.getElementById('return_id').value;
        const quantityReceived = parseInt(quantityInput.value);
        const quantityReturned = parseInt(document.getElementById('modalQuantityReturned').textContent);
        const submitButton = document.getElementById('confirmReceive');
        const formData = new FormData(this);

        if (isNaN(quantityReceived)) {
            errorMessage.textContent = 'Please enter a valid quantity';
            errorMessage.classList.remove('hidden');
            return;
        }

        if (quantityReceived > quantityReturned) {
            errorMessage.textContent = 'Cannot receive more than the returned quantity';
            errorMessage.classList.remove('hidden');
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Failed to process return');
            }

            // Show success message with timer
            await Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Item received successfully',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });

            // Close the modal
            closeReceiveModal();

            // Reload the page after the alert closes
            location.reload();

        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'An error occurred while receiving the item'
            });
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Confirm';
        }
    });
}
 
        
    </script>
    