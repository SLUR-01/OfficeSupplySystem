@extends('layouts.admin')

@section('content')

<div class="main-container h-100 bg-gray-100  p-3">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-dark">Stocks Management</h1>
            <p class="text-base text-dark mt-1 mb-3">Stocks Overview &amp; Item Search</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 rounded-md items-start">
        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
            <button
                onclick="openAddStockModal()"
                class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>Update Stocks
            </button>
    
            <button
                onclick="openAddNewItemModal()"
                class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </button>
        </div>
        
        <div class="relative w-full sm:w-auto flex-grow">
            <input type="text" id="searchInput"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search item by name...">
            <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z" />
            </svg>
        </div>
    </div>
    
    <!--Manage Request Table -->
    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide font-medium">
                    <tr>
                        <th class="py-3 text-center text-sm text-gray-600 uppercase">Stock ID</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Type</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Value</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Current Stock</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Reorder Point</th>

                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Status</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Defective</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Damaged</th>

                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Last Update</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($stocks as $index => $stock)
                    <tr class="hover:bg-gray-50 transition duration-200" data-item-id="{{ $stock->id }}">
                        <td class="px-2 py-3 text-gray-800 font-medium">{{ $stock->id }}</td>

                        <td class="px-3 py-3 text-gray-800 font-medium">{{ $stock->item_name }}</td>
                        <td class="px-3 py-3 text-gray-800 font-medium">{{ $stock->variant_type }}</td>

                        <td class="px-3 py-3 text-gray-800 font-medium">{{ $stock->variant_value }}</td>

                        <td class="px-3 py-3 text-left text-gray-800 font-semibold stock-quantity">
                                {{ $stock->stock_quantity }}
                            
                        </td>
                           <td class="px-3 py-3 text-left text-gray-800 font-semibold stock-quantity">
                                {{ $stock->reorderpoint }}
                            
                        </td>
                            
                        <td class="px-3 py-3 text-left">
                            @if($stock->stock_quantity == 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                            @elseif($stock->stock_quantity <= $stock->reorderpoint)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-gray-800 font-medium">{{ $stock->defective_count }}</td>
                        <td class="px-3 py-3 text-gray-800 font-medium">{{ $stock->damaged_count }}</td>

                       <td class="px-3 py-3 text-left text-gray-500 text-sm">
                            {{ $stock->updated_at ? \Carbon\Carbon::parse($stock->updated_at)->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
                <tr id="no-requests-row" style="display: none;">
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                    No item found.
                    </td>
                </tr>
            </table>
        </div>
                    
    <div id="add-stock-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
    
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 transform transition-all duration-300 scale-95">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Add Stock Quantity</h2>
                <button onclick="closeAddStockModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="update-stock-form" action="{{ route('admin.update.stock') }}" method="POST">
                @csrf
                
                <!-- Item Name Select -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Item</label>
                    <select id="item_id" name="item_id" required
                            class="block w-full rounded-md cursor-pointer border border-gray-300 bg-white py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="" disabled selected>Select an item</option>
                        @foreach ($stocks as $stock)
                            @php
                                $isLowStock = $stock->stock_quantity <= 10;
                                $isOutOfStock = $stock->stock_quantity == 0;
                            @endphp
                            <option value="{{ $stock->id }}" data-current="{{ $stock->stock_quantity }}"
                                    class="{{ $isLowStock ? 'text-yellow-600' : '' }} {{ $isOutOfStock ? 'text-red-600' : '' }}">
                                {{ $stock->item_name }} 
                                @if($stock->variant_value) 
                                    ({{ $stock->variant_value }})
                                @endif
                                (Current:{{ $stock->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Quantity Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Add</label>
                    <div class="relative">
                        <input type="number" name="stock_quantity" min="1" required
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="Enter quantity to add">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 text-sm">stocks</span>
                        </div>
                    </div>
                    <p id="current-stock-display" class="text-xs text-gray-500 mt-1"></p>
                </div>
            
                <!-- Modal Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAddStockModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                        Cancel
                    </button>
                    
                    <button type="submit"
                            class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Stock</span>
                    </button>
                </div>
            </form>
        </div>

    </div>


    <div id="add-new-item-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Add New Item</h2>
                <button onclick="closeAddNewItemModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="add-new-item-form" action="{{ route('admin.add.newItem') }}" method="POST">
                @csrf
                
                <!-- Item Name Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" name="item_name" required
                        class="block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="e.g. Ballpen, Folder, etc.">
                </div>
                
                <!-- Variant Type Select -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select id="variant_type" name="variant_type" required
                        class="block w-full rounded-md cursor-pointer border border-gray-300 bg-white py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="" disabled selected>Select variant type</option>
                        <option value="color">Color</option>
                        <option value="type">Type</option>
                        <option value="size">Size</option>
                    </select>
                </div>
                
                <!-- Variant Value Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                    <input type="text" name="variant_value" required
                        class="block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="e.g. red, standard, long, etc.">
                </div>

                <!-- Reorder Point Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reorder Point</label>
                    <input type="number" name="reorderpoint" min="0" required
                        class="block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Enter reorder point">
                </div>
                
                <!-- Initial Quantity Input -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <div class="relative">
                        <input type="number" name="quantity" min="0" required
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Enter initial quantity">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 text-sm">stocks</span>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAddNewItemModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                        Cancel
                    </button>
                    
                    <button type="submit"
                        class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Item</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    
    </div>
    
    

</div>


   <script>

function openAddNewItemModal() {
    const modal = document.getElementById('add-new-item-modal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('div').classList.remove('scale-95');
        modal.querySelector('div').classList.add('scale-100');
    }, 10);
}

function closeAddNewItemModal() {
    const modal = document.getElementById('add-new-item-modal');
    modal.querySelector('div').classList.remove('scale-100');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('add-new-item-form').reset();
    }, 200);
}

// Handle form submission with AJAX and SweetAlert
document.getElementById('add-new-item-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Confirm Add New Item',
        text: 'Are you sure you want to add this new item to the inventory?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d9488',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form via AJAX
            const form = e.target;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Item added successfully',
                        icon: 'success',
                        confirmButtonColor: '#0d9488'
                    }).then(() => {
                        // Refresh the page to show the new item
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to add item',
                        icon: 'error',
                        confirmButtonColor: '#0d9488'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while adding the item',
                    icon: 'error',
                    confirmButtonColor: '#0d9488'
                });
                console.error('Error:', error);
            });
        }
    });
});

// Close modal when clicking outside
document.getElementById('add-new-item-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddNewItemModal();
    }
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
        noResultsRow.querySelector('td').textContent = 'No items found.';
    } else {
        noResultsRow.style.display = 'none';
    }
}

        // Enhanced modal functions with vanilla JavaScript
        function openAddStockModal() {
        document.getElementById('add-stock-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Add event listeners for real-time calculation
        const itemSelect = document.getElementById('item_id');
        const quantityInput = document.querySelector('input[name="stock_quantity"]');
        const currentStockDisplay = document.getElementById('current-stock-display');
        
        function updateStockCalculation() {
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const currentStock = selectedOption.getAttribute('data-current');
                const quantityToAdd = quantityInput.value || 0;
                const newTotal = parseInt(currentStock) + parseInt(quantityToAdd);
                
                currentStockDisplay.textContent = 
                    `Current stock: ${currentStock} units. New total stocks will be: ${newTotal}`;
            }
        }
        
        itemSelect.addEventListener('change', updateStockCalculation);
        quantityInput.addEventListener('input', updateStockCalculation);
        }

    function closeAddStockModal() {
        document.getElementById('add-stock-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('update-stock-form').reset();
        document.getElementById('current-stock-display').textContent = '';
    }

    // Enhanced form submission with confirmation
    document.getElementById('update-stock-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const itemSelect = document.getElementById('item_id');
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        
        // Get current values for confirmation
        const currentStock = selectedOption.getAttribute('data-current');
        const quantityToAdd = formData.get('stock_quantity');
        const itemName = selectedOption.text.split(' (Current')[0];
        const newTotal = parseInt(currentStock) + parseInt(quantityToAdd);
        
        // Show confirmation dialog
        Swal.fire({
            title: 'Confirm Stock Addition',
            html: `<div class="text-center">
                    <p>You are about to add <b>${quantityToAdd}</b> units to:</p>
                    <p class="mt-2">Item: <b>${itemName}</b></p>
                    <p>Current stock: <b>${currentStock}</b> units</p>
                    <p class="font-semibold mt-2">New total stocks will be: <b>${newTotal}</b> units</p>
                </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d9488',
            cancelButtonColor: '#4b5563',
            confirmButtonText: 'Confirm Addition',
            cancelButtonText: 'Cancel',
            
            focusConfirm: false,
            customClass: {
                popup: 'text-left'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Add CSRF token to headers
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                };
                
                // Submit the form
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: headers
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Stock Updated!',
                            html: `<div class="text-left">
                                    <p>${data.message}</p>
                                    <p class="mt-2">Item: <b>${itemName}</b></p>
                                    <p>New stock quantity: <b>${data.stock_quantity}</b> units</p>
                                </div>`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        
                        closeAddStockModal();
                        // Refresh after a short delay
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Failed to connect to server. Please try again.',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
            }
        });
    });

    // Initialize modal behavior when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal when clicking outside
        document.getElementById('add-stock-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddStockModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('add-stock-modal').classList.contains('hidden')) {
                closeAddStockModal();
            }
        });
    });
</script>


@endsection