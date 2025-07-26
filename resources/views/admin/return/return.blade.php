@extends('layouts.admin')

@section('content')



<div class="main-container h-full bg-gray-100 p-3 h-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 md:mb-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Return Management</h1>
          <p class="text-sm md:text-base text-gray-600 mt-1 mb-3">Review, Approve &amp; Manage Returns</p>
          
        </div>
      </div>
      
    
<!-- resources/views/returns/index.blade.php -->
<div x-data="{ 
    tab: localStorage.getItem('activeReturnTab') || 'pending' 
}" 
x-init="$watch('tab', value => localStorage.setItem('activeReturnTab', value))">

    <div class="flex gap-4 border-b mb-4">
        <button 
            :class="tab === 'pending' ? 'border-b-2 border-teal-500 text-teal-600 font-medium' : 'text-gray-600'" 
            class=" py-2 focus:outline-none"
            @click="tab = 'pending'">
            Review Returns
        </button>
        <button 
            :class="tab === 'approved' ? 'border-b-2 border-teal-500 text-teal-600 font-medium' : 'text-gray-600'" 
            class="py-2 focus:outline-none"
            @click="tab = 'approved'">
            Manage Replacements
        </button>
    </div>

    <div x-show="tab === 'pending'">
        @include('admin.return.partials.pending-table')
    </div>

    <div x-show="tab === 'approved'">
        @include('admin.return.partials.approve-table')
    </div>

</div>

</div>
    

<script>

</script>
@endsection
