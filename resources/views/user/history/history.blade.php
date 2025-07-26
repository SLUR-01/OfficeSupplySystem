@extends('layouts.user')

@section('content')

<div class="main-container h-full bg-gray-100 p-3" 
     x-data="{ 
         tab: localStorage.getItem('historyTab') || 'withdrawal-history',
         setTab(newTab) {
             this.tab = newTab;
             localStorage.setItem('historyTab', newTab);
         }
     }">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-dark">Request History</h1>
            <p class="text-base text-dark mt-1 mb-3">View Past Requests &amp; Status</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-4 border-b mb-4">
        <button
            :class="tab === 'withdrawal-history' 
                ? 'border-b-2 border-teal-500 text-teal-600 font-medium' 
                : 'text-gray-600'"
            class="py-2 focus:outline-none"
            @click="setTab('withdrawal-history')"
        >
            Withdrawal History
        </button>
        <button
            :class="tab === 'return-history' 
                ? 'border-b-2 border-teal-500 text-teal-600 font-medium' 
                : 'text-gray-600'"
            class="py-2 focus:outline-none"
            @click="setTab('return-history')"
        >
            Return History
        </button>
    </div>

    <!-- Tab Contents -->
    <div x-show="tab === 'withdrawal-history'" x-cloak>
        @include('user.history.partials.withdrawal-history')
    </div>

    <div x-show="tab === 'return-history'" x-cloak>
        @include('user.history.partials.return-history')
    </div>
</div>

@endsection