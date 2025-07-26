

@extends('layouts.admin')

@section('content')


<div class="main-container bg-gray-100 p-[15px] h-100">
            
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-dark">User Management</h1>
            <p class="text-base text-dark mt-1 pb-3">Add, edit, or remove users from the system.</p>
            
        </div>
    </div>

    @if(session('success'))
    <div id="successMessage" class="p-4 mb-4 text-green-800 bg-green-100 border border-green-400 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-start">
        <div>
            <button id="openAddUserModal"
                class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors">
                Add User
            </button>
        </div>
    
        <div class="relative w-full sm:w-auto flex-grow">
            <input type="text" id="searchInput"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Search User by name">
            <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z" />
            </svg>
        </div>
    </div>
    

    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="overflow-x-auto px-3 overflow-y-hidden">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-white tracking-wide font-medium">
                    <tr>
                        <th class="py-3 text-center text-sm text-gray-600 uppercase">User Id</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Name</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Email</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Role</th>
                        <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Department</th>
                        <th class="px-3 py-3 text-center text-sm text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        @if($user->role != 'admin')
                            <tr>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">{{ $user->id }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">{{ $user->name }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">{{ $user->email }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left capitalize">{{ $user->role }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">{{ $user->department }}</td>
                                <td class="px-3 py-3 text-sm text-gray-800 text-left">
                                    <div class="flex justify-center space-x-2">
                                        <button 
                                            type="button"
                                            class="px-3 py-2 rounded-md text-white bg-teal-600 hover:bg-teal-700 transition shadow-sm open-edit-modal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            data-department="{{ $user->department }}"
                                        >
                                            Edit
                                        </button>
                                    
                                        <button type="button" 
                                                class="px-3 py-2  rounded-md text-white bg-red-600 hover:bg-red-700 transition shadow-sm delete-user-btn" 
                                                data-id="{{ $user->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tr id="no-requests-row" style="display: none;">
                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                      No users found.
                    </td>
                </tr>
            </table>

        </div>
        <div id="editUserModal" class="fixed inset-0 z-50 flex mt-3 items-center justify-center hidden bg-black bg-opacity-50 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-y-auto">
                <div class="p-3 overflow-y-auto">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">Edit User</h3>
        
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
        
                        <!-- Hidden user ID -->
                        <input type="hidden" name="id" id="editUserId">
        
                        <!-- Name -->
                        <div class="mb-2">
                            <label for="editName" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="editName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
        
                        <!-- Email -->
                        <div class="mb-2">
                            <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="editEmail" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
        
                        <!-- Role -->
                        <div class="mb-2">
                            <label for="editRole" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="editRole" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Select Role</option>
                                <option value="user">User</option>
                                <option value="chairman">Chairman</option>
                                <option value="dean">Dean</option>
                            </select>
                        </div>
        
                        <!-- Department -->
                        <div class="mb-2">
                            <label for="editDepartment" class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department" id="editDepartment" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled>Select Department</option>
                                <option value="COT">COT</option>
                                <option value="COED">COED</option>
                                <option value="COHTM">COHTM</option>
                            </select>
                        </div>
                    </form>
                </div>
        
                <div class="bg-gray-50 px-4 py-3 flex justify-end">
                    <button type="button" id="cancelEditUser" class="mr-2 px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" form="editUserForm" class="px-4 py-2 border rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update User
                    </button>
                </div>
            </div>
        </div>
        <div id="addUserModal" class="fixed inset-0 z-50 flex mt-3 items-center justify-center hidden bg-black bg-opacity-50 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-xl pt-5 w-full max-w-md mx-4 overflow-y-auto">
                <div class="p-3 overflow-y-aut">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">Add New User</h3>
        
                    <form id="addUserForm" method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
        
                        <!-- Name -->
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
        
                        <!-- Email -->
                        <div class="mb-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
        
                     <!-- Password -->
                        <div class="mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <span id="togglePassword" class="absolute right-3 top-3 cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <small class="text-gray-500"> (uppercase letters, numbers, and a symbol).</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <span id="toggleConfirmPassword" class="absolute right-3 top-3 cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

        
                        <!-- Role -->
                        <div class="mb-2">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled selected>Select Role</option>
                                <option value="user">User</option>
                                <option value="chairman">Chairman</option>
                                <option value="dean">Dean</option>
                            </select>
                        </div>
        
                        <!-- Department -->
                        <div class="mb-2">
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department" id="department" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled selected>Select Department</option>
                                <option value="COT">COT</option>
                                <option value="COED">COED</option>
                                <option value="COHTM">COHTM</option>
                            </select>
                        </div>
                    </form>
                </div>
        
                <div class="bg-gray-50 px-4 py-3 flex justify-end">
                    <button type="button" id="cancelAddUser" class="mr-2 px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" form="addUserForm" class="px-4 py-2 border rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add User
                    </button>
                </div>
            </div>
        </div>
        
        
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const editButtons = document.querySelectorAll('.open-edit-modal');
const editModal = document.getElementById('editUserModal');
const editForm = document.getElementById('editUserForm');

editButtons.forEach(button => {
    button.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        const userName = this.getAttribute('data-name');
        const userEmail = this.getAttribute('data-email');
        const userRole = this.getAttribute('data-role');
        const userDepartment = this.getAttribute('data-department');

        // Set form values
        document.getElementById('editUserId').value = userId;
        document.getElementById('editName').value = userName;
        document.getElementById('editEmail').value = userEmail;
        document.getElementById('editRole').value = userRole;
        document.getElementById('editDepartment').value = userDepartment;

        // Set form action
        editForm.action = `/users/${userId}`;

        // Show modal
        editModal.classList.remove('hidden');
    });
});

// Close edit modal
document.getElementById('cancelEditUser').addEventListener('click', function () {
    editModal.classList.add('hidden');
});

// Handle form submission with SweetAlert
editForm.addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to update this user\'s information?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0d9488',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(editForm.action, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: document.getElementById('editUserId').value,
                    name: document.getElementById('editName').value,
                    email: document.getElementById('editEmail').value,
                    role: document.getElementById('editRole').value,
                    department: document.getElementById('editDepartment').value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        editModal.classList.add('hidden');
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: data.message || 'An error occurred.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong while updating.',
                    });
                });
        }
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
    noResultsRow.querySelector('td').textContent = 'No Users found.';
    } else {
    noResultsRow.style.display = 'none';
    }
    }

    // Delete User
    const deleteButtons = document.querySelectorAll('.delete-user-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#4b5563',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            const row = button.closest('tr');
                            row.remove();
                        } else {
                            Swal.fire('Error', 'Could not delete user.', 'error');
                        }
                    });
                }
            });
        });
    });

    // Modal Handling
    const modal = document.getElementById('addUserModal');
    const openModalBtn = document.getElementById('openAddUserModal');
    const cancelBtn = document.getElementById('cancelAddUser');

    if (openModalBtn && modal && cancelBtn) {
        openModalBtn.addEventListener('click', function () {
            modal.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', function () {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    }

    const form = document.getElementById('addUserForm');

    if (form) {
    form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Use fetch API to send the form data
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            modal.classList.add('hidden');
            Swal.fire({
                icon: 'success',
                title: 'User Added',
                text: 'Successfully added a new user!',
                confirmButtonColor: '#6366F1'
            }).then(() => {
                window.location.reload(); // Reload page to reflect new user in the list
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Something went wrong!',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to add user. Please try again.',
        });
    });
    });
    }
    // Function to toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = this.querySelector('i');

    if (passwordField.type === "password") {
    passwordField.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
    } else {
    passwordField.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
    }
    });

    // Function to toggle confirm password visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const confirmPasswordField = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');

    if (confirmPasswordField.type === "password") {
    confirmPasswordField.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
    } else {
    confirmPasswordField.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
    }
    });

    });
    </script>
    




@endsection

