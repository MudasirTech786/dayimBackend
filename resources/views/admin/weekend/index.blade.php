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
                    <form class="form form-horizontal" method="POST" action="{{route('weekends.store')}}">
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-hotel"></i>Add Weekend Days</h4>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">Select Weekend days</label>
                                    <div class="col-md-9">
                                        @foreach($weekdays as $day)
                                        <label>
                                            <input type="checkbox" name="weekends[]" value="{{$day}}" {{ in_array($day, $weekend) ? 'checked' : '' }}> {{$day}}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
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

<script type="text/javascript">
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
