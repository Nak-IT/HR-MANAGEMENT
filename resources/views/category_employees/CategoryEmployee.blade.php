@extends('layout.layout')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">


<h2>បញ្ជីប្រភេទមន្ត្រីឬបុគ្គលិក</h2>
<table id="table_id" class="table table-striped"></table>
<button type="button" id="btnadd" class="btn btn-success" data-toggle="modal" data-target="#myModal">បន្ថែមប្រភេទមន្ត្រីឬបុគ្គលិកថ្មី</button>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ព័ត៌មានប្រភេទមន្ត្រីឬបុគ្គលិក</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form method="post" id="form">
                    <!-- Category Employee Name -->
                    <div class="form-group">
                        <label for="txtCategoryEmployeeName">ឈ្មោះប្រភេទមន្ត្រីឬបុគ្គលិក៖</label>
                        <input type="text" class="form-control" id="txtCategoryEmployeeName" placeholder="បញ្ចូលឈ្មោះប្រភេទមន្ត្រីឬបុគ្គលិក" name="txtCategoryEmployeeName">
                    </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnsave">រក្សាទុក</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">បិទ</button>
                </form>
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
            url: '{{ url("getCategoryEmployees") }}',
            type: 'GET',
            dataType: 'json',
            success: function (alldata) {
                var columns = [{ title: "លេខសម្គាល់ប្រភេទមន្ត្រីឬបុគ្គលិក" }, { title: "ឈ្មោះប្រភេទមន្ត្រីឬបុគ្គលិក" }, { title: "ជម្រើស" }];
                var data = [];
                var option = '';
                for (var i in alldata) {
                    option = "<input type='button' class='btn btn-info' value='កែប្រែ' data-toggle='modal' data-target='#myModal' onclick='editData(" + alldata[i].CategoryEmployeeID + ")'> | <input type='button' class='btn btn-danger' value='លុប' onclick='deleteData(" + alldata[i].CategoryEmployeeID + ")'>";
                    data.push([alldata[i].CategoryEmployeeID, alldata[i].CategoryEmployeeName, option]);
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
        $("#txtCategoryEmployeeName").val("");
        $("#btnsave").text("បញ្ចូល");
    });

    /*-------Save Button--------*/
    $("#btnsave").click(function() {
        var form_data = {
            "_token": "{{ csrf_token() }}",
            CategoryEmployeeName: $('#txtCategoryEmployeeName').val()
        };
        if ($("#btnsave").text() == "បញ្ចូល") {
            // Insert
            $.ajax({
                type: 'POST',
                url: "{{ url('addCategoryEmployee') }}",
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    Swal.fire('ជោគជ័យ', data['success'], 'success');
                    displayData();
                    $('#myModal').modal('hide');
                },
                error: function (ex) {
                    Swal.fire('បរាជ័យ', 'មិនអាចរក្សាទុកទិន្នន័យបានទេ!', 'error');
                    console.log(ex.responseText);
                }
            });
        } else {
            var form_data = {
                "_token": "{{ csrf_token() }}",
                id: category_employee_id,
                CategoryEmployeeName: $('#txtCategoryEmployeeName').val()
            };
            // Update
            $.ajax({
                type: 'PUT',
                url: '{{ url("updateCategoryEmployee") }}/' + category_employee_id,
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    Swal.fire('ជោគជ័យ', data['success'], 'success');
                    displayData();
                    $('#myModal').modal('hide');
                },
                error: function (ex) {
                    Swal.fire('បរាជ័យ', 'មិនអាចធ្វើបច្ចុប្បន្នភាពទិន្នន័យបានទេ!', 'error');
                    console.log(ex.responseText);
                }
            });
        }
    });

    var category_employee_id;
    /*----------edit button----------*/
    function editData(id) {
        $("#btnsave").text("ធ្វើបច្ចុប្បន្នភាព");
        category_employee_id = id;
        $.ajax({
            url: 'getById/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#txtCategoryEmployeeName").val(data.CategoryEmployeeName);
            },
            error: function (ex) {
                Swal.fire('បរាជ័យ', 'មិនអាចផ្ទុកទិន្នន័យសម្រាប់កែសម្រួលបានទេ!', 'error');
                console.log(ex.responseText);
            }
        });
    }

   /*------btndelete--------*/
   function deleteData(id) {
        Swal.fire({
            title: 'តើអ្នកប្រាកដទេ?',
            text: "អ្នកនឹងមិនអាចត្រឡប់វាមកវិញបានទេ!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'បាទ/ចាស លុបវា!',
            cancelButtonText: 'បោះបង់'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: 'deleteCategoryEmployee/' + id,
                    data: { "_token": "{{ csrf_token() }}" },
                    dataType: 'json',
                    success: function (data) {
                        Swal.fire('បានលុប!', data['success'], 'success');
                        displayData();
                    },
                    error: function (ex) {
                        Swal.fire('បរាជ័យ', 'មិនអាចលុបទិន្នន័យបានទេ!', 'error');
                        console.log(ex.responseText);
                    }
                });
            }
        });
    }

</script>
@endsection
