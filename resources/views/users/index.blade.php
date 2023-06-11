@extends('users.layout')
@section('content')
<div class="row">
<div class="col-lg-12" style="text-align: center">
<div >
<h2>test demo</h2>
</div>
<br/>
</div>
</div>
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-right">
<a href="javascript:void(0)" class="btn btn-success mb-2" id="new-customer" data-toggle="modal">Add New User</a>
</div>
</div>
</div>
<br/>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p id="msg">{{ $message }}</p>
</div>
@endif
<table class="table table-bordered" id="example">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile No.</th>
<th>gender</th>
<th>DOB</th>
<th>Age</th>
<th>Address</th>
<th width="280px">Action</th>
</tr>
</thead>
<tbody>
@foreach ($datas as $customer)
<tr id="customer_id_{{ $customer->id }}">
<td>{{ $customer->id }}</td>
<td>{{ $customer->name }}</td>
<td>{{ $customer->email }}</td>
<td>{{ $customer->mobile_number }}</td>
<td>{{ $customer->gender }}</td>
<td>{{ $customer->dob }}</td>
<td>{{ $customer->age }}</td>
<td>
    {{-- {{dd(json_encode(array_column(json_decode($customer->address), 'id')))}} --}}
    @foreach (json_decode($customer->address) as $key => $member)
    <strong>Address {{$key+1}}:</strong> {{ $member->address }},{{$member->city}},{{$member->state}}-{{$member->pincode}}<br>
    @endforeach
</td>
<td>
<form action="{{ route('user.destroy',$customer->id) }}" method="POST">

<a href="javascript:void(0)" class="btn btn-success" id="edit-customer" data-toggle="modal" data-id="{{ $customer->id }}">Edit </a>
<meta name="csrf-token" content="{{ csrf_token() }}">
<a id="delete-customer" data-id="{{ $customer->id }}" data-address_ids="{{json_encode(array_column(json_decode($customer->address), 'id'))}}" class="btn btn-danger delete-user">Delete</a>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
<!-- Add and Edit user modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title" id="customerCrudModal"></h4>
    </div>
    <div class="modal-body">
    <form id="user_form" name="custForm" action="{{ route('user.store') }}" method="POST">
    <input type="hidden" name="cust_id" id="cust_id" >
    @csrf
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Name:</strong>
    <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="validate()" >
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Email:</strong>
    <input type="email" name="email" id="email" class="form-control" placeholder="Email" onchange="validate()">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Mobile Number:</strong>
    <input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Mobile Number" onchange="validate()" onkeypress="validate()">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Gender:</strong>
    <input type="radio" name="gender" id="male" value="m" onchange="validate()" onkeypress="validate()">Male
    <input type="radio" name="gender" id="female" value="f" onchange="validate()" onkeypress="validate()">Female
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>DOB:</strong>
    <input type="text" name="dob" id="dob" class="form-control" placeholder="DOB" data-date-format="dd/mm/yyyy" onchange="validate()" onkeypress="validate()">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Age:</strong>
    <input type="text" name="age" id="age" class="form-control" placeholder="Age" onchange="validate()" onkeypress="validate()">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Address Information:</strong>

    </div>
    </div>
    <div class="row after-add-more">

        <div class="col-md-3">
                <input type="text" name="address[]" class="form-control" placeholder="Address">
                <input type="hidden" name="address_id[]" id="address_id" >
        </div>
        <div class="col-md-3">
                <input type="text" name="city[]" class="form-control" placeholder="City" >
        </div>
        <div class="col-md-2">
                <input type="text" name="state[]" id="state" class="form-control" placeholder="State" >
        </div>
        <div class="col-md-2">
                <input type="text" name="pincode[]" id="pincode" class="form-control" placeholder="Pin Code" >
        </div>
        <div class="col-md-2">
            <div class="form-group change" >
                <a class="btn btn-success add-more">Add</a>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Submit</button>
    <a href="{{ route('user.index') }}" class="btn btn-danger">Cancel</a>
    </div>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>

@endsection
<script>
error=false

function validate()
{
	if(document.custForm.name.value !='' && document.custForm.email.value !='' && document.custForm.mobile_number.value !=''&& document.custForm.gender.value !=''&& document.custForm.age.value !='' && document.custForm.dob.value !='')
	    document.custForm.btnsave.disabled=false
	else
		document.custForm.btnsave.disabled=true
}
</script>
