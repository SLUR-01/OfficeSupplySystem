
@extends('layouts.chairman')

@section('content')
    {{-- <x-slot name="header">
        <h2 class="">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

    
    <div class="main-container h-100 p-3 bg-gray-100">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-2 mb-3">
          <div>
            <h1 class="text-[25px] font-extrabold text-dark">Profile</h1>
            <p class="text-base text-dark mt-2">Edit profile &amp; Save Signature</p>
          </div>
        </div>
            <div class="bg-white rounded-md">

                
                <div class="profile-container">
                    <div class="max-w-7xl">
                        <div>
                            <div class="max-w-xl">
                                @include('chairman.profile.partials.update-profile-information-form')
                            </div>
                        </div>
                   
                        <div>
                            <div class="max-w-xl">
                                @include('chairman.profile.partials.update-password-form')
                            </div>
                        </div>

                        <div>
                            <div class="max-w-xl">
                                @include('chairman.profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    @endsection