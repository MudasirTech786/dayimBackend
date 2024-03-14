@extends('admin_layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/selectize/selectize.css') }}">

    <script src="https://kit.fontawesome.com/d868f4cf6e.js" crossorigin="anonymous"></script>
    <style>
    .file-upload input[type='file'] {
        display: none; /* Hide the file input element */
    }

    .file-upload {
        display: inline-block;
        cursor: pointer;
        padding: 10px 15px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        border-radius: 5px;
        font-size: 16px;
        color: #333;
    }

    .remove-icon {
        display: inline-block;
        cursor: pointer;
        margin-left: 5px;
        font-size: 18px;
        color: #999;
    }

    .image-preview {
        width: 100px;
        height: 100px;
        margin-right: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        background-size: cover;
        background-position: center;
        display: inline-block;
    }
    </style>
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
                    <form class="form form-horizontal" method="POST" action="{{route('hotels.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-hotel"></i>Add Hotel</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control border-primary" placeholder="Name"
                                        name="name" required>
                                    </div>
                                </div>
                            </div>
                        	<div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Excerpt</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control border-primary" placeholder="Excerpt"
                                        name="excerpt" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Description</label>
                                    <div class="col-md-9">
                                        <textarea name="description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                        	<div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Google Map Iframe</label>
                                    <div class="col-md-9">
                                        <textarea name="google_map" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Note</label>
                                    <div class="col-md-9">
                                        <textarea name="note" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($rooms as $room)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-6 label-control" for="userinput3">Weekdays Price for <b>{{$room->name}} Room</b></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="hidden" name="room_id[]" value="{{$room->id}}" />
                                            <input name="weekdays_price[]" type="number" class="form-control" placeholder="Price for {{$room->name}} Room" aria-label="Amount (to the nearest dollar)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-6 label-control" for="userinput3">Weekend Price for <b> {{$room->name}} Room</b></label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input name="weekend_price[]" type="number" class="form-control" placeholder="Price for {{$room->name}} Room" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">City</label>
                                    <div class="col-md-9">
                                    <select class="form-control border-primary" name="city" required>  
                                            <option selected disabled="">Select City</option>
                                            <option value="makkah">Makkah</option>
                                            <option value="madinah">Madinah</option>
                                            <option value="jeddah">Jeddah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Validity</label>
                                    <div class="col-md-9">
                                        <!-- <input type="date" id="userinput1" class="form-control border-primary" placeholder="Validity"
                                        name="validity" required> -->
                                        <input type="text" name="validity" required id="datepicker" class="form-control border-primary" placeholder="Validity Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label for="imageUpload" class="file-upload">
                                    Select Images
                                    <input type="file" id="imageUpload" name="images[]" multiple>
                                </label>
                                <div id="imagePreviews"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="special_offer_parent">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-primary specialOffer">
                                    Add Any Special offer
                                </button>
                            </div>
                        </div>
                    </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-check-square-o"></i> Save
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
    flatpickr("#datepicker", {
      dateFormat: "Y-m-d",
      minDate: "today",
      enableTime: false, // set to true if you want to enable time selection
    });
</script>

<script type="text/javascript">
    document.getElementById('imageUpload').addEventListener('change', function() {
    const imagePreviews = document.getElementById('imagePreviews');
    imagePreviews.innerHTML = ''; // Clear previous previews

    const files = this.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(event) {
                const imagePreview = document.createElement('div');
                imagePreview.className = 'image-preview';
                imagePreview.style.backgroundImage = `url('${event.target.result}')`;
                
                const removeIcon = document.createElement('span');
                removeIcon.className = 'remove-icon';
                removeIcon.innerHTML = '&times;'; // Cross icon
                removeIcon.addEventListener('click', function() {
                    imagePreview.remove(); // Remove the image preview
                });

                imagePreview.appendChild(removeIcon);
                imagePreviews.appendChild(imagePreview);
            }

            reader.readAsDataURL(file);
        }
    }
});

</script>
<script type="text/javascript">
    window.setTimeout(function() {
        $(".alert").fadeTo(2000, 0).slideUp(2000, function(){
            $(this).remove(); 
        });
    }, 2000);
    $('.specialOffer').on('click',()=>{
        $('.special_offer_parent').append(add_special_offer);
        if($(".special_offer").length == 1){
            $('.specialOffer').fadeOut(1)
        }                               
    });
    function remove_special_offer(e){
        if($(".special_offer").length == 1){
            $('.specialOffer').fadeIn(1)
        }
        let targetvalue =e.target;
        $(targetvalue).parent().parent().remove();  
    }
    let add_special_offer = `<div class="special_offer">
                      <div class="row justify-content-between align-items-center">
                         <h4 class="border-0 my-2 pl-2"><i  class="la la-briefcase"></i> Special Offer </h4>
                         <i style="cursor:pointer; color:red;" onclick="remove_special_offer(event)" class="fas fa-times pr-2"></i>
                         </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput1">Offer Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="userinput1" class="form-control border-primary" placeholder="Offer Name"
                                        name="offer_name[]" required >
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">

                            <?php foreach($rooms as $room)
                                { 
                            ?>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Price for {{$room->name}} Bed</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                        
                                            <input name="rooms[{{ $room->id }}][]" type="number" class="form-control" placeholder="Enter Price" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                } 
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Start Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="userinput1" class="form-control border-primary" placeholder="Start Date"
                                        name="offer_start_date[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">End Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="userinput1" class="form-control border-primary" placeholder="Start Date"
                                        name="offer_end_date[]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
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