@extends('layouts.user')

@section('content')

<div class="bg-gray-100 p-3 h-full overflow-y-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-dark">Feedback</h1>
            <p class="text-base sm:text-base text-dark mt-1 mb-3">Submit feedback</p>
        </div>
    </div>
    
 <div class="bg-white rounded-lg p-4 sm:p-6 shadow-lg">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Share Your Feedback</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500 self-start sm:self-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
        </div>

        <form id="feedbackForm" method="POST" action="{{ route('user.feedback') }}" class="space-y-6">
            @csrf

            <!-- Rating -->
            <div>
                <label class="block text-gray-700 font-medium mb-3 text-sm sm:text-base">How would you rate your experience?</label>
                <div class="grid grid-cols-2 sm:flex gap-3 sm:gap-2">
                 <!-- Poor (1) -->
                 <button type="button" class="rating-btn group flex-1 flex flex-col items-center p-3 rounded-full border-2 border-transparent transition-all duration-200 hover:bg-red-100 hover:border-red-300 focus:outline-none" data-rating="1" onclick="setRating(1)">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center group-hover:bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="mt-2 font-medium text-sm">Poor</span>
                </button>
                
                <!-- Fair (2) -->
                <button type="button" class="rating-btn group flex-1 flex flex-col items-center p-3 rounded-full border-2 border-transparent transition-all duration-200 hover:bg-yellow-100 hover:border-yellow-200   focus:outline-none" data-rating="2" onclick="setRating(2)">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center group-hover:bg-white-500 group-hover:shadow-md transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="mt-2 font-medium text-sm">Fair</span>
                </button>
                
                <!-- Good (3) -->
                <button type="button" class="rating-btn group flex-1 flex flex-col items-center p-3 rounded-full border-2 border-transparent transition-all duration-200 hover:bg-yellow-100 hover:border-yellow-300 focus:outline-none" data-rating="3" onclick="setRating(3)">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center group-hover:bg-white group-hover:shadow-md transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="mt-2 font-medium text-sm">Good</span>
                </button>
                
                <!-- Great (4) -->
                <button type="button" class="rating-btn group flex-1 flex flex-col items-center p-3 rounded-full border-2 border-transparent transition-all duration-200 hover:bg-green-100 hover:border-green-300 focus:outline-none" data-rating="4" onclick="setRating(4)">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center group-hover:bg-white group-hover:shadow-md transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 17.828a4 4 0 01-5.656 0M9 7h.01M15 7h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="mt-2 font-medium text-sm">Great</span>
                </button>
                
                <!-- Excellent (5) -->
                <button type="button" class="rating-btn group flex-1 flex flex-col items-center p-3 rounded-full border-2 border-transparent transition-all duration-200 hover:bg-blue-100 hover:border-blue-300 focus:outline-none" data-rating="5" onclick="setRating(5)">
                    <div class="h-16 w-16 rounded-full flex items-center justify-center group-hover:bg-white group-hover:shadow-md transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <span class="mt-2 font-medium text-sm">Excellent</span>
                </button>
                </div>
                <input type="hidden" name="rating" id="rating" required>
            </div>

            <!-- Feedback Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">What type of feedback are you providing?</label>
                <div class="relative">
                    <select name="type" class="appearance-none w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" required>
                        <option value="General feedback">General feedback</option>
                        <option value="Bug report">Bug report</option>
                        <option value="Feature request">Feature request</option>
                        <option value="Compliment">Compliment</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <div>
                <label class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">Your comments</label>
                <textarea 
                    name="comments"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" 
                    rows="4" 
                    placeholder="What did you like or what could we improve?"
                    required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-teal-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-teal-600 transition duration-200 flex items-center justify-center shadow-md text-sm sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>
</div>

    

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');
    
    // Rating buttons functionality
    const ratingButtons = document.querySelectorAll('.rating-btn');
    ratingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            document.getElementById('rating').value = rating;
            
            // Remove all active classes first
            ratingButtons.forEach(btn => {
                btn.classList.remove('bg-gray-200', 'border-2', 'border-indigo-500');
            });
            
            // Add active class to clicked button
            this.classList.add('bg-gray-200', 'border-2', 'border-indigo-500');
        });
    });
    
    // Toggle email field based on checkbox
    const contactCheckbox = document.getElementById('contact-me');
    const emailField = document.getElementById('email-field');
    
    if (contactCheckbox && emailField) {
        contactCheckbox.addEventListener('change', function() {
            if(this.checked) {
                emailField.classList.remove('hidden');
            } else {
                emailField.classList.add('hidden');
            }
        });
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Reset form
                form.reset();
                document.getElementById('rating').value = '';
                ratingButtons.forEach(btn => {
                    btn.classList.remove('bg-gray-200', 'border-2', 'border-indigo-500');
                });
                if (emailField) emailField.classList.add('hidden');
                
                // Show success message with auto-reload
                Swal.fire({
                    title: 'Thank You!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#4f46e5',
                    timer: 3000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.reload();
                    }
                });
            } else {
                // Show error message if needed
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: 'An unexpected error occurred. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>


        @endsection

        
            




