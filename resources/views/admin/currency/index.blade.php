@extends('admin_layouts.master')
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
                    <form class="form form-horizontal" method="POST" action="{{route('admin.update_currency_conversion')}}">
                    @csrf
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-dollar"></i>Currency Conversion</h4>
                        <div class="row">
                            <span style="margin-left: 40px; color:green; padding-bottom:20px">Note: The rates are equivalent to SAR</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">1 SAR into USD</label>
                                    <div class="col-md-9">
                                    <input type="text" id="userinput1" class="form-control border-primary" placeholder="Dollar"
                                        name="sar_to_usd" value="{{$currency_conversion->sar_to_usd}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">1 SAR into PKR</label>
                                    <div class="col-md-9">
                                        <input type="text" id="userinput1" class="form-control border-primary" placeholder="SAR"
                                        name="sar_to_pkr" value="{{$currency_conversion->sar_to_pkr}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <h4 class=""><i class="la la-dollar"></i>Default Currency</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">USD</label>
                                    <div class="col-md-9">
                                    <input type="radio" id="userinput1" class="form-control border-primary"
                                        name="default_currency" value="usd" {{$currency_conversion->default_currency == 'usd' ? 'checked' : ''}} >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">SAR</label>
                                    <div class="col-md-9">
                                    <input type="radio" id="userinput1" class="form-control border-primary"
                                        name="default_currency" value="sar" {{$currency_conversion->default_currency == 'sar' ? 'checked' : ''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">PKR</label>
                                    <div class="col-md-9">
                                    <input type="radio" id="userinput1" class="form-control border-primary" placeholder="Dollar"
                                        name="default_currency" value="pkr" {{$currency_conversion->default_currency == 'pkr' ? 'checked' : ''}}>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
@if(Session::get('success')) 
<script>
  $(document).ready(function () 
  {
    toastr.success('<?php echo Session::get('success');?>', 'Fast Lines Says', {timeOut: 2000})
  });
</script>
@endif
@endsection