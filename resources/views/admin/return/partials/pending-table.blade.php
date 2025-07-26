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
    <select id="pendingDepartment" class="w-30 border cursor-pointer border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" onchange="filterByDept(this)">
        <option value="all">All Dept</option>
        <option value="COT">COT</option>
        <option value="COED">COED</option>
        <option value="COHTM">COHTM</option>
    </select>

    <div class="relative w-full flex-grow sm:flex-grow-0">
        <input type="text" id="pendingSearchInput"
            class="w-full px-4 py-2 cursor-pointer border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Search returns by requester name...">
        <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
        </svg>
    </div>
</div>



<div class="bg-white shadow rounded-lg">
 
    <div class="px-3">
        <table id="pending-table" class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-white tracking-wide font-medium">
                <tr>
                    <th class="px-2 py-3 text-left text-sm text-gray-600 uppercase">Return Id</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Name</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Dept.</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Qty returned</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Date Returned</th>
                    <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Condition</th>
                    <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody id="pendingTbody" class="divide-y divide-gray-200">
                @foreach($pendingReturns as $return)
                @if($return->return_status === 'pending')
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-2 py-4 whitespace-nowrap text-sm font-semibold text-dark uppercase">             
                        Return#: {{ $return->id }}
                    </td>                    
                    <td class="px-3 text-gray-800 text-sm capitalize">{{ $return->requester_name ?? 'N/A' }}</td>
                    <td class="px-3 text-gray-800 text-sm capitalize">{{ $return->department }}</td>

                  
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

                    <td class="px-3 text-gray-800 text-sm capitalize">{{ $return->quantity }}</td>

                    <td class="px-3 whitespace-nowrap text-sm textdark capitalize">
                        <span>{{ \Carbon\Carbon::parse($return->return_date)->format('F j, Y') }}</span>
                    </td>                           
                        <td class="px-3 whitespace-nowrap text-sm capitalize">
                        @switch($return->condition)
                            @case('defective')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Defective</span>
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
                    <td class="px-3 py-4 text-center relative">
                        <button class="bg-teal-600 text-center px-3 py-2 text-sm text-white hover:bg-teal-700 rounded-md review-btn"
                                data-return-id="{{ $return->id }}"
                                data-requester-name="{{ $return->requester_name ?? 'N/A' }}"
                                data-item-name="{{ $return->item_name }}"
                                data-item-variant="{{ $return->variant_value }}"

                                data-quantity="{{ $return->quantity }}"
                                data-condition="{{ $return->condition }}"
                                data-description="{{ $return->description ?? 'No description provided' }}"

                              data-proof-image="{{ $return->proof_image }}"    
                                data-return-date="{{ \Carbon\Carbon::parse($return->return_date)->format('F j, Y g:i A') }}">
                                Review
                        </button>


                    </td>
                </tr>
        
                @endif
                @endforeach
            </tbody>
            <tr id="no-pending-row" style="display: none;">
                <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                    No return found.
                </td>
            </tr>
        </table>


        <div id="review-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden mt-5 z-50 overflow-auto p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-3 border-b bg-gray-50 sticky top-0 z-10">
                    <h2 class="text-xl font-bold text-gray-800">Return Details</h2>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-4 md:p-6">
                    <!-- Info Grid - 2 columns on medium+ screens, 1 column on small screens -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6">
                        <!-- Left Column -->
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Return ID</p>
                                <p id="modal-return-id" class="text-gray-800 font-semibold">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Requester Name</p>
                                <p id="modal-requester-name" class="text-gray-800 font-semibold">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Item Name</p>
                                <p id="modal-item-name" class="text-gray-800 font-semibold">-</p>
                                  <p id="modal-item-variant" class="text-gray-800 text-xs uppercase">-</p>
                            </div>
                        </div>
                
                        <!-- Right Column -->
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Quantity</p>
                                <p id="modal-quantity" class="text-gray-800 font-semibold">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Return Date</p>
                                <p id="modal-return-date" class="text-gray-800 font-semibold">-</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Condition</p>
                                <p id="modal-condition" class="text-gray-800 font-semibold">-</p>
                            </div>
                        </div>
                    </div>
        
                    <!-- Description and Proof Image - Stack on mobile, side by side on desktop -->
                    <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                        <!-- Description -->
                        <div class="w-full md:w-1/2">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-2">Description</p>
                            <div id="modal-description" class="text-gray-800 bg-gray-50 p-3 rounded-lg h-40 md:h-48 overflow-y-auto">-</div>
                        </div>
                        
                        <!-- Proof Image -->
                        <div class="w-full md:w-1/2">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-2">Proof Image</p>
                            <div id="modal-proof-image-container" class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-40 md:h-48 cursor-pointer hover:opacity-90 transition-opacity">
                                <p class="text-gray-500 italic p-4">No image provided</p>
                                <!-- Image will be inserted here via JavaScript -->
                                
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Image Preview Modal -->
                <div id="image-preview-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center hidden z-50 p-4">
                    <div class="relative max-w-4xl w-full">
                        <button id="close-image-modal" class="absolute top-2 right-2 text-white hover:text-gray-300 bg-black/50 rounded-full p-2 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <img id="full-size-image" src="" alt="Proof Image" class="max-w-full max-h-[80vh] mx-auto rounded-lg object-contain">
                    </div>
                </div>
        
                <!-- Modal Footer -->
                <div class="flex justify-end items-center p-4 border-t bg-gray-50  bottom-0">
                    @foreach($pendingReturns as $return)
                    <div class="flex gap-2 items-center hidden return-forms" data-return-id="{{ $return->id }}">
                        <form class="reject-form" action="{{ route('admin.return.reject', $return->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                Reject
                            </button>
                        </form>
                        <form class="approve-form" action="{{ route('admin.return.approve', $return->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors">
                                Approve
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

 

    

<script>
document.querySelectorAll('.review-btn').forEach(button => {
    button.addEventListener('click', function() {
        const returnId = this.getAttribute('data-return-id');
        const requesterName = this.getAttribute('data-requester-name');
        const itemName = this.getAttribute('data-item-name');
        const itemVariant = this.getAttribute('data-item-variant');
        const quantity = this.getAttribute('data-quantity');
        const condition = this.getAttribute('data-condition');
        const description = this.getAttribute('data-description');
        const proofImage = this.getAttribute('data-proof-image');
        const returnDate = this.getAttribute('data-return-date');

        document.getElementById('modal-return-id').textContent = returnId;
        document.getElementById('modal-requester-name').textContent = requesterName;
        document.getElementById('modal-item-name').textContent = itemName;
        document.getElementById('modal-item-variant').textContent = itemVariant;
       
        document.getElementById('modal-quantity').textContent = quantity;
        document.getElementById('modal-condition').textContent = condition;
        document.getElementById('modal-description').textContent = description;
        document.getElementById('modal-return-date').textContent = returnDate.slice(0, 13);


        // proof image handling
        const imageContainer = document.getElementById('modal-proof-image-container');
        imageContainer.innerHTML = ''; // ⚡ Important: Clear previous content first

      if (proofImage && proofImage.trim() !== '') {
    const imagePath = '/' + proofImage; // ensures /storage/returns/proof_images/xxx.jpg
    const img = document.createElement('img');
    img.src = imagePath;
    img.alt = 'Proof Image';
    img.classList.add('h-full', 'w-auto', 'object-contain');

    imageContainer.appendChild(img);

    // Fullscreen preview
    img.addEventListener('click', () => {
        document.getElementById('full-size-image').src = imagePath;
        document.getElementById('image-preview-modal').classList.remove('hidden');
    });
}


        // show the main review modal
        document.getElementById('review-modal').classList.remove('hidden');

        // show approve/reject forms
        document.querySelectorAll('.return-forms').forEach(form => {
            if (form.getAttribute('data-return-id') === returnId) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        });
    });
});

document.querySelectorAll('.reject-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Reject Return?',
            text: "Are you sure you want to reject this return request? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = form.getAttribute('action');
                const token = form.querySelector('input[name="_token"]').value;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Rejected!',
                            text: 'The return request has been rejected successfully.',
                            timer: 1000,
                            showConfirmButton: false,
                            willClose: () => {
                                // Reload after SweetAlert closes
                                location.reload();
                            }
                        });

                        document.getElementById('review-modal').classList.add('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to reject the return request.',
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'Could not process the rejection request.'
                    });
                });
            }
        });
    });
});

document.querySelectorAll('.approve-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Approve Return?',
            text: "This action cannot be undone.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#14b8a6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = form.getAttribute('action');
                const token = form.querySelector('input[name="_token"]').value;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: data.message,
                            timer: 1000,
                            showConfirmButton: false,
                            willClose: () => {
                                // Reload after SweetAlert closes
                                location.reload();
                            }
                        });

                        document.getElementById('review-modal').classList.add('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Request Failed',
                        text: 'Could not process the request.'
                    });
                });
            }
        });
    });
});
// close modals
document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('review-modal').classList.add('hidden');
});

document.getElementById('close-image-modal').addEventListener('click', function() {
    document.getElementById('image-preview-modal').classList.add('hidden');
});

const pendingSearchInput = document.getElementById('pendingSearchInput');
const pendingDepartment = document.getElementById('pendingDepartment');

pendingSearchInput.addEventListener('input', filterRequests);
pendingDepartment.addEventListener('change', filterRequests);

function filterRequests() {
  const selectedDept = pendingDepartment.value.toLowerCase();
  const searchValue = pendingSearchInput.value.toLowerCase();
  const rows = document.querySelectorAll('#pendingTbody tr');
  let visibleCount = 0;

  rows.forEach(row => {
    if (row.id === 'no-pending-row') return;

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

  const noResultsRow = document.getElementById('no-pending-row');
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



</script>
