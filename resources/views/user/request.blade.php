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
        <div id="request-form-container" class="w-full p-6 bg-white shadow rounded-md">

            <div class="mb-4">
                <label class="text-lg font-extrabold text-dark">Request Form</label>
            </div>

            <form action="{{ route('user.request.store') }}" method="POST" id="editRequestForm">
                <fieldset class="space-y-6">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="requester_name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="department" value="{{ Auth::user()->department }}">

                    <!-- Selected Items -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium text-gray-700">Selected Items</label>
                            <button type="button" onclick="openAddItemModal()"
                                class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-500">
                                + Add Item
                            </button>
                        </div>

                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-3 py-2 text-left">Item</th>
                                    <th class="border px-3 py-2 text-left">Variant</th>
                                    <th class="border px-3 py-2 text-left">Quantity</th>
                                    <th class="border px-3 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedItemsBody">
                                <!-- Added items will appear here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Other form fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                            <input type="datetime-local" name="datetime" required
                                class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="date_needed" class="block text-sm font-medium text-gray-700 mb-1">Date
                                Needed</label>
                            <input type="date" name="date_needed" required
                                class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Signature & Description -->
                    <div>
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- Signature Section -->
                            <div class="flex-1">
                                <label for="signature"
                                    class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                                <div class="flex items-center border border-gray-300 rounded-md bg-gray-100 p-2 h-[200px]">
                                    <canvas id="signatureCanvas"
                                        class="w-full h-full bg-white rounded-md cursor-pointer"></canvas>

                                </div>
                                <div class="flex justify-end items-center ">
                                    <button type="button" id="clearSignature"
                                        class="px-2 py-1 text-[red] rounded-md bg-[white]">
                                        <i class="fas fa-trash mr-2"></i>Clear
                                    </button>
                                    <button type="button" id="loadSignature"
                                        class="px-2 py-1 text-[blue] bg-[white] rounded-md">
                                        <i class="fas fa-save mr-2"></i>Paste
                                    </button>
                                </div>
                                <input type="hidden" name="signature" id="signatureInput">
                            </div>

                            <!-- Description Section -->
                            <div class="flex-1">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <div class="flex items-center border rounded-md bg-gray-100 p-2 h-[200px]">
                                    <textarea id="description" name="description" placeholder="Provide additional details..."
                                        class="w-full h-full bg-transparent border-0 cursor-pointer outline-none resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div id="confirmModal"
                    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Confirm Submission</h2>
                        <p class="text-gray-600 mb-6">Are you sure you want to submit this request?</p>
                        <div class="flex justify-end space-x-4">
                            <button type="button"
                                class="py-2 px-4 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:outline-none"
                                onclick="closeConfirmModal()">
                                Cancel
                            </button>
                            <button type="submit"
                                class="py-2 px-4 bg-teal-600 text-white rounded hover:bg-teal-500 focus:outline-none"
                                onclick="submitForm()">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="pt-3">

                <button
                    class="inline-flex justify-center py-2 px-4  shadow-sm text-base font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onclick="openConfirmModal()" id="submitButton">
                    Submit
                </button>


            </div>
        </div>

        <!-- Add Item Modal -->
        <div id="addItemModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Add Item</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                    <select id="modalItemSelect"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select an item</option>
                        @foreach ($stocks as $stock)
                            @php
                                $isOutOfStock = $stock->stock_quantity <= 0;
                                $isLowStock = $stock->stock_quantity > 0 && $stock->stock_quantity <= 10;
                                $variantDisplay = $stock->variant_value ? " ({$stock->variant_value})" : '';
                                $stockStatus = $isOutOfStock ? ' (Out of stock)' : ($isLowStock ? ' (Low stock)' : '');
                            @endphp
                            <option value="{{ $stock->id }}" {{ $isOutOfStock ? 'disabled' : '' }}
                                data-item-name="{{ $stock->item_name }}"
                                data-variant-value="{{ $stock->variant_value ?? '' }}"
                                data-current-stock="{{ $stock->stock_quantity }}">
                                {{ $stock->item_name }}{{ $variantDisplay }}{{ $stockStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" id="modalItemQuantity" min="1" value="1"
                        class="block w-full rounded-md border border-gray-300 bg-gray-100 py-2 px-3 shadow-sm focus:ring-2 focus:ring-blue-500">
                    <p id="modalQuantityError" class="text-red-500 text-xs mt-1 hidden">Quantity exceeds available stock
                    </p>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeAddItemModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="button" onclick="confirmAddItem()"
                        class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-500">Add Item</button>
                </div>
            </div>
        </div>



    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editRequestForm');
            const submitButton = document.getElementById('submitButton');
            let isSubmitting = false;

            // ---------------- Modal Functions ----------------
            window.openConfirmModal = function() {
                if (isSubmitting) return;
                if (!validateForm()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Incomplete Form',
                        text: 'Please fill out all required fields.'
                    });
                    return;
                }
                document.getElementById('confirmModal').classList.remove('hidden');
            }

            window.closeConfirmModal = function() {
                document.getElementById('confirmModal').classList.add('hidden');
            }

            window.submitForm = function() {
                if (isSubmitting) return;
                if (validateForm()) {
                    isSubmitting = true;
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    closeConfirmModal();
                    form.submit();
                }
            }

            function validateForm() {
                const datetime = form.querySelector('input[name="datetime"]').value;
                const dateNeeded = form.querySelector('input[name="date_needed"]').value;
                const signatureData = document.getElementById('signatureInput').value;
                if (!datetime || !dateNeeded || !signatureData || selectedItems.length === 0) return false;
                return true;
            }

            // ---------------- Selected Items Handling ----------------
            let selectedItems = [];

            window.openAddItemModal = function() {
                document.getElementById('addItemModal').classList.remove('hidden');
            }

            window.closeAddItemModal = function() {
                document.getElementById('addItemModal').classList.add('hidden');
                document.getElementById('modalQuantityError').classList.add('hidden');
                document.getElementById('modalItemSelect').value = '';
                document.getElementById('modalItemQuantity').value = 1;
            }

            window.confirmAddItem = function() {
                const select = document.getElementById('modalItemSelect');
                const quantityInput = document.getElementById('modalItemQuantity');
                const error = document.getElementById('modalQuantityError');

                if (!select.value) return alert('Please select an item.');

                const option = select.options[select.selectedIndex];
                const stockId = option.value;
                const itemName = option.dataset.itemName;
                const variant = option.dataset.variantValue || '';
                const maxStock = parseInt(option.dataset.currentStock);
                const quantity = parseInt(quantityInput.value);

                if (quantity > maxStock) {
                    error.classList.remove('hidden');
                    return;
                }
                error.classList.add('hidden');

                // Prevent duplicates
                if (selectedItems.find(i => i.stock_id == stockId)) {
                    alert('Item already added.');
                    return;
                }

                selectedItems.push({
                    stock_id: stockId,
                    item_name: itemName,
                    variant,
                    quantity
                });
                renderSelectedItems();
                closeAddItemModal();
            }

            window.removeItem = function(stockId) {
                selectedItems = selectedItems.filter(i => i.stock_id != stockId);
                renderSelectedItems();
            }

            function renderSelectedItems() {
                const tbody = document.getElementById('selectedItemsBody');
                tbody.innerHTML = '';

                selectedItems.forEach((item, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
            <td class="border px-3 py-2">
                ${item.item_name}
                <input type="hidden" name="items[${index}][item_name]" value="${item.item_name}">
                <input type="hidden" name="items[${index}][stock_id]" value="${item.stock_id}">
                <input type="hidden" name="items[${index}][variant_value]" value="${item.variant}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            </td>
            <td class="border px-3 py-2">${item.variant}</td>
            <td class="border px-3 py-2">${item.quantity}</td>
            <td class="border px-3 py-2">
                <button type="button" onclick="removeItem(${item.stock_id})" class="text-red-600 hover:underline">Remove</button>
            </td>
        `;
                    tbody.appendChild(tr);
                });
            }

            // ---------------- Signature Canvas ----------------
            const canvas = document.getElementById('signatureCanvas');
            const ctx = canvas.getContext('2d');
            const clearBtn = document.getElementById('clearSignature');
            const loadBtn = document.getElementById('loadSignature');
            const signatureInput = document.getElementById('signatureInput');
            let drawing = false;

            function resizeCanvas() {
                const container = canvas.parentElement;
                canvas.width = container.clientWidth - 20;
                canvas.height = 200;
                if (signatureInput.value) {
                    const img = new Image();
                    img.onload = () => ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    img.src = signatureInput.value;
                }
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            ctx.lineWidth = 2;
            ctx.strokeStyle = 'black';

            function getPos(clientX, clientY) {
                const rect = canvas.getBoundingClientRect();
                return {
                    x: (clientX - rect.left) * (canvas.width / rect.width),
                    y: (clientY - rect.top) * (canvas.height / rect.height)
                };
            }

            // Mouse events
            canvas.addEventListener('mousedown', e => {
                drawing = true;
                const pos = getPos(e.clientX, e.clientY);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });
            canvas.addEventListener('mousemove', e => {
                if (drawing) {
                    const pos = getPos(e.clientX, e.clientY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
            });
            canvas.addEventListener('mouseup', () => {
                drawing = false;
                signatureInput.value = canvas.toDataURL('image/png');
            });
            canvas.addEventListener('mouseout', () => {
                drawing = false;
            });

            // Touch events
            canvas.addEventListener('touchstart', e => {
                e.preventDefault();
                drawing = true;
                const pos = getPos(e.touches[0].clientX, e.touches[0].clientY);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });
            canvas.addEventListener('touchmove', e => {
                e.preventDefault();
                if (drawing) {
                    const pos = getPos(e.touches[0].clientX, e.touches[0].clientY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
            });
            canvas.addEventListener('touchend', () => {
                drawing = false;
                signatureInput.value = canvas.toDataURL('image/png');
            });

            clearBtn.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                signatureInput.value = '';
            });

            loadBtn.addEventListener('click', () => {
                const savedSignature = "{{ Auth::user()->signature }}";
                if (savedSignature) {
                    const img = new Image();
                    img.onload = () => {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        signatureInput.value = savedSignature;
                    };
                    img.src = savedSignature;
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Signature Found',
                        text: 'No saved signature found in your profile.'
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
