@extends('layouts.admin')

@section('content')
        
        <style>
       
        .form-control{
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.13);
            height: 38px;
            background-color: rgb(245, 245, 245);
            outline: none;
        }
        .form-description{
            width: 100%;
            border-radius: 5px;

            border: 1px solid rgba(0, 0, 0, 0.13);
            background-color: rgb(245, 245, 245)

        }
        .request-form input:focus,
        .request-form select:focus,
        .request-form textarea:focus {
        outline: teal; /* Removes default outline */
        box-shadow: none; /* Removes any additional box-shadow (if present) */
        }
     
    </style>
  
        <div class="wrapper">
                
            <a id="show-request-form" href="requestform" class="sub-header-title">Edit Request</a>
            <span class="divider">/</span> <!-- Divider element -->
         
        </div>


            <div class="main-container">
                    @if (session('success'))
                     <div class="alert alert-success">
                            {{ session('success') }}
                     </div>
                    @endif
           
                    <div class="header-title">
                      
                    </div>
                    <!-- Request Form -->
                    <div id="request-form-container" class="main-table">
                        <form action="{{ route('user.request.store') }}" method="POST" class="request-form-container">
                            <fieldset>
                                @csrf
                                <!-- Hidden Input for User ID -->
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="requester_name" value="{{ Auth::user()->name }}">
                        
                                <!-- Form Fields -->
                                <div class="row gx-3 gy-2">
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <label for="department" class="form-label" style="font-weight: 600">Department</label>
                                        <select class="form-control" id="department" name="department"
                                                style="border-radius: 5px;
                                                       border: 1px solid rgba(0, 0, 0, 0.13);
                                                       height: 45px;
                                                       background-color: rgb(247, 247, 247);
                                                       outline: none;" required>
                                            <option class="select" value="" disabled selected>Select your department</option>
                                            <option value="COED">College of Education</option>
                                            <option value="COT">College of Technology</option>
                                            <option value="COHTM">College of Hospitality and Tourism Management</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <label for="item_name" class="form-label" style="font-weight: 600">Item Name</label>
                                        <select class="form-control" id="item_name" name="item_name" 
                                                style="border-radius: 5px;
                                                       border: 1px solid rgba(0, 0, 0, 0.13);
                                                       height: 45px;
                                                       background-color: rgb(247, 247, 247);
                                                       outline: none;" required>
                                            <option value="" disabled selected>Select an item</option>
                                            
                                            <optgroup label="B">
                                                <option value="Ballpen">Ballpen</option>
                                                <option value="Binder Clip">Binder Clip</option>
                                                <option value="Bondpaper">Bondpaper</option>
                                                <option value="Box Files">Box Files</option>
                                                <option value="Brown Envelope">Brown Envelope</option>
                                            </optgroup>
                                                                    <!-- Group C -->
                                            <optgroup label="C">
                                                <option value="Construction Paper">Construction Paper</option>
                                                <option value="Correction Tape">Correction Tape</option>
                                            </optgroup>

                                            <!-- Group E -->
                                            <optgroup label="E">
                                                <option value="Expanded Envelope">Expanded Envelope</option>
                                            </optgroup>

                                            <!-- Group F -->
                                            <optgroup label="F">
                                                <option value="Fastener">Fastener</option>
                                            </optgroup>

                                            <!-- Group F -->
                                            <optgroup label="F">
                                                <option value="Folder">Folder</option>
                                            </optgroup>

                                            <!-- Group L -->
                                            <optgroup label="L">
                                                <option value="Liquid Eraser">Liquid Eraser</option>
                                            </optgroup>

                                            <!-- Group M -->
                                            <optgroup label="M">
                                                <option value="Marker">Marker</option>
                                            </optgroup>

                                            <!-- Group P -->
                                            <optgroup label="P">
                                                <option value="Paper Organizer">Paper Organizer</option>
                                           
                                                <option value="Pencil">Pencil</option>
                                                <option value="Pins">Pins</option>
                                                <option value="Plastic Envelope">Plastic Envelope</option>
                                                <option value="Plastic Folder">Plastic Folder</option>
                                                <option value="Post it">Post it</option>
                                                <option value="Puncher">Puncher</option>
                                            </optgroup>

                                            <!-- Group S -->
                                            <optgroup label="S">
                                                <option value="Scissor">Scissor</option>
                                                <option value="Special Paper">Special Paper</option>
                                                <option value="Staple wire">Staple wire</option>
                                            </optgroup>

                                            <!-- Group V -->
                                            <optgroup label="V">
                                                <option value="Velum">Velum</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <label for="quantity" class="form-label" style="font-weight: 600">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                                             style="border-radius: 5px;
                                                             border: 1px solid rgba(0, 0, 0, 0.13);
                                                             height: 45px;
                                                             background-color: rgb(247, 247, 247);
                                                             outline: none;"  required min="1">
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                        <label for="date" class="form-label" style="font-weight: 600">Date</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                                           style="border-radius: 5px;
                                                                  border: 1px solid rgba(0, 0, 0, 0.13);
                                                                  height: 45px;
                                                                  background-color: rgb(247, 247, 247);
                                                                  outline: none;" required>
                                    </div>

                                    
                        
                                <div class="input-container">
                                    <!-- Signature Section -->
                                    <div class="input-group">
                                        <label for="signature" class="form-label">Signature</label>
                                        <div class="signature-container">
                                            <canvas id="signatureCanvas"></canvas>
                                            <button type="button" id="clearSignature" class="clear-btn btn-sm btn-danger">Clear</button>
                                        </div>
                                    </div>
                                
                                    <!-- Description Section -->
                                    <div class="input-group">
                                        <label for="description" class="form-label">Description</label>
                                        <div class="text-area-container">
                                            <textarea class="form-description" id="description" name="description" placeholder="Provide additional details about your request"></textarea>
                                        </div>
                                    </div>
                                
                                
                                    <!-- Hidden Signature Input -->
                                    <input type="hidden" name="signature" id="signatureInput">

                                </div>
                                <div class="col-12 d-flex justify-content-start mt-3">
                                    <button type="submit" class="update-btn">Update</button>
                                </div> 
                            </div>
                        </fieldset>
                    </form>

                
                        
                      
                        
                    </div>
                 
                
</div>
@endsection
