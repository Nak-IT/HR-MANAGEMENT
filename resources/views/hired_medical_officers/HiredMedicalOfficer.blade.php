@extends('layout.layout')

@section('content')

<link href="{{ asset('css/ModalDetail2.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">

<h2 class="custom-font006 "><br><br>បញ្ជីបញ្ចូលព័ត៌មាន មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ</h2>
<table id="table_data" class="table table-striped table-bordered"></table>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal" onclick="addNew()">បញ្ជូលថ្មីបន្ថែម</button>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title custom-font007 text-centerModal text3D" id="exampleModalLabel">បញ្ចូលព័ត៌មាន មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12 d-flex justify-content-center">
                        <img id="photoPreview" src="{{ asset('images/personal.png') }}" alt="រូបភាព..." style="width: 100px; height: auto;">
                    </div>
                </div>
                <form class="form-horizontal" id="hiredMedicalOfficerForm">
                    @csrf
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="EmployeeID">បុគ្គលិក ឬ មន្ត្រីរាជការ</label>
                            <select id="EmployeeID" name="EmployeeID" class="form-control choices-single" placeholder="--select--" data-trigger onchange="updatePhotoPreview()">
                                <option value="">--ជ្រើសរើសបុគ្គលិក--</option>
                                @if (isset($employees) && $employees->count() > 0)
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->EmployeeID }}">ឈ្មោះ ៖ {{ $employee->FirstName }} {{ $employee->LastName }} អត្តលេខ ៖ {{ $employee->Emp_as_khmerID }} ទូរស័ព្ទ ៖{{ $employee->Phone }} ភេទ ៖{{ $employee->Gender }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label for="StartDate">ថ្ងៃចូលបម្រើការងារ</label>
                            <input type="date" id="StartDate" name="StartDate" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label for="CurrentPositionDate">ថ្ងៃ​ខែឆ្នាំកាន់តំណែង</label>
                            <input type="date" id="CurrentPositionDate" name="CurrentPositionDate" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label for="EndDate">ថ្ងៃឆ្នាំបញ្ចប់កិច្ចសន្យា/ការងារ</label>
                            <input type="date" id="EndDate" name="EndDate" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label for="PositionID">មុខតំណែងបច្ចុប្បន្ន</label>
                            <select id="PositionID" name="PositionID" class="form-control">
                                <option value="">--ជ្រើសរើស--</option>
                                @if(isset($positions))
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->PositionID }}">{{ $position->PositionName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label for="Institution">អង្គភាព/ស្ថាប័ន</label>
                            <input id="Institution" name="Institution" class="form-control" value="មន្ទីរពេទ្យបង្អែកបាត់ដំបង" readonly />
                        </div>
                        <div class="col-sm-4">
                            <label for="DepartmentID">ជំនាញ/ឯកទេស</label>
                            <select id="DepartmentID" name="DepartmentID" class="form-control">
                                <option value="">--ជ្រើសរើស--</option>
                                @if(isset($departments) && is_iterable($departments))
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->DepartmentID }}">{{ $department->DepartmentName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="BuildingID">អាគារសុខាភិបាល</label>
                            <select class="form-control" id="BuildingID" name="BuildingID">
                                <option value="">--ជ្រើសរើស--</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->BuildingID }}">{{ $building->BuildingName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label for="CategoryEmployeeID">ប្រភេទបុគ្គលិក</label>
                            <select id="CategoryEmployeeID" name="CategoryEmployeeID" class="form-control">
                                <option value="">--ជ្រើសរើស--</option>
                                @if(isset($categoryEmployees))
                                    @foreach ($categoryEmployees as $category)
                                        <option value="{{ $category->CategoryEmployeeID }}">{{ $category->CategoryEmployeeName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="StatusID">ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល</label>
                            <select id="StatusID" name="StatusID" class="form-control">
                                <option value="">--ជ្រើសរើស--</option>
                                @if(isset($statuses) && is_iterable($statuses))
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->StatusID }}">{{ $status->StatusName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" id="btnsave" value="បញ្ជូល" class="btn btn-primary clickable3" onclick="saveData()" />
                <button type="button" class="btn btn-secondary clickable3" data-bs-dismiss="modal">បិទ</button>
            </div>
        </div>
    </div>
</div>

<div id="detailsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title custom-font007 text-centerModal text3D">មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mb-4">
                    <img id="detailPhotoUrl" src="" alt="Employee Photo" class="rounded-circle" style="width: 100px; height: 100px;">
                </div>
                <div class="details-info custom-font010">
                    
                    <div class="row">
                        <div class="col-md-6">
                      
                            <p><strong class="custom-font009">អត្តលេខ៖</strong> <span id="detailEmployeeID"></span></p>
                            <p><strong class="custom-font009">គោត្តនាម និងនាម៖</strong> <span id="detailFullName"></span></p>
                            <p><strong class="custom-font009">ឈ្មោះជាអក្សរឡាតាំង៖</strong> <span id="detailLatinName"></span></p>
                            <p><strong class="custom-font009">ភេទ៖</strong> <span id="detailGender"></span></p>
                            <p><strong class="custom-font009">ថ្ងៃខែឆ្នាំកំណើត៖</strong> <span id="detailDateOfBirth"></span></p>
                            <p><strong class="custom-font009">សញ្ជាតិ៖</strong> <span id="detailNationality"></span></p>
                            <p><strong class="custom-font009">លេខទូរសព្ទ៖</strong> <span id="detailPhone"></span></p>
                            <h6><strong class="custom-font009">ទីកន្លែងកំណើត៖</strong></h6>
                            <p class="ml-3"><span id="detailFullBirthPlace"></span></p>
                            <h6><strong class="custom-font009">អាសយដ្ឋានបច្ចុប្បន្ន៖</strong></h6>
                            <p class="ml-3"><span id="detailFullAddress"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p class="custom-font009">កិច្ចសន្យា​ឬមន្ត្រីជួល</p>
                            <p><strong class="custom-font009">ថ្ងៃចូលបម្រើការងារ៖</strong> <span id="detailStartDate"></span></p>
                            <p><strong class="custom-font009">ថ្ងៃ​ខែឆ្នាំកាន់តួនាទី/តំណែង៖</strong> <span id="detailCurrentPositionDate"></span></p>
                            <p><strong class="custom-font009">ប្រភេទបុគ្គលិក៖</strong> <span id="detailCategoryEmployeeName"></span></p>
                            <p><strong class="custom-font009">អង្គភាព/ស្ថាប័ន៖</strong> <span id="detailInstitution"></span></p>
                            <p><strong class="custom-font009">តួនាទី/មុខតំណែងបច្ចុប្បន្ន៖</strong> <span id="detailPositionName"></span></p>
                            <p><strong class="custom-font009">ឯកទេស៖</strong> <span id="detailDepartmentName"></span></p>
                            <p><strong class="custom-font009">អាគារសុខាភិបាល៖</strong> <span id="detailBuildingName"></span></p>
                            <p><strong class="custom-font009">ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល៖</strong> <span id="detailStatusName"></span></p>
                        </div>
          
                        <div class="col-md-4">
                            <p class="custom-font009">ព័ត៌មានអត្តសញ្ញាណក្របខណ្ឌ</p>
                            <p><strong class="custom-font009">អត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ៖</strong> <span id="detailNationalID"></span></p>
                            <p><strong class="custom-font009">លេខសម្គាល់ចំនួនមន្ត្រីរាជការ៖</strong> <span id="detailCivilServantID"></span></p>
                            <p><strong class="custom-font009">អត្តលេខមន្ត្រីក្របខណ្ឌ៖</strong> <span id="detailEmployeeCode"></span></p>
                            <p class="custom-font009">ព័ត៌មានកម្រិតវប្បធម៌</p>
                            <p><strong class="custom-font009">កម្រិតការអប់រំ៖</strong> <span id="detailEducationLevel"></span></p>
                            <p><strong class="custom-font009">ប្រទេស៖</strong> <span id="detailCountry"></span></p>
                            <p><strong class="custom-font009">សាលា៖</strong> <span id="detailSchool"></span></p>
                            <p><strong class="custom-font009">សញ្ញាបត្រ៖</strong> <span id="detailDegree"></span></p>
                            <p><strong class="custom-font009">កាលបរិច្ឆេទចាប់ផ្តើម៖</strong> <span id="detailEducationStartDate"></span></p>
                            <p><strong class="custom-font009">កាលបរិច្ឆេទបញ្ចប់៖</strong> <span id="detailEducationEndDate"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-font006" data-bs-dismiss="modal">បិទ</button>
                <button onclick="printEmployeeDetails()" class="btn btn-primary">បោះពុម្ព</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">

<script>
    
function updatePhotoPreview() {
    var selectedEmployeeId = $('#EmployeeID').val();

    if (selectedEmployeeId) {
        $.ajax({
            type: "GET",
            url: "{{ route('hired_medical_officers.getEmployeePhoto', ['id' => ':id']) }}".replace(':id', selectedEmployeeId),
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

var dropdownEmployeeID = new Choices(document.querySelector("#EmployeeID"));
var dropdownDepartmentID = new Choices(document.querySelector("#DepartmentID"));
var dropdownPositionID = new Choices(document.querySelector("#PositionID"));
var dropdownBuildingID = new Choices(document.querySelector("#BuildingID"));
var dropdownStatusID = new Choices(document.querySelector("#StatusID"));
var dropdownCategoryEmployeeID = new Choices(document.querySelector("#CategoryEmployeeID"));

$(document).ready(function () {
    showData();
    dropdownEmployeeID.passedElement.element.addEventListener('change', function(event) {
        updatePhotoPreview();
    });

    if ($('#EmployeeID').val()) {
        updatePhotoPreview();
    }
});

function showData() {
    $.ajax({
        type: "GET",
        url: "{{ route('hired_medical_officers.getAllData') }}",
        dataType: 'json',
        success: function (alldata) {
            var columns = [
                { title: "<span class='custom-font009'>បុគ្គលិកឬមន្ត្រី</span>" },
                { title: "<span class='custom-font009'>ប្រភេទ</span>" },
                { title: "<span class='custom-font009'>កាលបរិច្ឆេទ</span>" },
                { title: "<span class='custom-font009'>តួនាទីនិងអង្គភាព</span>" },
                { title: "<span class='custom-font009'>ជំនាញ/ឯកទេស</span>" },
                { title: "<span class='custom-font009'>រូបភាព</span>" },
                { title: "<span class='custom-font009'>Options</span>" }
            ];

            var data = [];
            for (var i in alldata) {
                var photoPath = "{{ asset('') }}" + alldata[i].Photo;
                var photoUrl = alldata[i].Photo ? photoPath + "?v=" + new Date().getTime() : "{{ asset('images/error.png') }}";
                var employeeInfo =
                    "✍️" + "<span class='custom-font010'>គោត្តនាម និងនាម៖ </span>" + "<br>" + "👉" + (alldata[i].FirstName || "") + " " + (alldata[i].LastName || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>អត្តលេខ ៖ </span>" + "<br>" + "👉" + (alldata[i].Emp_as_khmerID || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>ភេទ ៖ </span>" + "<br>" + "👉" + (alldata[i].Gender || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>ទូរស័ព្ទ ៖ </span>" + "<br>" + "👉" + (alldata[i].Phone || "");

                var formattedStartDate = formatKhmerDate(alldata[i].StartDate);
                var formattedCurrentPositionDate = formatKhmerDate(alldata[i].CurrentPositionDate);
                var formattedEndDate = formatKhmerDate(alldata[i].EndDate);

                var DateInfo =
                    "✍️" + "<span class='custom-font010'>ថ្ងៃចូលបម្រើការងារ ៖ </span>" + "<br>" + "👉" + (formattedStartDate) + "<br>" +
                    "✍️" + "<span class='custom-font010'>ថ្ងៃ​ខែឆ្នាំកាន់តំណែង ៖ </span>" + "<br>" + "👉" + (formattedCurrentPositionDate) + "<br>" +
                    "✍️" + "<span class='custom-font010'>ថ្ងៃឆ្នាំបញ្ចប់កិច្ចសន្យា/ការងារ ៖ </span>" + "<br>" + "👉" + (formattedEndDate || "មិនទាន់ប្រាកដ");

                var PositionName_Institution =
                    "✍️" + "<span class='custom-font010'>មុខតំណែងបច្ចុប្បន្ន ៖ </span>" + "<br>" + "👉" + (alldata[i].PositionName || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>ធ្វើការនៅអង្គភាព ៖ </span>" + "<br>" + "👉" + (alldata[i].Institution || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>ផ្នែកអាគារ ៖ </span>" + "<br>" + "👉" + (alldata[i].BuildingName || "");

                var DepartmentName =
                    "✍️" + "<span class='custom-font010'>ជំនាញ/ឯកទេស ៖ </span>" + "<br>" + "👉" + (alldata[i].DepartmentName || "");

                data.push([
                    employeeInfo,
                    "✍️" + "<span class='custom-font010'>ប្រភេទមន្ត្រីឬបុគ្គលិក ៖ </span>" + "<br>" + "👉" + (alldata[i].CategoryEmployeeName || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>ស្ថានភាព ៖ </span>" + "<br>" + "👉" + (alldata[i].StatusName || ""),
                    DateInfo,
                    PositionName_Institution,
                    DepartmentName,
                    "<img src='" + photoUrl + "' alt='Photo' style='width:140px; height:140px;' onerror=\"this.onerror=null; this.src='/images/error.png';\">",
                    "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModal' onClick='editData(" + alldata[i].HiredMedicalOfficerID + ")'><i class='fa fa-edit'></i></button> | " +
                    "<button type='button' class='btn btn-info' onClick='Details(" + alldata[i].HiredMedicalOfficerID + ")'><i class='fa fa-eye'></i></button> | " +
                    "<button type='button' class='btn btn-danger' onClick='deleteData(" + alldata[i].HiredMedicalOfficerID + ")'><i class='fa fa-trash'></i></button>"
                ]);
            }

            $('#table_data').DataTable({
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

function addNew() {
    $('#hiredMedicalOfficerForm')[0].reset();
    dropdownEmployeeID.setChoiceByValue("");
    dropdownDepartmentID.setChoiceByValue("");
    dropdownPositionID.setChoiceByValue("");
    dropdownBuildingID.setChoiceByValue("");
    dropdownCategoryEmployeeID.setChoiceByValue("");
    dropdownStatusID.setChoiceByValue("");
    $('#photoPreview').attr('src', '{{ asset("images/personal.png") }}');
    $("#btnsave").val("បញ្ជូល");
}

function insertData() {
    
    $('.is-invalid').removeClass('is-invalid');
    $('.error-message').remove();

    var e = {
        EmployeeID: $('#EmployeeID').val(),
        StartDate: $('#StartDate').val(),
        CurrentPositionDate: $('#CurrentPositionDate').val(),
        PositionID: $('#PositionID').val(),
        Institution: $('#Institution').val(),
        DepartmentID: $('#DepartmentID').val(),
        BuildingID: $('#BuildingID').val(),
        CategoryEmployeeID: $('#CategoryEmployeeID').val(),
        StatusID: $('#StatusID').val()
    };

    $.ajax({
        type: "POST",
        url: "{{ route('hired_medical_officers.create') }}",
        data: e,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            Swal.fire('ជោគជ័យ', data.message, 'success');
            showData();
            $('#myModal').modal('hide');
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                var employeeIDUnique = false;
                var existsInNotMedicalOfficer = false;
                var existsInGovernmentEmployedDoctor = false;

                $.each(errors, function (key, value) {
                    if (key === 'EmployeeID') {
                        var errorMessage = value[0];
                        if (errorMessage.includes('បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។')) {
                            employeeIDUnique = true;
                        } else if (errorMessage.includes('សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្រ្ត រួចហើយ។')) {
                            existsInNotMedicalOfficer = true;
                        } else if (errorMessage.includes('សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។')) {
                            existsInGovernmentEmployedDoctor = true;
                        }
                        
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<span class="error-message text-danger">' + errorMessage + '</span>');
                    } else {
                        
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<span class="error-message text-danger">' + value[0] + '</span>');
                    }
                });

                
                if (employeeIDUnique) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។ សូមជ្រើសរើសបុគ្គលិកផ្សេង។',
                        icon: 'error'
                    });
                } else if (existsInNotMedicalOfficer) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្រ្ត រួចហើយ។',
                        icon: 'error'
                    });
                } else if (existsInGovernmentEmployedDoctor) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។',
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យមើលទិន្នន័យដែលបានបញ្ចូល។',
                        icon: 'error'
                    });
                }
            } else {
                Swal.fire('បរាជ័យ', 'មានបញ្ហាក្នុងការបញ្ចូលទិន្នន័យ!', 'error');
            }

            console.log(xhr.responseText);
        }
    });
}


function saveData() {
    if ($("#btnsave").val() === "បញ្ជូល") {
        insertData();
    } else {
        updateData();
    }
}

var update_id;
function editData(eId) {
    update_id = eId;
    $("#btnsave").val("កែប្រែ");
    $.ajax({
        type: "GET",
        url: "{{ route('hired_medical_officers.getDataById', ['id' => ':id']) }}".replace(':id', eId),
        dataType: 'json',
        success: function (data) {
            var e = data;
            dropdownEmployeeID.setChoiceByValue(e.EmployeeID.toString());
            $('#StartDate').val(e.StartDate);
            $('#EndDate').val(e.EndDate);
            $('#CurrentPositionDate').val(e.CurrentPositionDate);
            dropdownPositionID.setChoiceByValue(e.PositionID.toString());
            $('#Institution').val(e.Institution);
            dropdownDepartmentID.setChoiceByValue(e.DepartmentID.toString());
            dropdownBuildingID.setChoiceByValue(e.BuildingID.toString());
            dropdownCategoryEmployeeID.setChoiceByValue(e.CategoryEmployeeID.toString());
            dropdownStatusID.setChoiceByValue(e.StatusID.toString());
            if (e.Photo) {
                var photoPath = "{{ asset('') }}" + e.Photo;
                $('#photoPreview').attr('src', photoPath);
            } else {
                $('#photoPreview').attr('src', "{{ asset('images/personal.png') }}");
            }
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}

function updateData() {
    
    $('.is-invalid').removeClass('is-invalid');
    $('.error-message').remove();

    var e = {
        
        EmployeeID: $('#EmployeeID').val(),
        StartDate: $('#StartDate').val(),
        CurrentPositionDate: $('#CurrentPositionDate').val(),
        EndDate: $('#EndDate').val(),
        PositionID: $('#PositionID').val(),
        Institution: $('#Institution').val(),
        DepartmentID: $('#DepartmentID').val(),
        BuildingID: $('#BuildingID').val(),
        CategoryEmployeeID: $('#CategoryEmployeeID').val(),
        StatusID: $('#StatusID').val()
    };

    $.ajax({
        type: "PUT",
        url: "{{ route('hired_medical_officers.update', '') }}/" + update_id,
        data: e,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            Swal.fire('ជោគជ័យ', data.message, 'success');
            showData();
            $('#myModal').modal('hide');
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                var employeeIDUnique = false;
                var existsInNotMedicalOfficer = false;
                var existsInGovernmentEmployedDoctor = false;

                $.each(errors, function (key, value) {
                    if (key === 'EmployeeID') {
                        var errorMessage = value[0];
                        if (errorMessage.includes('បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។')) {
                            employeeIDUnique = true;
                        } else if (errorMessage.includes('សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្ត្រ រួចហើយ។')) {
                            existsInNotMedicalOfficer = true;
                        } else if (errorMessage.includes('សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។')) {
                            existsInGovernmentEmployedDoctor = true;
                        }
                        
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<span class="error-message text-danger">' + errorMessage + '</span>');
                    } else {
                       
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after('<span class="error-message text-danger">' + value[0] + '</span>');
                    }
                });

                if (employeeIDUnique) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។ សូមជ្រើសរើសបុគ្គលិកផ្សេង។',
                        icon: 'error'
                    });
                } else if (existsInNotMedicalOfficer) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្ត្រ រួចហើយ។',
                        icon: 'error'
                    });
                } else if (existsInGovernmentEmployedDoctor) {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។',
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'កំហុស',
                        text: 'សូមពិនិត្យមើលទិន្នន័យដែលបានបញ្ចូល។',
                        icon: 'error'
                    });
                }
            } else {
                Swal.fire('បរាជ័យ', 'មានបញ្ហាក្នុងការកែប្រែទិន្នន័យ!', 'error');
            }

            console.log(xhr.responseText);
        }
    });
}


function Details(id) {
    $.ajax({
        type: "GET",
        url: "{{ route('hired_medical_officers.getHiredMedicalOfficerDetails', ['id' => ':id']) }}".replace(':id', id),
        success: function (data) {
            if (!data) {
                alert("ពុំមានព័ត៌មានលម្អិត។");
            } else {
                updateDetailsModal(data);
            }
        },
        error: function (error) {
            console.error("កំហុសក្នុងការទាញយកព័ត៌មានលម្អិត៖", error.responseJSON ? error.responseJSON.message : error.statusText);
            alert("កំហុសក្នុងការទាញយកព័ត៌មានលម្អិត។ សូមពិនិត្យមើលកំហុសនៅក្នុង console។");
        }
    });
}

function updateDetailsModal(data) {
    $('#detailEmployeeID').text(data.EmployeeID || '');
    $('#detailEmp_as_khmerID').text(data.Emp_as_khmerID || '');
    $('#detailLatinName').text(data.LatinName || '');
    $('#detailDateOfBirth').text(data.DateOfBirth || '');
    $('#detailNationality').text(data.Nationality || '');
    $('#detailFullName').text((data.LastName || '') + ' ' + (data.FirstName || ''));
    $('#detailGender').text(data.Gender || '');
    $('#detailPhone').text(data.Phone || '');
    $('#detailEducationLevel').text(data.EducationLevel || '');
    $('#detailCountry').text(data.Country || '');
    $('#detailSchool').text(data.School || '');
    $('#detailDegree').text(data.Degree || '');
    $('#detailStartDate').text(data.StartDate || '');
    $('#detailCurrentPositionDate').text(data.CurrentPositionDate || '');
    $('#detailCategoryEmployeeName').text(data.CategoryEmployeeName || '');
    $('#detailInstitution').text(data.Institution || '');
    $('#detailPositionName').text(data.PositionName || '');
    $('#detailDepartmentName').text(data.DepartmentName || '');
    $('#detailBuildingName').text(data.BuildingName || '');
    $('#detailStatusName').text(data.StatusName || '');
    $('#detailNationalID').text(data.NationalID || '');
    $('#detailCivilServantID').text(data.CivilServantID || '');
    $('#detailEmployeeCode').text(data.EmployeeCode || '');
    $('#detailEducationStartDate').text(data.EducationStartDate || '');
    $('#detailEducationEndDate').text(data.EducationEndDate || '');

    var fullBirthPlace = [
        data.BirthVillage ? '<span class="custom-font">ភូមិ </span>' + data.BirthVillage : '',
        data.BirthCommuneWard ? '<span class="custom-font">ឃុំ/សង្កាត់ </span>' + data.BirthCommuneWard : '',
        data.BirthDistrict ? '<span class="custom-font">ស្រុក/ខណ្ឌ </span>' + data.BirthDistrict : '',
        data.BirthProvinceName ? '<span class="custom-font">ខេត្ត/រាជធានី </span>' + data.BirthProvinceName : ''
    ].filter(Boolean).join(', ');

    $('#detailFullBirthPlace').html(fullBirthPlace || '<span class="custom-font">មិនមានព័ត៌មាន</span>');

    var fullAddress = [
        data.HouseNumber ? '<span class="custom-font">ផ្ទះលេខ </span>' + data.HouseNumber : '',
        data.GroupNumber ? '<span class="custom-font">ក្រុមទី </span>' + data.GroupNumber : '',
        data.AddressVillage ? '<span class="custom-font">ភូមិ </span>' + data.AddressVillage : '',
        data.AddressCommuneWard ? '<span class="custom-font">ឃុំ/សង្កាត់ </span>' + data.AddressCommuneWard : '',
        data.AddressDistrict ? '<span class="custom-font">ស្រុក/ខណ្ឌ </span>' + data.AddressDistrict : '',
        data.AddressProvinceName ? '<span class="custom-font">ខេត្ត/រាជធានី </span>' + data.AddressProvinceName : ''
    ].filter(Boolean).join(', ');

    $('#detailFullAddress').html(fullAddress || '<span class="custom-font">មិនមានព័ត៌មាន</span>');

    var photoUrl = data.Photo ? "{{ asset('') }}" + data.Photo : "/images/error.png";
    $('#detailPhotoUrl').attr('src', photoUrl);

    $('#detailsModal').modal('show');
}

function printEmployeeDetails() {
    setTimeout(function () {
        if (typeof $.fn.printThis === 'function') {
            $('#detailsModal .modal-body').printThis({
                importCSS: false,
                importStyle: true,
                loadCSS: '/css/custom-print-style2.css',
                header: "<h3 class='custom-font007 text-centerModal text3D'>មន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល និង ជាវេជ្ជសាស្ត្រ</h3>"
            });
        } else {
            console.error('printThis plugin is not loaded');
            alert('មានបញ្ហាក្នុងការបោះពុម្ព។ សូមព្យាយាមម្តងទៀត។');
        }
    }, 300);
}

function formatKhmerDate(dateString) {
    if (!dateString) return "";

    const khmerMonths = ["មករា", "កុម្ភៈ", "មិនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"];
    const khmerNumbers = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];

    let date = new Date(dateString);

    let day = date.getDate().toString().padStart(2, '0');
    let month = khmerMonths[date.getMonth()];
    let year = date.getFullYear().toString();

    day = day.split('').map(num => khmerNumbers[parseInt(num)]).join('');
    year = year.split('').map(num => khmerNumbers[parseInt(num)]).join('');

    return `${day} ${month} ${year}`;
}

function deleteData(id) {
    Swal.fire({
        title: 'តើអ្នកប្រាកដជាចង់លុបមែនទេ?',
        text: "ទិន្នន័យដែលត្រូវបានលុបមិនអាចត្រលប់មកវិញបានទេ!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'យល់ព្រម លុប!',
        cancelButtonText: 'បោះបង់'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('hired_medical_officers.delete', ':id') }}".replace(':id', id),
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.message === 'Delete Success') {
                        Swal.fire(
                            'បានលុប!',
                            'ទិន្នន័យត្រូវបានលុប.',
                            'success'
                        );
                        showData();
                    } else {
                        Swal.fire(
                            'បរាជ័យ!',
                            'មានបញ្ហាក្នុងការលុបទិន្នន័យ: ' + response.error,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'បរាជ័យ!',
                        'មានបញ្ហាក្នុងការលុបទិន្នន័យ: ' + xhr.responseJSON.error,
                        'error'
                    );
                }
            });
        }
    });
}

</script>
@endsection