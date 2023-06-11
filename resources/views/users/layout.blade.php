<!DOCTYPE html>

<html>
<head>
<title>Laravel CRUD </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<style>
    .error{color: red;}
</style>
</head>
<body>
<div class="container">
@yield('content')
</div>
</body>
<script>
$(document).ready(function () {
    $('#user_form').validate({
    rules:{
      email: {
        required: true,
        email: true
      },
      name: {
        required: true,
        nowhitespace: true,
        lettersonly: true
      },
      gender: {
        required: true
      },
      mobile_number: {
        required: true,
        number: true,
        minlength: 10,
        maxlength: 10
      },
      dob:{
        required:true
      },
      age:{
        required:true,
        digits: true
      }
    },
    messages: {
      email: {
        required: 'Please enter an email address',
        email: 'Please enter a <i>valid</i> email address,'
      },
      name: {
        required: 'Please enter name'
      },
      gender: {
        required: 'Please enter gender'
      },
      dob: {
        required: 'Please enter DOB'
      },
      age: {
        required: 'Please enter age'
      },
      mobile_number:{
        required: 'Please enter a mobile number <b>(digits only)</b>',
        number: "Please enter a valid mobile number"
      }
    }

  }); //valdate end
    $('#dob').datepicker("setDate", new Date());
    $("body").on("click",".add-more",function(){
        var html = $(".after-add-more").first().clone();

        //  $(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");

          $(html).find(".change").html("<a class='btn btn-danger remove'>Remove</a>");


        $(".after-add-more").last().after(html);



    });

    $("body").on("click",".remove",function(){
        $(this).parents(".after-add-more").remove();
    });
});
$(document).ready(function () {
$('#example').DataTable();
/* When click New customer button */
$('#new-customer').click(function () {
$('#btn-save').val("create-customer");
$('#customer').trigger("reset");
$('#customerCrudModal').html("Add new user");
$('#crud-modal').modal('show');
});

/* Edit customer */
$('body').on('click', '#edit-customer', function () {
var customer_id = $(this).data('id');
$.get('user/'+customer_id+'/edit', function (data) {
    var data=data[0];
    // console.log(data);
$('#customerCrudModal').html("Edit User details");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal').modal('show');
$('#cust_id').val(data.id);
$('#name').val(data.name);
$('#email').val(data.email);
$('#mobile_number').val(data.mobile_number);
// $('#gender').val(data.gender);
if(data.gender=='m')
$("#male").prop("checked", true);
else
$("#female").prop("checked", true);

$('#dob').val(data.dob);
$('#age').val(data.age);
// console.log(JSON.parse(data.address));
var address=JSON.parse(data.address);
var html = $(".after-add-more").first().clone();

        //  $(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");

          $(html).find(".change").html("<a class='btn btn-danger remove'>Remove</a>");

for(let i=0;i<=JSON.parse(data.address).length;i++){
    $(".after-add-more").last().after(html);
    $('[name="address[]"]')[i].setAttribute("value", address[i].address);
    $('[name="city[]"]')[i].setAttribute("value", address[i].city);
    $('[name="state[]"]')[i].setAttribute("value", address[i].state);
    $('[name="pincode[]"]')[i].setAttribute("value", address[i].pincode);
    $('[name="address_id[]"]')[i].setAttribute("value", address[i].id);
}

document.custForm.btnsave.disabled=false
})
});


/* Delete user */
$('body').on('click', '#delete-customer', function () {
var customer_id = $(this).data("id");
var address_ids = $(this).data("address_ids");
var token = $("meta[name='csrf-token']").attr("content");
confirm("Are You sure want to delete !");

$.ajax({
type: "DELETE",
url: "{{ url('/user')}}/"+customer_id,
data: {
"id": customer_id,
"address_ids": address_ids,
"_token": token,
},
success: function (data) {
$('#msg').html('Customer entry deleted successfully');
$("#customer_id_" + customer_id).remove();
},
error: function (data) {
console.log('Error:', data);
}
});
});
});

</script>
</html>
