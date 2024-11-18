@extends('layout.layout')

@section('content')

<link href="{{ asset('css/ModalDetail2.css') }}" rel="stylesheet" asp-append-version="true" />

<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">


<h2 class="custom-font006 "><br><br>បញ្ជីបបញ្ចូលពត៌មាន ជីវប្រវត្តិរូប របស់បុគ្គលិក, មន្ត្រីសុខាភិបាល ទាំងក្របខ័ណ្ឌ ទាំងកិច្ចសន្យា</h2>


<table id="table_data" class="table table-striped table-bordered"></table>

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="addNew()">Add New</button>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
    Delete Records
</button>

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title custom-font007 text-centerModal text3D" id="exampleModalLabel">បញ្ជូលពត៌មានផ្ទាល់ខ្លួន</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="post" id="employeeForm" enctype="multipart/form-data">
                    @csrf
                    <h6 class="mb-3 custom-font009 text-centerModal">✍️ពត៌មានបឋម</h6>
                    <div class="row form-group custom-font010">
                        <div class="col-sm-3">
                            <label for="Emp_as_khmerID">អត្តលេខបុគ្គលិក</label>
                            <input type="text" class="form-control" id="Emp_as_khmerID" name="Emp_as_khmerID" value="បុគ្គលិក_០០" />
                        </div>
                        <div class="col-sm-3">
                            <label for="FirstName">គោត្តនាម</label>
                            <input type="text" class="form-control" id="FirstName" name="FirstName" />
                        </div>
                        <div class="col-sm-3">
                            <label for="LastName">នាម</label>
                            <input type="text" class="form-control" id="LastName" name="LastName" />
                        </div>
                        <div class="col-sm-3">
                            <label for="LatinName">ឈ្មោះអក្សរឡាតាំង</label>
                            <input type="text" class="form-control" id="LatinName" name="LatinName" />
                        </div>
                        <div class="col-sm-3">
                            <label for="Gender">ភេទ</label>
                            <select class="form-control" id="Gender" name="Gender">
                                <option value="" disabled selected hidden>--ជ្រើស(select)ភេទណាមួយ--</option>
                                <option value="ប្រុស">ប្រុស</option>
                                <option value="ស្រី">ស្រី</option>
                                <option value="បព្វជិត">បព្វជិត</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="DateOfBirth">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth" />
                        </div>
                        <div class="col-sm-3">
                            <label for="Nationality">សញ្ជាតិ</label>
                            <input type="text" class="form-control" id="Nationality" name="Nationality" value="ខ្មែរ" />
                        </div>
                        <div class="col-sm-3">
                            <label for="Phone">លេខទូរស័ព្ទ</label>
                            <input type="text" class="form-control" id="Phone" name="Phone" />
                        </div>
                    </div>

            
                    <h6 class="mt-4 mb-3 custom-font009 text-centerModal">✍️ទីកន្លែងកំណើត</h6>
                    <div class="row form-group custom-font010">
                        <div class="col-sm-3">
                            <label for="BirthVillage">ភូមិកំណើត</label>
                            <input type="text" class="form-control" id="BirthVillage" name="BirthVillage" />
                        </div>
                        <div class="col-sm-3">
                            <label for="BirthCommuneWard">ឃុំ/សង្កាត់កំណើត</label>
                            <input type="text" class="form-control" id="BirthCommuneWard" name="BirthCommuneWard" />
                        </div>
                        <div class="col-sm-3">
                            <label for="BirthDistrict">ស្រុក/ខណ្ឌកំណើត</label>
                            <input type="text" class="form-control" id="BirthDistrict" name="BirthDistrict" />
                        </div>
                        <div class="col-sm-3">
                            <label for="BirthProvinceID">ខេត្ត/រាជធានីកំណើត</label>
                            <select name="BirthProvinceID" id="BirthProvinceID" class="form-control choices-single" placeholder="--select--" data-trigger>
                                <option value="">--select--</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->ProvinceID }}">{{ $province->ProvinceName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 class="mt-4 mb-3 custom-font009 text-centerModal">✍️អាសយដ្ឋានបច្ចុប្បន្ន</h6>
                    <div class="row form-group custom-font010">
                        <div class="col-sm-3">
                            <label for="HouseNumber">លេខផ្ទះ</label>
                            <input type="text" class="form-control" id="HouseNumber" name="HouseNumber" />
                        </div>
                        <div class="col-sm-3">
                            <label for="GroupNumber">ក្រុមទីស្នាក់នៅបច្ចុប្បន្ន</label>
                            <input type="text" class="form-control" id="GroupNumber" name="GroupNumber" />
                        </div>
                        <div class="col-sm-3">
                            <label for="AddressVillage">ភូមិស្នាក់នៅបច្ចុប្បន្ន</label>
                            <input type="text" class="form-control" id="AddressVillage" name="AddressVillage" />
                        </div>
                        <div class="col-sm-3">
                            <label for="AddressCommuneWard">ឃុំ/សង្កាត់ស្នាក់នៅបច្ចុប្បន្ន</label>
                            <input type="text" class="form-control" id="AddressCommuneWard" name="AddressCommuneWard" />
                        </div>
                    </div>
                    <div class="row form-group custom-font010">
                        <div class="col-sm-3">
                            <label for="AddressDistrict">ស្រុក/ខណ្ឌស្នាក់នៅបច្ចុប្បន្ន</label>
                            <input type="text" class="form-control" id="AddressDistrict" name="AddressDistrict" />
                        </div>
                        <div class="col-sm-3">
                            <label for="AddressProvinceID">ខេត្ត/រាជធានីបច្ចុប្បន្ន</label>
                            <select class="form-control" id="AddressProvinceID" name="AddressProvinceID">
                                <option value="">--ជ្រើសរើសខេត្ត/ក្រុង--</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->ProvinceID }}">{{ $province->ProvinceName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="Photo" class="control-label">រូបថត</label>
                            <input type="file" id="PhotoUpload" class="form-control" name="Photo" onchange="previewPhoto()" />
                            <!-- <input type="hidden" id="Photo" name="Photo" /> -->
                            <span id="fileNameDisplay" class="form-text"></span>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center align-items-center">
                            <img id="photoPreview" src="{{ asset('images/personal.png') }}" alt="រូបភាព..." style="width: 100px; height: auto;">
                        </div>
                    </div>

          
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnsave" onclick="saveData()">រក្សាទុក</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">បិទ</button>
            </div>
            
        </div>
    </div>
</div>



<div id="detailsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title custom-font007 text-centerModal text3D">ពត៌មាន មន្ត្រីក្របខណ្ឌលម្អិត</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mb-4">
                    <img id="detailPhotoUrl" src="" alt="Employee Photo" class="rounded-circle" style="width: 100px; height: 100px;">
                </div>
                <div class="details-info custom-font010">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong class="custom-font009">អត្តលេខ ៖</strong> <span id="detailEmployeeID"></span></p>
                            <p><strong class="custom-font009">អត្តលេខមន្ត្រីជាអក្សរខ្មែរ ៖</strong> <span id="detailEmp_as_khmerID"></span></p>
                            <p><strong class="custom-font009">គោត្តនាម ៖</strong> <span id="detailFirstName"></span></p>
                            <p><strong class="custom-font009">នាម ៖</strong> <span id="detailLastName"></span></p>
                            <p><strong class="custom-font009">ឈ្មោះឡាតាំង ៖</strong> <span id="detailLatinName"></span></p>
                            <p><strong class="custom-font009">ភេទ ៖</strong> <span id="detailGender"></span></p>
                            <p><strong class="custom-font009">ថ្ងៃខែឆ្នាំកំណើត ៖</strong> <span id="detailDateOfBirth"></span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong class="custom-font009">សញ្ជាតិ ៖</strong> <span id="detailNationality"></span></p>
                            <p><strong class="custom-font009">លេខទូរសព្ទ ៖</strong> <span id="detailPhone"></span></p>
                            <p><strong class="custom-font009">ភូមិកំណើត ៖</strong> <span id="detailBirthVillage"></span></p>
                            <p><strong class="custom-font009">ឃុំ/សង្កាត់កំណើត ៖</strong> <span id="detailBirthCommuneWard"></span></p>
                            <p><strong class="custom-font009">ស្រុក/ខណ្ឌកំណើត ៖</strong> <span id="detailBirthDistrict"></span></p>
                            <p><strong class="custom-font009">ខេត្ត/រាជធានីកំណើត ៖</strong> <span id="detailBirthProvince"></span></p>
                            <p><strong class="custom-font009">ផ្ទះលេខ ៖</strong> <span id="detailHouseNumber"></span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong class="custom-font009">លេខក្រុម ៖</strong> <span id="detailGroupNumber"></span></p>
                            <p><strong class="custom-font009">ភូមិស្នាក់នៅបច្ចុប្បន្ន ៖</strong> <span id="detailAddressVillage"></span></p>
                            <p><strong class="custom-font009">ឃុំ/សង្កាត់ស្នាក់នៅបច្ចុប្បន្ន ៖</strong> <span id="detailAddressCommuneWard"></span></p>
                            <p><strong class="custom-font009">ស្រុក/ខណ្ឌស្នាក់នៅបច្ចុប្បន្ន ៖</strong> <span id="detailAddressDistrict"></span></p>
                            <p><strong class="custom-font009">ខេត្ត/រាជធានីស្នាក់នៅបច្ចុប្បន្ន ៖</strong> <span id="detailAddressProvince"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-font006" data-bs-dismiss="modal">បិទ</button>
                <button onclick="printEmployeeDetails()" class="btn btn-primary ">Print</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="{{asset('js/jquery-3.4.1.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">

<style>
    .is-invalid {
        border-color: red;
    }

    .error-message {
        color: red;
        font-size: 12px;
    }
</style>

<script type="text/javascript">
//  document.addEventListener('DOMContentLoaded', function () {
//         const birthProvinceSelect = new Choices('#BirthProvinceID', {
//             searchEnabled: true,
//             itemSelectText: '',
//             shouldSort: false
//         });
//     });

    var dropdownaddress = new Choices(document.querySelector("#AddressProvinceID"));
    var dropdownbirth = new Choices(document.querySelector("#BirthProvinceID"));


function FormatDateEdit(dateString) {
    if (!dateString) return "";

    const date = new Date(dateString);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
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

$(document).ready(function () {
        showData(); 
    });

function showData() {
    $.ajax({
        type: "GET",
        url: "{{ url('personal_info_Empl/GetAllData') }}",
        dataType: 'json',
        success: function (alldata) {
            var columns = [
                { title: "EmpID" },
                { title: "អត្តលេខ" },
                { title: "នាមត្រកូល" },
                { title: "នាមខ្លួន" },
                { title: "អក្សរឡាតាំង" },
                { title: "ភេទ" },
                { title: "ថ្ងៃខែឆ្នាំកំណើត" },
                { title: "សញ្ជាតិ" },
                { title: "លេខទូរស័ព្ទ" },
                { title: "រូបភាព" },
                { title: "ភូមិកំណើត", visible: false },
                { title: "ឃុំ/សង្កាត់កំណើត", visible: false },
                { title: "ស្រុក/ខណ្ឌកំណើត", visible: false },
                { title: "ខេត្ត/រាជធានីកំណើត", visible: false },
                { title: "លេខផ្ទះ", visible: false },
                { title: "លេខក្រុម", visible: false },
                { title: "ភូមិ", visible: false },
                { title: "ឃុំ/សង្កាត់", visible: false },
                { title: "ស្រុក/ខណ្ឌ", visible: false },
                { title: "ខេត្ត/រាជធានី", visible: false },
                { title: "Options" }
            ];

            var data = [];
            for (var i in alldata) {
                var photoUrl = alldata[i].Photo ? "{{ asset('') }}" + alldata[i].Photo : "/images/error.png";

                var formattedDateOfBirth = formatKhmerDate(alldata[i].DateOfBirth);

                data.push([
                    alldata[i].EmployeeID || "",
                    alldata[i].Emp_as_khmerID || "",
                    alldata[i].FirstName || "អ្នកភ្លេចបញ្ជូល",
                    alldata[i].LastName || "",
                    alldata[i].LatinName || "",
                    alldata[i].Gender || "",
                    formattedDateOfBirth, 
                    alldata[i].Nationality || "",
                    alldata[i].Phone || "",
                    "<img src='" + photoUrl + "' alt='Photo' style='width:50px; height:50px;' onerror=\"this.onerror=null; this.src='/images/error.png';\">",
                    alldata[i].BirthVillage || "",
                    alldata[i].BirthCommuneWard || "",
                    alldata[i].BirthDistrict || "",
                    alldata[i].BirthProvinceName || "",
                    alldata[i].HouseNumber || "",
                    alldata[i].GroupNumber || "",
                    alldata[i].AddressVillage || "",
                    alldata[i].AddressCommuneWard || "",
                    alldata[i].AddressDistrict || "",
                    alldata[i].AddressProvinceName || "",
                    "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModal' onClick='editData(" + alldata[i].EmployeeID + ")'><i class='fa fa-edit'></i></button> | " +
                    "<button type='button' class='btn btn-info' onClick='Details(" + alldata[i].EmployeeID + ")'><i class='fa fa-eye'></i></button> | " +
                    "<button type='button' class='btn btn-danger' onClick='deleteData(" + alldata[i].EmployeeID + ")'><i class='fa fa-trash'></i></button>"
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



    function previewPhoto() {
        var file = document.getElementById('PhotoUpload').files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            document.getElementById('photoPreview').src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file);
            document.getElementById('Photo').value = file.name;
            document.getElementById('fileNameDisplay').textContent = file.name;
        } else {
            document.getElementById('photoPreview').src = "{{ asset('images/personal.png') }}";
            document.getElementById('Photo').value = "";
            document.getElementById('fileNameDisplay').textContent = "";
        }
    }

    function addNew() {
        $('#Emp_as_khmerID').val("");
        $('#FirstName').val("");
        $('#LastName').val("");
        $('#LatinName').val("");
        $('#Gender').val("");
        $('#DateOfBirth').val("");
        $('#Nationality').val("ខ្មែរ");
        $("#Phone").val("");
        $("#Photo").val("");
        $("#photoPreview").attr('src', "{{ asset('images/personal.png') }}");
        $("#btnsave").val("Insert");
        $('#fileNameDisplay').text("");

        $('.form-control').removeClass('is-invalid');
        $('.error-message').remove();
    }

    function insertData() {
        var form_data = new FormData($('#employeeForm')[0]);
        form_data.append("_token", "{{ csrf_token() }}");

        $('.form-control').removeClass('is-invalid');
        $('.error-message').remove(); 

        $.ajax({
            type: "POST",
            url: "{{ url('personal_info_Empl/Create') }}",
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data) {
                Swal.fire('ជោគជ័យ', 'បុគ្គលិកបានរក្សាទុកដោយជោគជ័យ!', 'success');
            
                showData(); 
            },
            error: function (e) {
                if (e.status === 403 && e.responseJSON && e.responseJSON.error) {
                // Handle unauthorized access using the message from the server
                Swal.fire({
                    title: 'កំហុស',
                    text: e.responseJSON.error,
                    icon: 'error'
                });
                } else if (e.responseJSON && e.responseJSON.errors) {
                    var Emp_ID_khmer_Unique = false;
                    
                    $.each(e.responseJSON.errors, function (key, value) {
                        if (key === 'Emp_as_khmerID' && value.includes('អត្តលេខនេះមានរួចហើយ។')) {
                            Emp_ID_khmer_Unique = true;
                        } else {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<span class="error-message text-danger">' + value[0] + '</span>');
                        }
                    });

                    if (Emp_ID_khmer_Unique) {
                        Swal.fire({
                            title: 'កំហុស',
                            text: 'អត្តលេខនេះមានរួចហើយ។ សូមព្យាយាមបញ្ចូលអត្តលេខថ្មី។',
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'កំហុស',
                            text: 'សូមពិនិត្យមើល ឱ្យគ្រប់ប្រអប់សិន',
                            icon: 'error'
                        });
                    }
                } else {
                    Swal.fire('បរាជ័យ', 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ!', 'error');
                }

                console.log(e.responseText);  
            }
        });
    }

    function updateData() {
        var form_data = new FormData($('#employeeForm')[0]);
        form_data.append("_token", "{{ csrf_token() }}");
        form_data.append("_method", "PUT"); 

        $.ajax({
            type: "POST",  
            url: "{{ url('personal_info_Empl/Update') }}/" + update_id,  
            data: form_data,
            processData: false,
            contentType: false,
            success: function (data) {
                Swal.fire('Success', 'Employee updated successfully!', 'success');
            
                showData(); 
            },
            error: function (e) {
                if (e.status === 403 && e.responseJSON && e.responseJSON.error) {
                // Handle unauthorized access using the message from the server
                Swal.fire({
                    title: 'កំហុស',
                    text: e.responseJSON.error, // Use message from server response
                    icon: 'error'
                });
                } else if (e.responseJSON && e.responseJSON.errors) {
                    var Emp_ID_khmer_Unique = false;
                    var errorMessage = '';  

                    $.each(e.responseJSON.errors, function (key, value) {
                        if (key === 'Emp_as_khmerID' && value.includes('អត្តលេខនេះមានរួចហើយ។')) {
                            Emp_ID_khmer_Unique = true;
                        } else {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<span class="error-message">' + value[0] + '</span>');
                        }
                    });

                    if (Emp_ID_khmer_Unique) {
                        Swal.fire({
                            title: 'កំហុស',
                            text: 'អត្តលេខនេះមានរួចហើយ។ សូមព្យាយាមបញ្ចូលអត្តលេខថ្មី។',
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'កំហុស',
                            text: 'សូមពិនិត្យមើល ឱ្យគ្រប់ប្រអប់សិន',
                            icon: 'error'
                        });
                    }
                } else {
                    Swal.fire('បរាជ័យ', 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ!', 'error');
                }

                console.log(e.responseText);  
            }
        });
    }

    function saveData() {
        if ($("#btnsave").val() == "Insert") {
            insertData();
        } else {
            updateData();
        }
    }

    var update_id;

function editData(byid) {
    update_id = byid;
    $("#btnsave").val("Update");
    
    $.ajax({
        type: "GET",
        url: "{{ url('personal_info_Empl/GetDataId') }}/" + byid,
        dataType: 'json',
        success: function (personal_info_Emp) {
          
            $('#Emp_as_khmerID').val(personal_info_Emp.Emp_as_khmerID);
            $('#FirstName').val(personal_info_Emp.FirstName);
            $('#LastName').val(personal_info_Emp.LastName);
            $('#LatinName').val(personal_info_Emp.LatinName);
            $('#Gender').val(personal_info_Emp.Gender);
            $('#DateOfBirth').val(FormatDateEdit(personal_info_Emp.DateOfBirth));
            $('#Nationality').val(personal_info_Emp.Nationality);
            $('#Phone').val(personal_info_Emp.Phone);
            $('#BirthVillage').val(personal_info_Emp.BirthVillage);
            $('#BirthCommuneWard').val(personal_info_Emp.BirthCommuneWard);
            $('#BirthDistrict').val(personal_info_Emp.BirthDistrict);
           
            $('#HouseNumber').val(personal_info_Emp.HouseNumber);
            $('#GroupNumber').val(personal_info_Emp.GroupNumber);
            $('#AddressVillage').val(personal_info_Emp.AddressVillage);
            $('#AddressCommuneWard').val(personal_info_Emp.AddressCommuneWard);
            $('#AddressDistrict').val(personal_info_Emp.AddressDistrict);
            dropdownaddress.setChoiceByValue(personal_info_Emp.AddressProvinceID.toString());
            dropdownbirth.setChoiceByValue(personal_info_Emp.BirthProvinceID.toString());

            if (personal_info_Emp.Photo) {
                var photoPath = "{{ asset('') }}" + personal_info_Emp.Photo;

                $('#photoPreview').attr('src', photoPath);
                $('#Photo').val(personal_info_Emp.Photo);
                $('#fileNameDisplay').text(personal_info_Emp.Photo);
            } 

            $('#photoPreview').on('error', function () {
                $(this).attr('src', "{{ asset('images/error.png') }}");
            });
           
           

            
            
      
            $('#myModal').modal('show');
        },
        error: function(xhr) {
            let errorMessage = 'មានបញ្ហាក្នុងការទាញយកទិន្នន័យ: ';
            if (xhr.status === 403) {
                errorMessage = xhr.responseJSON.error; // Unauthorized action message
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage += xhr.responseJSON.error;
            } else {
                errorMessage += 'កំហុសមិនទំនាក់ទំនង: ' + xhr.statusText;
            }

            Swal.fire(
                'បរាជ័យ!',
                errorMessage,
                'error'
            );
        }
    });
}


$(document).ready(function() {
    $('.btn-secondary[data-dismiss="modal"]').on('click', function() {
        $('#myModal').modal('hide');
    });
});

function deleteData(id) {
    Swal.fire({
        title: 'តើអ្នកប្រាកដទេ?',
        text: "អ្នកនឹងមិនអាចត្រឡប់វាមកវិញបានទេ!",
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
                url: "{{ route('personal_info_Empl.delete', ':id') }}".replace(':id', id),
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire(
                        'បានលុប!',
                        response.message,
                        'success'
                    );
                    showData();
                },
                error: function(xhr) {
                    let errorMessage = 'មានបញ្ហាក្នុងការលុបទិន្នន័យ: ';
                    if (xhr.status === 403) {
                        errorMessage = xhr.responseJSON.error; // Unauthorized action message
                    } else if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage += xhr.responseJSON.error;
                    } else {
                        errorMessage += 'កំហុសមិនទំនាក់ទំនង: ' + xhr.statusText;
                    }

                    Swal.fire(
                        'បរាជ័យ!',
                        errorMessage,
                        'error'
                    );
                }
            });
        }
    });
}


function Details(id) {
    $.ajax({
        type: "GET",
        url: "{{ url('personal_info_Empl/GetEmployeeDetails') }}/" + id,
        data: { id: id },
        success: function (data) {
            if (!data) {
                alert("ពុំមានព័ត៌មានលម្អិត។");
            } else {
                updateDetailsModal(data);
            }
        },
        error: function (error) {
            console.error("កំហុសក្នុងការទាញយកព័ត៌មានលម្អិត៖", error);
            alert("កំហុសក្នុងការទាញយកព័ត៌មានលម្អិត។");
        }
    });
}

function updateDetailsModal(data) {
    var formattedDateOfBirth = formatKhmerDate(data.DateOfBirth);

    $('#detailEmployeeID').text(data.EmployeeID || '');
    $('#detailEmp_as_khmerID').text(data.Emp_as_khmerID || '');
    $('#detailFirstName').text(data.FirstName || '');
    $('#detailLastName').text(data.LastName || '');
    $('#detailLatinName').text(data.LatinName || '');
    $('#detailGender').text(data.Gender || '');
    $('#detailDateOfBirth').text(formattedDateOfBirth || '');
    $('#detailNationality').text(data.Nationality || '');
    $('#detailPhone').text(data.Phone || '');
    $('#detailPhotoUrl').attr('src', data.Photo ? "{{ asset('') }}" + data.Photo : "{{ asset('images/error.png') }}");

    $('#detailBirthVillage').text(data.BirthVillage || '');
    $('#detailBirthCommuneWard').text(data.BirthCommuneWard || '');
    $('#detailBirthDistrict').text(data.BirthDistrict || '');
    $('#detailBirthProvince').text(data.BirthProvinceName || '');

    $('#detailHouseNumber').text(data.HouseNumber || '');
    $('#detailGroupNumber').text(data.GroupNumber || '');
    $('#detailAddressVillage').text(data.AddressVillage || '');
    $('#detailAddressCommuneWard').text(data.AddressCommuneWard || '');
    $('#detailAddressDistrict').text(data.AddressDistrict || '');
    $('#detailAddressProvince').text(data.AddressProvinceName || '');

    $('#detailsModal').modal('show');
}

function printEmployeeDetails() {
    setTimeout(function () {
        if (typeof $.fn.printThis === 'function') {
            $('#detailsModal').printThis({
                importCSS: false,
                importStyle: true,
                loadCSS: '/css/custom-print-style2.css',
                header: "<h3 class='custom-font007 text-centerModal text3D'>ពត៌មាន មន្ត្រីក្របខណ្ឌលម្អិត</h3>"
            });
        } else {
            console.error('printThis plugin is not loaded');
            alert('មានបញ្ហាក្នុងការបោះពុម្ព។ សូមព្យាយាមម្តងទៀត។');
        }
    }, 300);
}



</script>

@endsection