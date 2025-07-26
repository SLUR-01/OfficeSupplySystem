
@extends('layouts.admin')

@section('content')
    {{-- <x-slot name="header">
        <h2 class="">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}


    
    <div class="main-container h-100 p-3 bg-gray-100">
        <!-- Header -->
   
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 mb-3">
            <div>
              <h1 class="text-3xl font-extrabold text-dark">Profile</h1>
              <p class="text-base text-dark mt-2">Edit profile &amp; Save Signature</p>
            </div>
            <!-- Optional: You can add action buttons or links on the right side -->
            <!-- <div>
              <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                New Request
              </button>
            </div> -->
          </div>

            <div class="bg-white shadow rounded-md ">

                <div class="py-1">
                    <div class="max-w-7xl">
                        <div class="p-4 sm:p-8 ">
                            <div class="max-w-xl">
                                @include('admin.profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <div class="p-4 sm:p-8 ">
                            <div class="max-w-xl">
                                @include('admin.profile.partials.update-password-form')
                            </div>
                        </div>

                        <div class="p-4 sm:p-8 ">
                            <div class="max-w-xl">
                                @include('admin.profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection