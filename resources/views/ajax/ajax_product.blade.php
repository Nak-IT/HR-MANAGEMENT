@extends('layout.layout')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">


<h2>List Products Info</h2>
<table id="table_id" class="table table-striped"></table>
<button type="button" id="btnadd" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add New</button>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Product Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form method="post" id="form">
                    <!-- name -->
                    <div class="form-group">
                        <label for="txtpname">Name:</label>
                        <input type="text" class="form-control" id="txtpname" placeholder="Enter Name" name="txtpname">
                    </div>

                    <!-- price -->
                    <div class="form-group">
                        <label for="txtprice">Price:</label>
                        <input type="text" class="form-control" id="txtprice" placeholder="Enter Price" name="txtprice">
                    </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnsave">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <form method="post" id="form">
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/jquery-3.4.1.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<!-- SweetAlert2 JS -->
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>



<script>

    /*------------displayData Function---------*/
    function displayData() {
        $.ajax({
            url: '{{ url("get_products") }}', // This is the correct URL that maps to the `getProducts` method in your JSONController
            type: 'GET',
            dataType: 'json',
            success: function (alldata) {
                var columns = [{ title: "id" }, { title: "name" }, { title: "price" }, { title: "option" }];
                var data = [];
                var option = '';
                var arr = alldata[0];
                for (var i in arr) {
                    option = "<input type='button' class='btn btn-info' value='Edit' data-toggle='modal' data-target='#myModal' onclick='editData(" + arr[i].id + ")'> | <input type='button' class='btn btn-danger' value='Delete' onclick='deleteData(" + arr[i].id + ")'>";
                    data.push([arr[i].id, arr[i].name, arr[i].price, option]);
                }
                $('#table_id').DataTable({
                    destroy: true,
                    data: data,
                    columns: columns
                });
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }

    /*-------------Query Load---------*/
    $(document).ready(function () {
        displayData();
    });

    /*---------AddNew Button-----------*/
    $("#btnadd").click(function() {
        $("#txtpname").val("");
        $("#txtprice").val("");
        $("#btnsave").text("Insert");
    });

    /*-------Save Button--------*/
    $("#btnsave").click(function() {
        var form_data = {
            "_token": "{{ csrf_token() }}",
            name: $('#txtpname').val(),
            price: $('#txtprice').val()
        };
        if ($("#btnsave").text() == "Insert") {
            // Insert
            $.ajax({
                type: 'POST',
                url: "{{ url('add_product') }}", // URL for the addProduct method
                data: form_data,
                dataType: 'json',
                success: function (data) {
					Swal.fire('Success', data['success'], 'success');
                    
                    displayData();
                    $('#myModal').modal('hide');
                },
                error: function (ex) {
					Swal.fire('Error', 'Failed to save data!', 'error');
                    console.log(ex.responseText);
                }
            });
        } else {
            var form_data = {
                "_token": "{{ csrf_token() }}",
                id: product_code,
                name: $('#txtpname').val(),
                price: $('#txtprice').val()
            };
            // Update
            $.ajax({
                type: 'POST',
                url: '{{ url('update_product') }}',
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    Swal.fire('Success', data['success'], 'success');
                    displayData();
                    $('#myModal').modal('hide');
                },
                error: function (ex) {
					Swal.fire('Error', 'Failed to update data!', 'error');
                    console.log(ex.responseText);
                }
            });
        }
    });

    var product_code;
    /*----------edit button----------*/
    function editData(id) {
        $("#btnsave").text("Update");
        product_code = id;
        $.ajax({
            url: 'getproduct_byid/' + id, // URL for the getById method
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#txtpname").val(data[0].name);
                $("#txtprice").val(data[0].price);
            },
            error: function (ex) {
				Swal.fire('Error', 'Failed to load data for editing!', 'error');
                console.log(ex.responseText);
            }
        });
    }

   /*------btndelete--------*/
   function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_product/' + id, // URL for deleteProduct method
                    data: { "_token": "{{ csrf_token() }}" },
                    dataType: 'json',
                    success: function (data) {
                        Swal.fire('Deleted!', data['success'], 'success');
                        displayData();
                    },
                    error: function (ex) {
                        Swal.fire('Error', 'Failed to delete data!', 'error');
                        console.log(ex.responseText);
                    }
                });
            }
        });
    }

</script>
@endsection
