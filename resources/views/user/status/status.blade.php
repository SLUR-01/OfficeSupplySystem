@extends('layouts.user')

@section('content')
<div class="main-container h-full bg-gray-100 p-3" 
     x-data="{ 
         tab: localStorage.getItem('currentTab') || 'request-content',
         setTab(newTab) {
             this.tab = newTab;
             localStorage.setItem('currentTab', newTab);
         }
     }">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-dark">Manage request</h1>
            <p class="text-base text-dark mt-1 mb-3">View Requests, Returns&amp; Status</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-4 border-b mb-4">
        <button
            :class="tab === 'request-content' 
                ? 'border-b-2 border-teal-500 text-teal-600 font-medium' 
                : 'text-gray-600'"
            class="py-2 focus:outline-none"
            @click="setTab('request-content')"
        >
            My Request
        </button>
        <button
            :class="tab === 'withdrawal-content' 
                ? 'border-b-2 border-teal-500 text-teal-600 font-medium' 
                : 'text-gray-600'"
            class="py-2 focus:outline-none"
            @click="setTab('withdrawal-content')"
        >
            Completed
        </button>
        <button
            :class="tab === 'return-content' 
                ? 'border-b-2 border-teal-500 text-teal-600 font-medium' 
                : 'text-gray-600'"
            class="py-2 focus:outline-none"
            @click="setTab('return-content')"
        >
            Return Management
        </button>
    </div>

    <!-- Tab Contents -->
    <div x-show="tab === 'request-content'" x-cloak>
        @include('user.status.partials.request-content')
    </div>

    <div x-show="tab === 'withdrawal-content'" x-cloak>
        @include('user.status.partials.withdrawal-content')
    </div>

    <div x-show="tab === 'return-content'" x-cloak>
        @include('user.status.partials.return-content')
    </div>
</div>
@endsection

