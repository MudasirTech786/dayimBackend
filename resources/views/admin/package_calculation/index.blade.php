@extends('admin_layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
    <script src="{{ asset('app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#link_table').DataTable({
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 2]
                }],
                "bProcessing": true,
                "bServerSide": true,
                "aaSorting": [
                    [0, "desc"]
                ],
                "sPaginationType": "full_numbers",
                "sAjaxSource": "{{ url('/get_packages') }}",
                "aLengthMenu": [
                    [10, 50, 100, 500],
                    [10, 50, 100, 500]
                ]
            });
        });

        function deletePackage(id) {
            swal({
                    title: "Are you sure？",
                    text: "Do you want to delete this Package",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "No , Cancel please！",
                            value: null,
                            visible: true,
                            className: "",
                            closeModal: false,
                        },
                        confirm: {
                            text: "Yes、Delete！",
                            value: true,
                            visible: true,
                            className: "",
                            closeModal: false
                        }
                    }
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            method: "DELETE",
                            url: '{{ route('packages.destroy', ['package' => ':id']) }}'.replace(':id', id),
                            success: function(result) {
                                console.log(result)
                                if (result.status == "success") {
                                    $("#row_" + id).hide();
                                    swal("Success！", "Package has been deleted", "success");
                                }
                            }
                        })

                    } else {
                        swal("Error", "You are safe", "error");
                    }
                });

        }
    </script>
@endsection
@section('content')
    <div class="content-header row">
    </div>
    <div class="row">
        <div class="col-md-12">

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
                    <form class="form form-horizontal" method="POST" action="{{ route('admin.calculate_package') }}">
                        @csrf
                        <div class="form-body">
                            <h4 class="form-section"><i class="la la-hotel"></i>Hotel Selection</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">City</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="city[]" required>
                                                <option selected disabled="">Select City</option>
                                                <option value="Makkah">Makkah</option>
                                                <option value="Madina">Madina</option>
                                                <option value="Jeddah">Jeddah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="userinput2">Start Date</label>
                                        <div class="col-md-9">
                                            <input type="date" id="userinput1" class="form-control border-primary"
                                                placeholder="Start Date" name="start_date[]" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="userinput2">End Date</label>
                                        <div class="col-md-9">
                                            <input type="date" id="userinput1" class="form-control border-primary"
                                                placeholder="End Date" name="end_date[]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="userinput2">Room</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="room_id[]" required>
                                                <option selected disabled="">Select Room</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="userinput2">No of Adults</label>
                                        <div class="col-md-9">
                                            <input type="number" id="userinput1" class="form-control border-primary"
                                                placeholder="No of Adults" name="no_of_adults[]" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="userinput2">No of Children</label>
                                        <div class="col-md-9">
                                            <input type="number" id="userinput1" class="form-control border-primary"
                                                placeholder="No of Children" name="no_of_children[]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="special_offer_parent">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-primary specialOffer">
                                        Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h4 class="form-section"><i class="la la-car"></i>Transport Selection</h4>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Route</label>
                                <div class="col-md-9">
                                    <select class="form-control border-primary" name="route_id[]" required>
                                        <option selected disabled="">Select Route</option>
                                        @foreach ($routes as $route)
                                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Vehicle Qty</label>
                                    <div class="col-md-9">
                                        <input type="number" id="userinput1" class="form-control border-primary"
                                            placeholder="Vehicle Qty" name="no_of_vehicles[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Transport Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="transport_type_id[]" required>
                                            <option selected disabled="">Select Transport Type</option>
                                            @foreach ($transport_types as $transport_type)
                                                <option value="{{ $transport_type->id }}">{{ $transport_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="transport_parent">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-primary transportBtn">
                                        Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h4 class="form-section"><i class="la la-car"></i>Umrah Visa</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Visa Charges</label>
                                    <div class="col-md-9">
                                        <input type="number" id="userinput1" class="form-control border-primary"
                                            placeholder="Visa Charges" name="visa_charges" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Residence</label>
                                    <div class="col-md-9">
                                        <input type="text" id="userinput1" class="form-control border-primary"
                                            placeholder="Country of Residence" name="country_of_residence" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Nationality</label>
                                    <div class="col-md-9">
                                        <input type="text" id="userinput1" class="form-control border-primary"
                                            placeholder="Nationality" name="country_of_nationality" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-check-square-o"></i> Calculate Package
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
    <script type="text/javascript">
        window.setTimeout(function() {
                    @@ - 218, 118 + 146, 6 @@
                    function remove_transport(e) {
                        let targetvalue = e.target;
                        $(targetvalue).parent().parent().remove();
                    }
                    let add_special_offer = `<div class="special_offer">
                      <div class="row justify-content-between align-items-center">
                         <h4 class="border-0 my-2 pl-2"><i  class="la la-hotel"></i> Hotel Selection </h4>
                         <a href="#" class="btn btn-danger" onclick="remove_special_offer(event)">Remove</a>
                         </div>
                         <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control">City</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="city[]" required>  
                                            <option selected disabled="">Select City</option>
                                            <option value="Makkah">Makkah</option>
                                            <option value="Madina">Madina</option>
                                            <option value="Jeddah">Jeddah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Start Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="userinput1" class="form-control border-primary" placeholder="Start Date"
                                        name="start_date[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">End Date</label>
                                    <div class="col-md-9">
                                        <input type="date" id="userinput1" class="form-control border-primary" placeholder="End Date"
                                        name="end_date[]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Room</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="room_id[]" required>  
                                            <option selected disabled="">Select Room</option>
                                            @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">No of Adults</label>
                                    <div class="col-md-9">
                                        <input type="number" id="userinput1" class="form-control border-primary" placeholder="No of Adults"
                                        name="no_of_adults[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">No of Children</label>
                                    <div class="col-md-9">
                                        <input type="number" id="userinput1" class="form-control border-primary" placeholder="No of Children"
                                        name="no_of_children[]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    let add_transport = `<div class="new_transport">
                      <div class="row justify-content-between align-items-center">
                         <h4 class="border-0 my-2 pl-2"><i  class="la la-car"></i> Transport Selection </h4>
                         <a href="#" class="btn btn-danger" onclick="remove_transport(event)">Remove</a>
                         </div>
                         <div class="row">
                            <div class="form-group row">
                                <label class="col-md-3 label-control">Route</label>
                                <div class="col-md-9">
                                    <select class="form-control border-primary" name="route_id[]" required>  
                                        <option selected disabled="">Select Route</option>
                                        @foreach ($routes as $route)
                                        <option value="{{ $route->id }}">{{ $route->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Vehicle Qty</label>
                                    <div class="col-md-9">
                                        <input type="number" id="userinput1" class="form-control border-primary" placeholder="No of Adults"
                                        name="no_of_vehicles[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="userinput2">Transport Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control border-primary" name="transport_type_id[]" required>  
                                            <option selected disabled="">Select Transport Type</option>
                                            @foreach ($transport_types as $transport_type)
                                            <option value="{{ $transport_type->id }}">{{ $transport_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
    </script>
@endsection
