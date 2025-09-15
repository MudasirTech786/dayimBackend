@extends('admin_layouts.master')
@section('style')
@endsection
@section('content')
    <div class="content-header row"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collpase show">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Dayim Marketing!</b>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('products.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Add Products</h4>

                                {{-- Project Selector --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="name">Project</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="name" id="name"
                                                    required>
                                                    <option value="">Select Project</option>
                                                    <option value="DSA" {{ old('name') == 'DSA' ? 'selected' : '' }}>DSA
                                                    </option>
                                                    <option value="Dayim Living"
                                                        {{ old('name') == 'Dayim Living' ? 'selected' : '' }}>Dayim Living
                                                    </option>
                                                    <option value="Dayim Zindagi"
                                                        {{ old('name') == 'Dayim Zindagi' ? 'selected' : '' }}>Dayim Zindagi
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Dealer --}}
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="dealer">Dealer</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="dealer" id="dealer">
                                                <option value="">Select Dealer</option>
                                                @foreach ($dealers as $dealer)
                                                    <option value="{{ $dealer->name }}"
                                                        {{ old('dealer') == $dealer->name ? 'selected' : '' }}>
                                                        {{ $dealer->name }} ({{ $dealer->cnic }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sold & Purchased By --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="sold">Sold</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="sold" id="sold">
                                                    <option value="">Select Option</option>
                                                    <option value="Yes" {{ old('sold') == 'Yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="No" {{ old('sold') == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Reserved"
                                                        {{ old('sold') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="purchased_by">Purchased By</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="purchased_by"
                                                id="purchased_by">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->name }}"
                                                        {{ old('purchased_by') == $user->name ? 'selected' : '' }}>
                                                        {{ $user->name }} ({{ $user->cnic }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Dynamic Fields (DSA / Dayim Living) --}}
                                <div id="default-fields">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="title">Title</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control border-primary"
                                                        placeholder="Title" name="title" id="title"
                                                        value="{{ old('title') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 row">
                                            <label class="col-md-3 label-control" for="type">Type</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="type" id="type">
                                                    <option value="">Select Type</option>
                                                    <option value="Shop" {{ old('type') == 'Shop' ? 'selected' : '' }}>Shop
                                                    </option>
                                                    <option value="Office" {{ old('type') == 'Office' ? 'selected' : '' }}>
                                                        Office</option>
                                                    <option value="Apartment"
                                                        {{ old('type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Dynamic Fields (Dayim Zindagi) --}}
                                <div id="zindagi-fields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="category">Category</label>
                                                <div class="col-md-9">
                                                    <select class="form-control border-primary" name="category"
                                                        id="category">
                                                        <option value="">Select Category</option>
                                                        <option value="Commercial Outlets"
                                                            {{ old('category') == 'Commercial Outlets' ? 'selected' : '' }}>
                                                            Commercial Outlets / Offices</option>
                                                        <option value="Apartment"
                                                            {{ old('category') == 'Apartment' ? 'selected' : '' }}>Apartment
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 row">
                                            <label class="col-md-3 label-control" for="dz_type">Type</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="dz_type"
                                                    id="dz_type">
                                                    <option value="">Select Type</option>
                                                    <option value="Studio"
                                                        {{ old('dz_type') == 'Studio' ? 'selected' : '' }}>Studio</option>
                                                    <option value="One Bed"
                                                        {{ old('dz_type') == 'One Bed' ? 'selected' : '' }}>One Bed</option>
                                                    <option value="Two Bed"
                                                        {{ old('dz_type') == 'Two Bed' ? 'selected' : '' }}>Two Bed</option>
                                                    <option value="Outlet"
                                                        {{ old('dz_type') == 'Outlet' ? 'selected' : '' }}>Outlet</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sub Type (dynamic) --}}
                                    <div class="row" id="subtype-row" style="display:none;">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="subtype">Sub Type</label>
                                                <div class="col-md-9">
                                                    <select class="form-control border-primary" name="subtype"
                                                        id="subtype">
                                                        {{-- options filled by JS --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Floor & Size --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="floor">Floor</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="floor" id="floor"
                                                    required>
                                                    <option value="">Select Floor</option>
                                                    <option value="Lower Ground"
                                                        {{ old('floor') == 'Lower Ground' ? 'selected' : '' }}>Lower Ground
                                                    </option>
                                                    <option value="Ground" {{ old('floor') == 'Ground' ? 'selected' : '' }}>
                                                        Ground</option>
                                                    <option value="1st" {{ old('floor') == '1st' ? 'selected' : '' }}>1st
                                                    </option>
                                                    <option value="2nd" {{ old('floor') == '2nd' ? 'selected' : '' }}>2nd
                                                    </option>
                                                    <option value="3rd" {{ old('floor') == '3rd' ? 'selected' : '' }}>3rd
                                                    </option>
                                                    <option value="4th" {{ old('floor') == '4th' ? 'selected' : '' }}>4th
                                                    </option>
                                                    <option value="5th" {{ old('floor') == '5th' ? 'selected' : '' }}>5th
                                                    </option>
                                                    <option value="6th" {{ old('floor') == '6th' ? 'selected' : '' }}>6th
                                                    </option>
                                                    <option value="7th" {{ old('floor') == '7th' ? 'selected' : '' }}>7th
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="size">Size (sq.ft)</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control border-primary" placeholder="Size"
                                                name="size" id="size" value="{{ old('size') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Number & Image --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="number">Number</label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control border-primary"
                                                    placeholder="Number" name="number" id="number"
                                                    value="{{ old('number') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="image">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="image"
                                                id="image">
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const projectSelect = document.getElementById('name');
            const defaultFields = document.getElementById('default-fields');
            const zindagiFields = document.getElementById('zindagi-fields');
            const dzType = document.getElementById('dz_type');
            const subtypeRow = document.getElementById('subtype-row');
            const subtypeSelect = document.getElementById('subtype');

            const initialProject = @json(old('name'));
            const initialDzType = @json(old('dz_type'));
            const initialSubtype = @json(old('subtype'));

            function updateFormVisibility() {
                const val = projectSelect.value || '';
                if (val === 'Dayim Zindagi') {
                    defaultFields.style.display = 'none';
                    zindagiFields.style.display = 'block';
                } else if (val === 'DSA' || val === 'Dayim Living') {
                    defaultFields.style.display = 'block';
                    zindagiFields.style.display = 'none';
                } else {
                    defaultFields.style.display = 'block';
                    zindagiFields.style.display = 'none';
                }
            }

            const subtypeMap = {
                "Studio": ["Elite", "Royal"],
                "One Bed": ["Blue View", "Elite", "Royal"],
                "Two Bed": ["Twin Treat"],
                "Outlet": ["outlet"]
            };

            function updateSubtypeOptions(selectedType, preserveSelected = true) {
                subtypeSelect.innerHTML = '';
                if (!selectedType || !subtypeMap[selectedType]) {
                    subtypeRow.style.display = 'none';
                    return;
                }
                subtypeMap[selectedType].forEach(val => {
                    let o = document.createElement('option');
                    o.value = val;
                    o.text = val;
                    subtypeSelect.appendChild(o);
                });

                if (preserveSelected && initialSubtype) {
                    subtypeSelect.value = initialSubtype;
                }

                subtypeRow.style.display = 'block';
            }

            projectSelect.addEventListener('change', updateFormVisibility);
            dzType.addEventListener('change', function() {
                updateSubtypeOptions(this.value, false);
            });

            if (initialProject) {
                projectSelect.value = initialProject;
            }
            updateFormVisibility();

            if (initialDzType) {
                dzType.value = initialDzType;
                updateSubtypeOptions(initialDzType, true);
            } else if (dzType.value) {
                updateSubtypeOptions(dzType.value, false);
            }
        });
    </script>
@endsection
