@extends('layouts.user')

@section('content')


<div class="main-container bg-gray-100 p-[15px] h-100">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 mb-3">
      <div>
          <h1 class="text-[25px] font-extrabold text-dark">Return Management</h1>
          <p class="text-base text-dark">Track &amp; Process Returns</p>
      </div>
  </div>

  @if (session('success'))
  <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md">
      {{ session('success') }}
  </div>
  @endif

  <!-- Header with Search Input -->
  <div class="py-4 flex justify-between items-start  gap-4">
      {{-- <label class="block text-lg font-bold text-gray-700">Select Return</label> --}}
      <div class="relative flex-1 sm:max-w-xs">
          <input type="text" id="searchInput"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search request...">
          <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
          </svg>
      </div>
      <button id="processReturnBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
        Process Selected Return
      </button>
      <!-- Process Return Button -->
  
  </div>

  <!-- Return Requests Table -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
              <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                  {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Returned</th> --}}
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
              </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200" id="requestsTableBody">
              @foreach($requests as $request)
              <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $request->id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->item_name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->quantity }}</td>
                  {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->datetime }}</td> --}}
                  <td class="px-6 py-4 whitespace-nowrap">
              
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                      <input type="radio" name="selectedRequest" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                             value="{{ $request->id }}" 
                             data-item-name="{{ $request->item_name }}"
                             data-quantity="{{ $request->quantity }}"
                            >  
                             {{-- data-date="{{ $request->datetime }}" --}}
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
      
        <!-- Return Modal -->
        <div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[80vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Process Return</h3>
                
                <!-- Item Details -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Item Details</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Item Name</p>
                            <p id="modalItemName" class="font-medium"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Quantity</p>
                            <p id="modalQuantity" class="font-medium"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Request Date</p>
                            <p id="modalRequestDate" class="font-medium"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Request ID</p>
                            <p id="modalRequestId" class="font-medium"></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.return.store') }}" method="POST" id="returnForm">
                    @csrf
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="request_id" id="requestIdInput">
                    <input type="hidden" id="userId" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" id="requesterName" name="requester_name" value="{{ Auth::user()->name }}">
                    <input type="hidden" id="department" name="department" value="{{ Auth::user()->department }}">
                    <input type="hidden" id="itemName" name="item_name">
                
                    <!-- Condition -->
                    <div class="mb-4">
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                        <select id="condition" name="condition" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select condition</option>
                            <option value="defective">Defective</option>
                            <option value="damaged">Damaged</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                
                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity to Return</label>
                        <input type="number" id="quantity" name="quantity" min="1" required
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md">
                    </div>
                
                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                    </div>
                
                    <!-- Return Date -->
                    <div class="mb-4">
                        <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
                        <input type="date" id="return_date" name="return_date" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    </div>
                
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelReturnBtn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
  </div>

</div>

</div>

<!-- Include Signature Pad library -->

<script>
   // Enable/disable process return button based on selection
const radioButtons = document.querySelectorAll('input[name="selectedRequest"]');
const processReturnBtn = document.getElementById('processReturnBtn');

document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default return date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('return_date').value = today;
});

// Form submission handler
document.getElementById('returnForm').addEventListener('submit', function(e) {
    // Validate quantity
    const returnQuantity = parseInt(document.getElementById('quantity').value);
    const maxQuantity = parseInt(document.getElementById('quantity').max);
    
    if (isNaN(returnQuantity) || returnQuantity < 1 || returnQuantity > maxQuantity) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Invalid Quantity',
            text: `Please enter a valid quantity between 1 and ${maxQuantity}`,
        });
        return;
    }
    
    // Get the return date and compare with current date
    const returnDate = new Date(document.getElementById('return_date').value);
    const currentDate = new Date();
    const hoursLate = (currentDate - returnDate) / (1000 * 60 * 60);
    
    if (hoursLate > 24) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Return Submission Failed',
            text: 'Cannot submit return because it is more than 24 hours late',
        });
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Processing...';
});

radioButtons.forEach(radio => {
    radio.addEventListener('change', function() {
        processReturnBtn.disabled = !this.checked;
    });
});

// Modal handling
const modal = document.getElementById('returnModal');
const cancelReturnBtn = document.getElementById('cancelReturnBtn');

processReturnBtn.addEventListener('click', function() {
    const selectedRadio = document.querySelector('input[name="selectedRequest"]:checked');
    if (selectedRadio) {
        // Populate modal with data from the selected row
        document.getElementById('modalItemName').textContent = selectedRadio.dataset.itemName;
        document.getElementById('modalQuantity').textContent = selectedRadio.dataset.quantity;
        document.getElementById('modalRequestDate').textContent = selectedRadio.dataset.date;
        document.getElementById('modalRequestId').textContent = selectedRadio.value;
        
        // Set form values
        document.getElementById('requestIdInput').value = selectedRadio.value;
        document.getElementById('userId').value = selectedRadio.dataset.userId;
        document.getElementById('requesterName').value = selectedRadio.dataset.requesterName;
        document.getElementById('department').value = selectedRadio.dataset.department;
        document.getElementById('itemName').value = selectedRadio.dataset.itemName;

        // Set quantity field with max value from request
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = selectedRadio.dataset.quantity;
        quantityInput.max = selectedRadio.dataset.quantity;
        
        // Show modal
        modal.classList.remove('hidden');
    }
});

cancelReturnBtn.addEventListener('click', function() {
    modal.classList.add('hidden');
});

// Close modal when clicking outside
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        modal.classList.add('hidden');
    }
});

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#requestsTableBody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection

   
       





   {{-- <!-- Data Table -->
<div class="bg-white shadow rounded-md overflow-hidden mb-[15px] p-6">
  <div class="rounded-md overflow-hidden mb-6">
      <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
              <thead class="text-gray-700 text-sm uppercase font-semibold">
                  <tr>
                      <th class="py-4 text-left">No.</th>
                      <th class="px-6 py-4 text-left">Department</th>
                      <th class="px-6 py-4 text-left">Item Name</th>
                      <th class="px-6 py-4 text-left">Quantity</th>
                      <th class="px-6 py-4 text-left">Date &amp; Time</th>
                      <th class="px-6 py-4 text-left">Action</th>
                  </tr>
              </thead>
              <tbody id="requestTableBody" class="bg-white divide-y divide-gray-200">
                  @foreach($requests as $request)
                  <tr class="hover:bg-gray-50">
                      <td class="py-4 whitespace-nowrap text-gray-700">{{ $request->user_id }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->department }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->item_name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->quantity }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $request->datetime }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">
                          <button onclick="openReturnModal('{{ $request->id }}', '{{ $request->item_name }}', '{{ $request->quantity }}', '{{ $request->datetime }}', '{{ $request->department }}')"
                                  type="button"
                                  class="select-request-btn inline-flex items-center px-3 py-1 text-sm font-medium rounded-md text-white bg-[#0A2540] hover:bg-[#0A2560] transition">
                              Select
                          </button>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Return Modal -->
<div id="returnModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
  <div class="relative top-20 mx-auto p-5 border md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
      <!-- Modal Header -->
      <div class="flex justify-between items-center pb-3">
          <h3 class="text-lg font-bold">Process Return</h3>
          <button onclick="closeReturnModal()" class="text-gray-500 hover:text-gray-700">
              <i class="fas fa-times"></i>
          </button>
      </div>
      
      <!-- Modal Body -->
      <div>
          <form action="{{ route('user.return.storeReturn') }}" method="POST" id="returnForm">
              @csrf
              <input type="hidden" name="request_id" id="modal_request_id">
              
              <!-- Item Details -->
              <div class="mb-6 bg-gray-50 p-4 rounded-md">
                  <h4 class="text-sm font-medium text-gray-700 mb-3">Item Details</h4>
                  <div class="grid grid-cols-2 gap-4">
                      <div>
                          <p class="text-sm text-gray-500">Department</p>
                          <p id="modal_department" class="font-medium"></p>
                      </div>
                      <div>
                          <p class="text-sm text-gray-500">Item Name</p>
                          <p id="modal_item_name" class="font-medium"></p>
                      </div>
                      <div>
                          <p class="text-sm text-gray-500">Quantity</p>
                          <p id="modal_quantity" class="font-medium"></p>
                      </div>
                      <div>
                          <p class="text-sm text-gray-500">Request Date</p>
                          <p id="modal_request_date" class="font-medium"></p>
                      </div>
                  </div>
              </div>

              <!-- Return Details -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Condition -->
                  <div class="mb-4">
                      <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                      <select id="condition" name="condition" required
                              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                          <option value="" disabled selected>Select condition</option>
                          <option value="defective">Defective</option>
                          <option value="damaged">Damaged</option>
                          <option value="like_new">Like New</option>
                          <option value="other">Other</option>
                      </select>
                  </div>

                  <!-- Return Date -->
                  <div class="mb-4">
                      <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
                      <input type="date" id="return_date" name="return_date" required
                             class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                  </div>
              </div>

              <!-- Signature & Description -->
              <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Signature -->
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                      <div class="mt-1 border-2 border-gray-200 rounded-md p-2 bg-gray-50">
                          <canvas id="signatureCanvas" class="w-full h-32 rounded bg-white"></canvas>
                          <div class="flex justify-end mt-2">
                              <button type="button" id="clearSignature" 
                                      class="text-sm text-red-600 hover:text-red-800">
                                  Clear Signature
                              </button>
                          </div>
                      </div>
                      <input type="hidden" name="signature" id="signatureInput">
                  </div>
                  
                  <!-- Description -->
                  <div>
                      <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                      <textarea id="description" name="description" rows="5" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Provide details about the return (e.g., reason for return, damage description)"></textarea>
                  </div>
              </div>

              <!-- Form Actions -->
              <div class="mt-6 flex justify-end space-x-3">
                  <button type="button" onclick="closeReturnModal()" 
                          class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                      Cancel
                  </button>
                  <button type="submit" 
                          class="px-4 py-2 bg-[#0A2540] text-white rounded-md text-sm font-medium hover:bg-[#0A2560] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                      Submit Return
                  </button>
              </div>
          </form>
      </div>
  </div>
</div> --}}
