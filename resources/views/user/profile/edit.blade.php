
@extends('layouts.user')

@section('content')

    
<div class="main-container h-100 p-3 bg-gray-100">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 mb-3">
    <div>
      <h1 class="text-[25px] font-extrabold text-dark">Profile</h1>
      <p class="text-base text-dark mt-2">Edit profile &amp; Save Signature</p>
    </div>
    <!-- Optional: You can add action buttons or links on the right side -->
    <!-- <div>
      <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        New Request
      </button>
    </div> -->
  </div>
  <!-- Status Alert -->
  @if (session('status'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md">
      {{ session('status') }}
    </div>
  @endif

  <!-- Main Profile Container -->
  <div class="max-w-7xl mx-auto space-y-4">
    <!-- Flex Container for Profile and Signature -->
    <div class="flex flex-col md:flex-row md:space-x-4 space-y-6 md:space-y-0">
      <!-- Edit Profile Information -->
      <div class="flex-1 bg-white shadow rounded-md p-6">
    
        @include('user.profile.partials.update-profile-information-form')
      </div>

      <!-- Signature Form -->
      <div class="flex-1 bg-white shadow rounded-md p-6">
        <form action="{{ route('user.signature.save') }}" method="POST">
          <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Signature') }}
          </h2>
          <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's Signature") }}
          </p>
          @csrf
          <div class="mt-4">
            <div class="border rounded-md p-2 bg-gray-50">
              <canvas id="signatureCanvas" class="w-full h-48  rounded"></canvas>
            </div>
            <div class="flex justify-end mt-2 space-x-2">
              <button type="submit" id="saveSignature" class="w-20 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-md hover:bg-blue-700 transition">
                Save
              </button>
              <button type="button" id="clearSignature" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                Clear
              </button>
          
            </div>
            <input type="hidden" name="signature" id="signatureInput">
            

          </div>
 
       
        </form>
      </div>
    </div>

    <!-- Update Password Form -->
    <div class="bg-white shadow rounded-md p-6">
      @include('user.profile.partials.update-password-form')
    </div>

    <!-- Delete User Form -->
    <div class="bg-white shadow rounded-md p-6 ">
      @include('user.profile.partials.delete-user-form')
    </div>
  </div>
</div>

        <script>
window.onload = function () {
  const canvas = document.getElementById('signatureCanvas');
  const ctx = canvas.getContext('2d');
  const clearButton = document.getElementById('clearSignature');
  const signatureInput = document.getElementById('signatureInput');
  const form = document.querySelector('form[action="{{ route("user.signature.save") }}"]');

  // Set canvas dimensions
  canvas.width = 500;
  canvas.height = 200;
  ctx.lineWidth = 2;
  ctx.strokeStyle = 'black';

  let isDrawing = false;
  let lastX = 0;
  let lastY = 0;

  function getDrawingPosition(e) {
    // Use offsetX/Y if available for best alignment
    if (e.offsetX !== undefined && e.offsetY !== undefined) {
      return { x: e.offsetX, y: e.offsetY };
    } else {
      const rect = canvas.getBoundingClientRect();
      return { x: e.clientX - rect.left, y: e.clientY - rect.top };
    }
  }

  canvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    const { x, y } = getDrawingPosition(e);
    lastX = x;
    lastY = y;
  });

  canvas.addEventListener('mousemove', (e) => {
    if (!isDrawing) return;
    const { x, y } = getDrawingPosition(e);
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    ctx.stroke();
    lastX = x;
    lastY = y;
  });

  canvas.addEventListener('mouseup', () => isDrawing = false);
  canvas.addEventListener('mouseleave', () => isDrawing = false);

  clearButton.addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    signatureInput.value = '';
  });

  form.addEventListener('submit', function (e) {
    // Check if canvas has been drawn on by comparing with empty canvas data URL
    if (canvas.toDataURL() !== 'data:,') {
      signatureInput.value = canvas.toDataURL('image/png');
    } else {
      alert('Please provide a signature before saving.');
      e.preventDefault();
    }
  });
};

        </script>
        

    @endsection