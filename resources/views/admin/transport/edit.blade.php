@extends('admin_layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/selectize/selectize.css') }}">
    <script src="https://kit.fontawesome.com/d868f4cf6e.js" crossorigin="anonymous"></script>
@endsection
@section('content')
<div class="content-header row">
</div>
<div class="row">
  <div class="col-md-12">
        <div class="card">
            <div class="card-content collpase show">
                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Fast Lines!</b>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
               @endif
                <div class="card-body">
                    <form class="form form-horizontal" method="POST" action="{{route('transports.update', $transport->id)}}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-car"></i>Edit Transport</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput1">Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="transport_type_id" required>  
                                            <option selected disabled="">Select Type</option>
                                            @foreach($transport_types as $type)
                                            <option value="{{$type->id}}" {{ $transport->transport_type_id === $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        	<div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Make</label>
                                    <div class="col-md-9">
                                        <input type="text" id="userinput2" class="form-control border-primary" placeholder="Make"
                                        name="make" value="{{$transport->make}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput3">Capacity</label>
                                    <div class="col-md-9">
                                        <input type="number" id="password" class="form-control border-primary" placeholder="Capacity"
                                        name="capacity" value="{{$transport->capacity}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput4">Route</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="route_id" required>  
                                            <option selected disabled="">Select Route</option>
                                            @foreach($routes as $route)
                                            <option value="{{$route->id}}" {{ $transport->route_id === $route->id ? 'selected' : '' }}>{{$route->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row to repeat starts -->

                        @foreach($costs as $cost)
                        <div class="row validityContainer" id="" style="position:relative">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Cost </label>
                                    <div class="col-md-9">
                                        <input type="hidden" name="cost_id[]" value="{{$cost->id}}" />
                                        <input type="number" class="form-control border-primary" placeholder="Cost" name="cost[]" value="{{$cost->cost}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Validity</label>
                                    <div class="col-md-9">
                                        <!-- <input type="date" id="validity{{$cost->id}}" class="form-control border-primary" placeholder="Validity" name="validity[]" value="{{$cost->validity}}"> -->
                                        <input type="text"  id="validity{{$cost->id}}" class="form-control border-primary datepicker" name="validity[]" value="{{$cost->validity}}" placeholder="Validity Date" required>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        @endforeach                         
                        <div class="col-md-12 text-center" id="validity_button">
                            <button id="addValidity" class="btn btn-info mx-auto">Add Validity Date</button>
                        </div>
                                                
                        <!-- tow to repeat ends --> 
                    </div>
	                    <div class="form-actions right">
	                        <button type="submit" class="btn btn-primary">
	                          	<i class="la la-check-square-o"></i> Update
	                        </button>
	                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('app-assets/vendors/js/forms/select/selectize.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-selectize.js') }}" type="text/javascript"></script>

<script>
    const datepickerElements = document.querySelectorAll('.datepicker');
    
    flatpickr(".datepicker", {
      dateFormat: "Y-m-d",
      minDate: "today",
      enableTime: false, 
      allowInput:true
    });

    
</script>


<script type="text/javascript">
    // ****************** logic for adding validity again and again
    var addButtonCounter = 0; // Counter for generating unique add button ids
    var removeButtonCounter = 0; // Counter for generating unique remove button ids

    $("#addValidity").on("click", function(e) {
        e.preventDefault(); 
        $("#validity_button").hide();
        addButtonCounter++;
        var addId = "addValidity" + addButtonCounter;

        var validityRow = $(".validityContainer:last").clone();
        
        var lastDate = validityRow.find("input[name='validity[]']").val();
        lastDate = new Date(lastDate);
        const nextDate = new Date(lastDate.getTime() + 24 * 60 * 60 * 1000);
        
        validityRow.find("input").val(""); // Clear input values in the cloned row
        validityRow.find("input[name='validity[]']").attr({
            id: "newDate",            
        });
        
        var removeButtonId = "removeValidity" + removeButtonCounter;
        const test = validityRow.append('<button id="' + removeButtonId + '" class="btn btn-danger removeValidity" style="position:absolute; right:-20px">-</button>');
        


        $(".validityContainer:last").after(validityRow);
        
        flatpickr("#newDate", {
            dateFormat: "Y-m-d",
            minDate: nextDate,
            enableTime: false, 
            allowInput:true
        });

    });

    // Use event delegation to handle the remove button click
    $(document).on("click", ".removeValidity", function() {
        $("#validity_button").show();
        $(this).closest('.row').remove();
    });
        // *************** logic for validity ends

    window.setTimeout(function() {
        $(".alert").fadeTo(2000, 0).slideUp(2000, function(){
            $(this).remove(); 
        });
    }, 2000);
</script>
@if(Session::get('success')) 
<script>
    
  $(document).ready(function () 
  {
    toastr.success('<?php echo Session::get('success');?>', 'Fast Lines Says', {timeOut: 2000})
  });
</script>
@endif
@endsection
