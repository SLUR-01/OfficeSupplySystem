<x-app-layout>
    <div class="header">
        
    </div>

    <div class="main-container">
            <div class="main-content">
        
        <style>
            .form-control{
                border-radius: 5px;
                border: 1px solid rgba(0, 0, 0, 0.13);
                height: 38px;
                background-color: rgb(245, 245, 245)
            }
            .form-description{
                width: 100%;
                border-radius: 5px;

                border: 1px solid rgba(0, 0, 0, 0.13);
                background-color: rgb(245, 245, 245)

            }
        </style>

<div class="container">
   
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
   
   
<form action="{{ route('navigation.request.store') }}" method="POST" class="request-form">
    <fieldset>
        <legend> 
            <div class="form-header">
                <a href="requestform">Request Form</a>
                <span class="divider">/</span> <!-- Divider element -->
                <a href="status" >Status</a>
            </div>
        </legend>

        @csrf
        <div class="row gx-3 gy-2">
            <input type="hidden" name="requester_name" value="{{ Auth::user()->name }}">

             {{-- department --}}

            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <label for="department" class="form-label">Department</label>
                <select class="form-control" id="department" name="department" required>
                    <option value="" disabled selected>Select your department</option>
                    <option value="College of Education">College of Education</option>
                    <option value="College of Technology">College of Technology</option>
                    <option value="College of Hospitality and Tourism Management">College of Hospitality and Tourism Management</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <select class="form-control" id="item_name" name="item_name" required>
                    <option value="" disabled selected>Select an item</option>
                    <option value="Pen">Pen</option>
                    <option value="Folder">Folder</option>
                    <option value="Liquid Eraser">Liquid Eraser</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
            </div>
            
       
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

          
            
            <div class="col-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-description" id="description" name="description" rows="4" placeholder="Provide additional details about your request"></textarea>
            </div>
            

            

            <div class="col-12 d-flex justify-content-end mt-3">
                <button type="submit" class="submit-btn">Submit Request</button>
            </div>
        </div>
    </fieldset>
</form>
    

<div class="request-status">
  

    <table class="table">
        <legend> 
            <h5 class="form-title">Status</h5>
        </legend>
        <div class="table">
        <tbody>
        <thead>
            <tr>
                <th>Requester Name</th>
                <th>Department</th>
                <th>Date</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->requester_name }}</td>
                    <td>{{ $request->department }}</td>
                    <td>{{ $request->date }}</td>
                    <td>{{ $request->item_name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                </tr>
            @endforeach
            
        </tbody>


    </table>
</div>
</div> 



</div>


        
            </div>
        </div>

    </div>


       


</x-app-layout>

   

