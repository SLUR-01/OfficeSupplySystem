@extends('layouts.user')

@section('content')

<div class="h-full bg-gray-100 p-3 overflow-y-auto">

  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-3">
    <div>
      <h1 class="text-3xl font-extrabold text-dark">Request Supply</h1>
      <p class="text-base text-dark">Request Details &amp; Submission</p>
    </div>
  </div>

  <!-- Request Form -->
  <div id="request-form-container" class="w-full  p-6 bg-white shadow rounded-md overflow-x-auto">

    <div>
      <label class="text-lg  font-extrabold text-dark">Request form</label>
    </div>   


    <form action="{{ route('user.request.store') }}" method="POST" id="editRequestForm">
      <fieldset class="space-y-6">
          @csrf
          <!-- Hidden Inputs -->
          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          <input type="hidden" name="requester_name" value="{{ Auth::user()->name }}">
          <input type="hidden" name="department" value="{{ Auth::user()->department }}">

          <!-- Common Form Fields -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <!-- Item Name -->
              <div>
                  <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                  <select name="item_name" id="item_name" onchange="updateStockDetails(this)"
                          class="block w-full rounded-md cursor-pointer border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <option value="" disabled selected>Select an item</option>
                      @foreach($stocks as $stock)
                      @php
                          $isOutOfStock = $stock->stock_quantity <= 0;
                          $isLowStock = $stock->stock_quantity > 0 && $stock->stock_quantity <= 10;
                          $variantDisplay = $stock->variant_value ? " ({$stock->variant_value})" : "";
                          $stockStatus = $isOutOfStock ? ' (Out of stock)' : ($isLowStock ? ' (Low stock)' : '');
                      @endphp
                      <option value="{{ $stock->id }}" 
                              {{ $isOutOfStock ? 'disabled' : '' }}
                              class="{{ $isLowStock ? 'text-yellow-600' : '' }} {{ $isOutOfStock ? 'text-red-600' : '' }}"
                              data-item-name="{{ $stock->item_name }}"
                              data-variant-value="{{ $stock->variant_value ?? '' }}"
                              data-variant="{{ $stock->variant_value }}"
                              data-current-stock="{{ $stock->stock_quantity }}">
                          {{ $stock->item_name }}{{ $variantDisplay }}{{ $stockStatus }}
                      </option>
                      @endforeach
                  </select>
                  <input type="hidden" name="item_name" id="itemName">
                  <input type="hidden" name="variant_value" id="variantValue">
              </div>
          
              <!-- Quantity -->
              <div>
                  <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                  <input type="number" id="quantity" name="quantity" required min="1"
                          class="block w-full rounded-md cursor-pointer border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                          oninput="validateQuantity(this)">
                  <div id="quantityError" class="text-red-500 text-xs mt-1 hidden">Quantity must not exceed available stock of <span id="maxStock"></span></div>
              </div>

              <!-- Date & Time -->
              <div>
                  <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">Date &amp; Time</label>
                  <input type="datetime-local" id="datetime" name="datetime" required
                          class="block w-full rounded-md cursor-pointer border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              
              <!-- Date Needed -->
              <div>
                  <label for="date_needed" class="block text-sm font-medium text-gray-700 mb-1">Date Needed</label>
                  <input type="date" id="date_needed" name="date_needed" required
                          class="block w-full rounded-md cursor-pointer border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
          </div>

          <!-- Signature & Description -->
          <div>
              <div class="flex flex-col md:flex-row gap-4">
                  <!-- Signature Section -->
                  <div class="flex-1">
                      <label for="signature" class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                      <div class="flex items-center border border-gray-300 rounded-md bg-gray-100 p-2 h-[200px]">
                          <canvas id="signatureCanvas" class="w-full h-full bg-white rounded-md cursor-pointer"></canvas>
                         
                      </div>
                      <div class="flex justify-end items-center ">
                        <button type="button" id="clearSignature" class="px-2 py-1 text-[red] rounded-md bg-[white]">
                            <i class="fas fa-trash mr-2"></i>Clear
                        </button>
                        <button type="button" id="loadSignature" class="px-2 py-1 text-[blue] bg-[white] rounded-md">
                            <i class="fas fa-save mr-2"></i>Paste
                        </button>
                    </div>
                      <input type="hidden" name="signature" id="signatureInput">
                  </div>

                  <!-- Description Section -->
                  <div class="flex-1">
                      <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                      <div class="flex items-center border rounded-md bg-gray-100 p-2 h-[200px]">
                          <textarea id="description" name="description" placeholder="Provide additional details..." class="w-full h-full bg-transparent border-0 cursor-pointer outline-none resize-none"></textarea>
                      </div>
                  </div>
              </div>
          </div>
      </fieldset>

      <!-- Confirmation Modal -->
      <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
          <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Confirm Submission</h2>
              <p class="text-gray-600 mb-6">Are you sure you want to submit this request?</p>
              <div class="flex justify-end space-x-4">
                  <button type="button" class="py-2 px-4 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:outline-none"
                          onclick="closeConfirmModal()">
                      Cancel
                  </button>
                  <button type="submit" class="py-2 px-4 bg-teal-600 text-white rounded hover:bg-teal-500 focus:outline-none"
                          onclick="submitForm()">
                      Submit
                  </button>
              </div>
          </div>
      </div>
    </form>

    <!-- Submit Button -->
    
    <div class="pt-3">

      <button class="inline-flex justify-center py-2 px-4  shadow-sm text-base font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
      onclick="openConfirmModal()" 
      id="submitButton" 
      >
      Submit
      </button>


    </div>
    
  </div>

</div>


    <script>
   function updateStockDetails(select) {
    const selectedOption = select.options[select.selectedIndex];
    const stockId = selectedOption.value;
    const currentStock = selectedOption.getAttribute('data-current-stock');
    
    // Update hidden fields
    document.getElementById('itemName').value = selectedOption.getAttribute('data-item-name');
    document.getElementById('variantValue').value = selectedOption.getAttribute('data-variant-value') || '';
    
    // Set max attribute on quantity input
    const quantityInput = document.getElementById('quantity');
    quantityInput.max = currentStock;
    quantityInput.value = ''; // Clear previous value when changing item
    
    // Update the max stock display for error message
    document.getElementById('maxStock').textContent = currentStock;
}

function validateQuantity(input) {
    const maxQuantity = parseInt(input.max);
    const enteredQuantity = parseInt(input.value) || 0;
    const quantityError = document.getElementById('quantityError');
    
    if (enteredQuantity > maxQuantity) {
        quantityError.classList.remove('hidden');
        input.setCustomValidity('Quantity exceeds available stock');
    } else {
        quantityError.classList.add('hidden');
        input.setCustomValidity('');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    // Form validation and submission
    const form = document.getElementById('editRequestForm');
    const submitButton = document.getElementById('submitButton');
    let isSubmitting = false; // Flag to track form submission state
    
    function validateForm() {
        // Required fields
        const itemName = document.getElementById('item_name').value;
        const quantity = document.getElementById('quantity').value;
        const datetime = document.getElementById('datetime').value;
        const dateNeeded = document.getElementById('date_needed').value;
        
        // Check if signature exists
        const signatureData = document.getElementById('signatureInput').value;
        
        // Check if quantity exceeds available stock
        const quantityInput = document.getElementById('quantity');
        const maxQuantity = parseInt(quantityInput.max);
        const enteredQuantity = parseInt(quantity) || 0;
        
        if (enteredQuantity > maxQuantity) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                text: `Quantity cannot exceed available stock of ${maxQuantity}`,
            });
            return false;
        }
        
        return itemName && quantity && datetime && dateNeeded && signatureData;
    }
    
    function openConfirmModal() {
        if (isSubmitting) return; // Prevent opening if already submitting
        
        if (!validateForm()) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Form',
                text: 'Please fill out all required fields before submitting.',
            });
            return;
        }
        
        document.getElementById('confirmModal').classList.remove('hidden');
    }
    
    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
    
    function submitForm() {
        if (isSubmitting) return; // Prevent multiple submissions
        
        if (validateForm()) {
            isSubmitting = true;
            
            // Disable the submit button to prevent multiple clicks
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Hide the modal immediately
            closeConfirmModal();
            
            // Submit the form
            form.submit();
        }
    }
    
    // Make functions global for onclick attributes
    window.openConfirmModal = openConfirmModal;
    window.closeConfirmModal = closeConfirmModal;
    window.submitForm = submitForm;
    window.validateQuantity = validateQuantity;
    window.updateStockDetails = updateStockDetails;
    
    // Add event listener for form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Form',
                text: 'Please fill out all required fields before submitting.',
            });
        }
    });
    
    // Handle successful form submission from server response
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true,
            willClose: () => {
                window.location.reload();
            }
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            willClose: () => {
                // Re-enable the submit button if there was an error
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                isSubmitting = false;
            }
        });
    @endif


  // Signature Drawing and Buttons
const canvas = document.getElementById('signatureCanvas');
const ctx = canvas.getContext('2d');
const clearBtn = document.getElementById('clearSignature');
const loadBtn = document.getElementById('loadSignature');
const signatureInput = document.getElementById('signatureInput');

// Set canvas dimensions with responsive sizing
function resizeCanvas() {
    const container = canvas.parentElement;
    canvas.width = Math.min(400, container.clientWidth - 40); // Max 400px but responsive to container
    canvas.height = 200;
    // Redraw signature if it exists when resizing
    if (signatureInput.value) {
        const img = new Image();
        img.onload = () => {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = signatureInput.value;
    }
}

// Initialize canvas size
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

ctx.lineWidth = 2;
ctx.strokeStyle = 'black';

// Drawing functionality
let drawing = false;

// Get correct position accounting for canvas scaling
function getCanvasPosition(clientX, clientY) {
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    return {
        x: (clientX - rect.left) * scaleX,
        y: (clientY - rect.top) * scaleY
    };
}

// Mouse events
canvas.addEventListener('mousedown', (e) => {
    const pos = getCanvasPosition(e.clientX, e.clientY);
    drawing = true;
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener('mousemove', (e) => {
    if (drawing) {
        const pos = getCanvasPosition(e.clientX, e.clientY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }
});

canvas.addEventListener('mouseup', () => {
    drawing = false;
    // Update hidden input after drawing
    signatureInput.value = canvas.toDataURL('image/png');
});

canvas.addEventListener('mouseout', () => {
    drawing = false;
});

// Touch events for mobile devices
canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    const pos = getCanvasPosition(touch.clientX, touch.clientY);
    drawing = true;
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    if (drawing) {
        const touch = e.touches[0];
        const pos = getCanvasPosition(touch.clientX, touch.clientY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }
});

canvas.addEventListener('touchend', () => {
    drawing = false;
    signatureInput.value = canvas.toDataURL('image/png');
});

// Clear Signature Button: clear canvas and hidden input
clearBtn.addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    signatureInput.value = '';
});

// Load Signature Button: load saved signature from user data
loadBtn.addEventListener('click', () => {
    const savedSignature = "{{ Auth::user()->signature }}";
    if (savedSignature) {
        const img = new Image();
        img.onload = () => {
            // Clear canvas first, then draw loaded image
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            // Update hidden input with loaded image data
            signatureInput.value = savedSignature;
        };
        img.src = savedSignature;
    } else {
        Swal.fire({
            icon: 'info',
            title: 'No Signature Found',
            text: 'No saved signature found in your profile.',
        });
    }
});
});

    </script>






      {{-- <!-- Your content -->

    
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Request Form</h1>
      </div>
      <!-- Form -->
      <form action="{{ route('user.request.store') }}" method="POST" class="space-y-6">
        <fieldset class="space-y-6">
          @csrf
          <!-- Hidden Inputs -->
          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          <input type="hidden" name="requester_name" value="{{ Auth::user()->name }}">
    
          <!-- Form Fields Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Department -->
            <div>
              <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
              <select id="department" name="department" required
                      class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Select your department</option>
                <option value="COED">College of Education</option>
                <option value="COT">College of Technology</option>
                <option value="COHTM">College of Hospitality and Tourism Management</option>
              </select>
            </div>
    
            <!-- Item Name -->
            <div>
              <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
              <select id="item_name" name="item_name" required
                      class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Select an item</option>
                <!-- Loop through stock data -->
                @foreach ($stocks as $stock)
                  @php
                    $isLowStock = $stock->stock_quantity <= 10;
                    $isOutOfStock = $stock->stock_quantity == 0;
                  @endphp
                  <option value="{{ $stock->item_name }}" 
                          {{ $isOutOfStock ? 'disabled' : '' }}
                          data-stock="{{ $stock->stock_quantity }}"
                          class="{{ $isLowStock ? 'text-yellow-600' : '' }}">
                    {{ $stock->item_name }}
                    @if ($isLowStock)
                      (Low stocks)
                    @endif
                  </option>
                @endforeach
              </select>
            </div>
    
            <!-- Quantity -->
            <div>
              <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
              <input type="number" id="quantity" name="quantity" required min="1"
                      class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
    
            <!-- Date & Time -->
            <div>
              <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">Date &amp; Time</label>
              <input type="datetime-local" id="datetime" name="datetime" required
                      class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
          </div>
    
          <!-- Signature -->
          <div>
              <div class="flex flex-col md:flex-row gap-4">
                  <!-- Signature Section -->
                  <div class="flex-1">
                    <label for="signature" class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                    <div class="flex items-center border border-gray-300 rounded-md bg-gray-50 p-2 h-[200px]">
                      <canvas id="signatureCanvas" class="w-full h-full bg-white rounded-md"></canvas>
                      <div class="flex flex-col space-y-2 ml-2">
                        <button type="button" id="clearSignature" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md">
                          <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" id="loadSignature" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-md">
                          <i class="fas fa-save"></i>
                        </button>
                      </div>
                    </div>
                    <input type="hidden" name="signature" id="signatureInput">
                  </div>
                
                  <!-- Description Section -->
                  <div class="flex-1">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <div class="flex items-center border  rounded-md bg-gray-100 p-2 h-[200px]">
                      <textarea id="description" name="description" placeholder="Provide additional details..."
                      class="w-full h-full bg-transparent border-0 outline-none resize-none"></textarea>
            
                    </div>
                  </div>
                </div>
                
    
          <!-- Hidden Signature Input (if needed) -->
          <input type="hidden" name="signature" id="saveSignature">
        </fieldset>
    
        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-30 inline-flex justify-center py-2 px-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-[#0A2540] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Submit Request
          </button>
        </div>
      </form>
    </div>
                       --}}
        
@endsection
