@extends('layout.layout') 

@section('content')

<link href="{{ asset('css/ModalDetail2.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">

<div class="row">
    <!-- <h2 class="custom-font006  text-centerModal "><br><br>អាប់ដែតឬធ្វើបច្ចុប្បន្នភាពស្ថានភាពបុគ្គលិក/មន្ត្រីសុខាភិបាល</h1> -->
</div> 

<style>
    .custom-font009A {
        font-family: 'khmer m1';
        font-size: 22px;
        font-weight: bold;
        color: black;
    }
    .custom-font009B {
        font-family: 'khmer m1';
        font-size: 18px;
        font-weight: bold;
        color: black;
    }
    .custom-font006A {
        font-family: 'khmer m1';
        font-size: 22px;
        font-weight: bold;
        color: red;
    }
    .form-check .item-number {
        margin-right: 5px;
        font-weight: bold;
        color: #007bff;
    }
</style>

<div class="container mt-1">

    @csrf
    <div class="row form-group custom-font009A text-center">
        <div class="col-sm-12">
            <label class="custom-font006A text-center">ចូរធីក✔️ដើម្បីអាប់ដែតឬធ្វើបច្ចុប្បន្នភាពស្ថានភាពបុគ្គលិក/មន្ត្រីសុខាភិបាល</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="employee_type" id="government_employed_doctor" value="government_employed_doctor" required>
                <label class="form-check-label" for="government_employed_doctor">
                    <span class="item-number">1.</span> មន្ត្រីសុខាភិបាលដែលជាប់ក្របខណ្ឌ
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="employee_type" id="hired_medical_officer" value="hired_medical_officer" required>
                <label class="form-check-label" for="hired_medical_officer">
                    <span class="item-number">2.</span> កិច្ចសន្យា ឬ​ ជួល និង ជាវេជ្ជសាស្ត្រ
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="employee_type" id="hired_not_medical_officer" value="hired_not_medical_officer" required>
                <label class="form-check-label" for="hired_not_medical_officer">
                    <span class="item-number">3.</span> កិច្ចសន្យា/​ជួល &មិនមែនវេជ្ជសាស្ត្រ
                </label>
            </div>
        </div>
    </div>
</div>

<!-- "Open Update Form" Button -->
<button type="button" class="btn btn-primary" id="openUpdateForm">
    Open Update Form
</button> 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title custom-font007 text-centerModal text3D" id="exampleModalLabel">បច្ចុប្បន្នភាពស្ថានភាពបុគ្គលិក</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-font010">
                <div class="row form-group">
                    <div class="col-sm-12 d-flex justify-content-center">
                        <img id="photoPreview" src="{{ asset('images/personal.png') }}" alt="រូបភាព..." style="width: 100px; height: auto;">
                    </div>
                    <div class="col-sm-12 d-flex  justify-content-center mt-2">
                        <span id="statusPreview" class=" custom-font009A">ស្ថានភាពចាស់ ៖ មិនទាន់មាន</span>
                    </div>
                </div>
                <form class="form-horizontal" id="statusUpdateForm">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="EmployeeID">បុគ្គលិក:</label>
                            <select id="EmployeeID" name="EmployeeID" class="form-control choices-single" placeholder="--select--" required>
                                <option value="">--ជ្រើសរើសបុគ្គលិក--</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="StatusID">ជ្រើសរើសស្ថានភាពថ្មី:</label>
                            <select id="StatusID" name="StatusID" class="form-control">
                                <option value="">--ជ្រើសរើស--</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="EndDate">ថ្ងៃចូលនិវត្តន៍/បញ្ចប់កិច្ចសន្យា:</label>
                            <input type="date" id="EndDate" name="EndDate" class="form-control" placeholder="មិនទាន់មានប្រាកដ">

                        </div>
                    </div>


                    
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" id="btnsave" value="បច្ចុប្បន្នភាព" class="btn btn-primary clickable3" onclick="updateStatus()" />
                <button type="button" class="btn btn-secondary clickable3" data-bs-dismiss="modal">បិទ</button>
            </div>
        </div>
    </div>
</div>


<table id="employeeTable" class="table table-striped table-bordered" style="width:100%">
   
</table>


<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">

<script>
    var dropdownEmployeeID = new Choices(document.querySelector("#EmployeeID"));
    var dropdownStatusID = new Choices(document.querySelector("#StatusID"));
    $('#myModal').on('hidden.bs.modal', function () {
    $('#EndDate').val('');
});

    $(document).ready(function () {
     
        var table = $('#employeeTable').DataTable({
            columns: [
                { data: 'EmployeeID', title: 'ID' },
                { data: 'Emp_as_khmerID', title: 'អត្តលេខ' },
                { data: 'EmployeeCode', title: 'អត្តលេខមន្ត្រីក្របខណ្ឌ', defaultContent: '' },
                {
                    data: null,
                    title: 'ឈ្មោះពេញ', 
                    render: function (data, type, row) {
                        return row.FirstName + ' ' + row.LastName;
                    }
                },
                { data: 'Gender', title: 'ភេទ' },
                { data: 'DepartmentName', title: 'ឯកទេស' },
                { data: 'SkillName', title: 'កម្រិតជំនាញ', defaultContent: '' },
                
       
                { data: 'StatusName', title: 'ស្ថានភាព' },
                { data: 'Photo', title: 'រូបភាព',
                    render: function (data, type, row) {
                        var photoUrl = row.Photo ? "{{ asset('') }}" + row.Photo : "/images/error.png";
                        return '<img src="' + photoUrl + '" alt="រូបភាព" style="width: 50px; height: auto;">';
                    }
                },
                {
                    data: null,
                    title: 'សកម្មភាព',
                    render: function (data, type, row) {
                        return '<button class="btn btn-primary btn-sm edit-status" data-employee-id="' + row.EmployeeID + '" data-employee-type="' + row.EmployeeType + '">កែប្រែ</button>';
                    }
                }
            ]
        });

   
        fetchStatuses();

   
        $('input[name="employee_type"]').on('change', function () {
            let employeeType = $(this).val();
            if (employeeType) {
                fetchEmployees(employeeType, table);
                fetchEmployeeOptions(employeeType);
            } else {
                table.clear().draw();
                dropdownEmployeeID.clearChoices();
                dropdownEmployeeID.setChoices([{
                    value: '',
                    label: '--ជ្រើសរើសបុគ្គលិក--',
                    selected: true,
                    disabled: true
                }]);
            }
        });

        
        $('#employeeTable').on('click', '.edit-status', function () {
            var employeeId = $(this).data('employee-id');
            var employeeType = $(this).data('employee-type');
            

            console.log('Edit button clicked:', employeeId, employeeType);

            editEmployee(employeeId, employeeType);
        });

        
        $('#openUpdateForm').on('click', function () {
            var employeeType = $('input[name="employee_type"]:checked').val();
            if (!employeeType) {
                Swal.fire({
                    icon: 'warning',
                    title: 'សូមជ្រើសរើសប្រភេទបុគ្គលិក',
                    text: 'សូមជ្រើសរើសប្រភេទបុគ្គលិកមុនពេលបើកបែបបទអាប់ដែត។',
                    confirmButtonText: 'យល់ព្រម'
                });
                return;
            }

           
            fetchEmployeeOptions(employeeType, function() {
             
                dropdownEmployeeID.setChoiceByValue('');
                dropdownStatusID.setChoiceByValue('');
                $('#photoPreview').attr('src', '{{ asset("images/personal.png") }}');
                $('#statusPreview').text('ស្ថានភាព៖ មិនទាន់មាន');
                $('#EndDate').val('');
               
                $('#myModal').modal('show');
            });
        });

      
        $(document).on('change', '#EmployeeID', function() {
            var employeeId = $(this).val();
            var employeeType = $('input[name="employee_type"]:checked').val();

           
            updatePhotoPreview(employeeId, employeeType);

           
            if (employeeId && employeeType) {
                $.ajax({
                    url: '{{ route("get.employee.status") }}',
                    type: 'GET',
                    data: { EmployeeID: employeeId, employee_type: employeeType },
                    success: function (response) {
                        if (response.StatusID) {
                            $('#statusPreview').text('ស្ថានភាពចាស់ ៖ ' + response.StatusName);
                            dropdownStatusID.setChoiceByValue(response.StatusID.toString());
                        } else {
                            $('#statusPreview').text('ស្ថានភាពចាស់ ៖ មិនទាន់មាន');
                        }
                       
                        if (response.EndDate) {
                            $('#EndDate').val(response.EndDate);
                        } else {
                            $('#EndDate').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#statusPreview').text('ស្ថានភាពចាស់ ៖ មិនទាន់មាន');
                        $('#EndDate').val('');
                    }
                });
            } else {
                $('#statusPreview').text('ស្ថានភាពចាស់ ៖ មិនទាន់មាន');
                $('#EndDate').val('');
            }
        });
    });

    function editEmployee(employeeId, employeeType) {
        console.log('editEmployee called with:', employeeId, employeeType);
        if (!employeeId || !employeeType) {
            console.error('Employee ID or Type is undefined');
            Swal.fire({
                icon: 'error',
                title: 'មានបញ្ហា',
                text: 'មិនអាចរកឃើញលេខសម្គាល់បុគ្គលិក ឬ ប្រភេទបុគ្គលិក។ សូមព្យាយាមម្តងទៀត។',
                confirmButtonText: 'យល់ព្រម'
            });
            return;
        }

        
        $('input[name="employee_type"][value="' + employeeType + '"]').prop('checked', true);

       
        fetchEmployeeOptions(employeeType, function() {
           
            dropdownEmployeeID.setChoiceByValue(employeeId.toString());

         
            var selectedEmployee = dropdownEmployeeID.getValue(true);
            if (selectedEmployee !== employeeId.toString()) {
                console.error('Employee not found in dropdown:', employeeId);
                Swal.fire({
                    icon: 'error',
                    title: 'មានបញ្ហា',
                    text: 'មិនអាចរកឃើញបុគ្គលិក។ សូមព្យាយាមម្តងទៀត។',
                    confirmButtonText: 'យល់ព្រម'
                });
                return;
            }

          
            updatePhotoPreview(employeeId, employeeType);

           
            $.ajax({
                url: '{{ route("get.employee.status") }}',
                type: 'GET',
                data: { EmployeeID: employeeId, employee_type: employeeType },
                success: function (response) {
                    if (response.StatusID) {
                        dropdownStatusID.setChoiceByValue(response.StatusID.toString());
                       
                        $('#statusPreview').text('ស្ថានភាពចាស់ ៖ ' + response.StatusName);
                    } else {
                        $('#statusPreview').text('ស្ថានភាពចាស់ ៖ មិនទាន់មាន');
                    }
                   
                    if (response.EndDate) {
                        $('#EndDate').val(response.EndDate);
                    } else {
                        $('#EndDate').val('');
                    }
                   
                    $('#myModal').modal('show');
                },
                error: function (xhr, status, error) {
                    let err = xhr.responseJSON;
                    $('#statusPreview').text('ស្ថានភាពចាស់ ៖ មិនទាន់មាន');
                    Swal.fire({
                        icon: 'error',
                        title: 'មានបញ្ហា',
                        text: err.error || 'មានបញ្ហាកើតឡើងពេលទាញយកស្ថានភាពបុគ្គលិក។ សូមព្យាយាមម្តងទៀត។',
                        confirmButtonText: 'យល់ព្រម'
                    });
                }
            });
        });
    }

    function fetchStatuses() {
        $.ajax({
            url: '{{ route("get.statuses") }}',
            type: 'GET',
            success: function (response) {
                dropdownStatusID.clearChoices();
                dropdownStatusID.setChoices([{
                    value: '',
                    label: '--ជ្រើសរើស--',
                    selected: true,
                    disabled: true
                }]);
                response.forEach(function (status) {
                    dropdownStatusID.setChoices([{
                        value: status.StatusID.toString(),
                        label: status.StatusName
                    }], 'value', 'label', false);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching statuses:', error);
            }
        });
    }

    

    function fetchEmployees(employeeType, table) {
        $.ajax({
            url: '{{ route("filter.employees") }}',
            type: 'GET',
            data: { employee_type: employeeType },
            success: function (response) {
                table.clear();

             
                if (employeeType === 'government_employed_doctor') {
                    table.columns([0, 1, 2, 3, 4, 5, 6, 7, 8]).visible(true);
                    table.columns([6]).visible(false);
                    
                }
                else if (employeeType === 'hired_not_medical_officer') {
                    table.columns([0, 1, 3, 4, 5, 6, 7, 8]).visible(true);
                    table.columns([2, 5]).visible(false);
                }
                else {
                    table.columns([0, 1, 3, 4, 5, 6, 7, 8]).visible(true);
                    table.columns([2,6]).visible(false);
                }

                
                response.employees.forEach(function (employee) {
                    var rowData = {
                        EmployeeID: employee.EmployeeID || '',
                        Emp_as_khmerID: employee.Emp_as_khmerID || '',
                        EmployeeCode: employee.EmployeeCode || '',
                        Gender: employee.Gender || '',
                        FirstName: employee.FirstName || '',
                        LastName: employee.LastName || '',
                        StatusName: employee.StatusName || '',
                        DepartmentName: employee.DepartmentName || '',
                        SkillName: employee.SkillName || '',
                        Photo: employee.Photo || '',
                        NationalID: employee.NationalID || '',
                        EmployeeType: employeeType 
                    };

                    table.row.add(rowData);
                });

                table.draw();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching employees:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'មានបញ្ហា',
                    text: 'មិនអាចទាញយកទិន្នន័យបុគ្គលិកបាន។ សូមព្យាយាមម្តងទៀត។',
                    confirmButtonText: 'យល់ព្រម'
                });
            }
        });
    }

    function fetchEmployeeOptions(employeeType, callback) {
        $.ajax({
            url: '{{ route("get.employees") }}',
            type: 'GET',
            data: { employee_type: employeeType },
            success: function (response) {
                dropdownEmployeeID.clearChoices();
                dropdownEmployeeID.setChoices([{
                    value: '',
                    label: '--ជ្រើសរើសបុគ្គលិក--',
                    selected: true,
                    disabled: true
                }]);
                response.forEach(function (employee) {
                    let label = 'ឈ្មោះ ៖ ' + employee.FirstName + ' ' + employee.LastName + ' អត្តលេខ ៖ ' + employee.Emp_as_khmerID;
                    if (employeeType === 'government_employed_doctor' && employee.EmployeeCode) {
                        label += ' អត្តលេខមន្ត្រីក្របខណ្ឌ ៖ ' + employee.EmployeeCode;
                    }
                    dropdownEmployeeID.setChoices([{
                        value: employee.EmployeeID.toString(),
                        label: label
                    }], 'value', 'label', false);
                });
                if (callback) callback();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching employee options:', error);
                if (callback) callback();
            }
        });
    }

    function updatePhotoPreview(employeeId, employeeType) {
        if (employeeId && employeeType) {
            $.ajax({
                type: "GET",
                url: getEmployeePhotoUrl(employeeId, employeeType),
                success: function (data) {
                    if (data && data.photo) {
                        var photoPath = "{{ asset('') }}" + data.photo;
                        $('#photoPreview').attr('src', photoPath);
                    } else {
                        $('#photoPreview').attr('src', '{{ asset("images/error.png") }}');
                    }
                },
                error: function () {
                    $('#photoPreview').attr('src', '{{ asset("images/error.png") }}');
                }
            });
        } else {
            $('#photoPreview').attr('src', '{{ asset("images/personal.png") }}');
        }
    }

    function getEmployeePhotoUrl(employeeId, employeeType) {
        var url = '';

        if (employeeType === 'government_employed_doctor') {
            url = "{{ route('government_employed_doctors.getEmployeePhoto', ['id' => ':id']) }}".replace(':id', employeeId);
        } else if (employeeType === 'hired_medical_officer') {
            url = "{{ route('hired_medical_officers.getEmployeePhoto', ['id' => ':id']) }}".replace(':id', employeeId);
        } else if (employeeType === 'hired_not_medical_officer') {
            url = "{{ route('hired_not_medical_officers.getEmployeePhoto', ['id' => ':id']) }}".replace(':id', employeeId);
        }

        return url;
    }

    function updateStatus() {
    let employeeType = $('input[name="employee_type"]:checked').val();
    let employeeId = dropdownEmployeeID.getValue(true);
    let statusId = dropdownStatusID.getValue(true);
    let endDate = $('#EndDate').val(); 

    $.ajax({
        url: '{{ route("update.status") }}',
        type: 'POST',
        data: {
            employee_type: employeeType,
            EmployeeID: employeeId,
            StatusID: statusId,
            EndDate: endDate,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'បានជោគជ័យ',
                text: response.message,
                confirmButtonText: 'យល់ព្រម'
            });
            $('#myModal').modal('hide');
          
            fetchEmployees(employeeType, $('#employeeTable').DataTable());
        },
        error: function (xhr, status, error) {
            let err = xhr.responseJSON;
            Swal.fire({
                icon: 'error',
                title: 'មានបញ្ហា',
                text: err.error || 'មានបញ្ហាកើតឡើង។ សូមព្យាយាមម្តងទៀត។',
                confirmButtonText: 'យល់ព្រម'
            });
        }
    });
}

</script>

@endsection
