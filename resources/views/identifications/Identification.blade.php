@extends('layout.layout')

@section('content')

<link href="{{ asset('css/ModalDetail2.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}"> -->

<h2 class="custom-font006 "><br><br>បញ្ជីបញ្ចូលព័ត៌មាន អត្តសញ្ញាណបុគ្គលិក</h2>
<table id="table_data" class="table table-striped table-bordered"></table>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal" onclick="addNew()">បញ្ជូលថ្មីបន្ថែម</button>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel">បញ្ជូលព័ត៌មាន អត្តសញ្ញាណបុគ្គលិក</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12 d-flex justify-content-center">
                        <img id="photoPreview" src="{{ asset('images/personal.png') }}" alt="រូបភាព..." style="width: 100px; height: auto;">
                    </div>
                </div>
                <form class="form-horizontal" id="identificationForm">
                <div class="row form-group">
    <div class="col-sm-12">
        <label for="EmployeeID">បុគ្គលិក ឬ មន្ត្រីរាជការ</label>
        <select id="EmployeeID" name="EmployeeID" class="form-control choices-single" placeholder="--select--" data-trigger onchange="updatePhotoPreview()">
            <option value="">--ជ្រើសរើសបុគ្គលិក--</option>
            @if (isset($employees) && $employees->count() > 0)
                @foreach ($employees as $employee)
                    @if ($loop->last)
                        <option selected value="{{ $employee->EmployeeID }}">ឈ្មោះ ៖ {{ $employee->FirstName }} {{ $employee->LastName }} អត្តលេខ ៖ {{ $employee->Emp_as_khmerID }} ទូរស័ព្ទ ៖{{ $employee->Phone }} ភេទ ៖{{ $employee->Gender }}</option>
                    @else
                        <option value="{{ $employee->EmployeeID }}">ឈ្មោះ ៖ {{ $employee->FirstName }} {{ $employee->LastName }} អត្តលេខ ៖ {{ $employee->Emp_as_khmerID }} ទូរស័ព្ទ ៖{{ $employee->Phone }} ភេទ ៖{{ $employee->Gender }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
</div>

                    <div class="row form-group">
                        <div class="col-sm-4">
                            <label for="NationalID">អត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ</label>
                            <input id="NationalID" name="NationalID" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label for="CivilServantID">លេខសម្គាល់ចំនួនមន្ត្រីរាជការ</label>
                            <input id="CivilServantID" name="CivilServantID" class="form-control" />
                        </div>
                        <div class="col-sm-4">
                            <label for="EmployeeCode">អត្តលេខមន្ត្រីក្របខណ្ឌ</label>
                            <input id="EmployeeCode" name="EmployeeCode" class="form-control" value="មន្ត្រីក្របខណ្ឌ_០០" />
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
                <h5 class="modal-title custom-font007 text-centerModal text3D">ពត៌មាន អត្តសញ្ញាណបុគ្គលិក</h5>
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
                            <p><strong class="custom-font009">ទីកន្លែងកំណើត៖</strong></p>
                            <p class="ml-3"><span id="detailFullBirthPlace"></span></p>
                            <p><strong class="custom-font009">អាសយដ្ឋានបច្ចុប្បន្ន៖</strong></p>
                            <p class="ml-3"><span id="detailFullAddress"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p><strong class="custom-font009">អត្តលេខ៖</strong> <span id="detailEmp_as_khmerID"></span></p>
                            <p><strong class="custom-font009">អត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ៖</strong> <span id="detailNationalID"></span></p>
                            <p><strong class="custom-font009">លេខសម្គាល់ចំនួនមន្ត្រីរាជការ៖</strong> <span id="detailCivilServantID"></span></p>
                            <p><strong class="custom-font009">អត្តលេខមន្ត្រីក្របខណ្ឌ៖</strong> <span id="detailEmployeeCode"></span></p>
                           
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


<style>
    .is-invalid {
        border-color: red;
    }

    .error-message {
        color: red;
        font-size: 12px;
    }
</style>
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
    
// function updatePhotoPreview() {
//     var selectedEmployeeId = $('#EmployeeID').val();

//     if (selectedEmployeeId) {
//         $.ajax({
//             type: "GET",
//             url: "{{ route('identifications.getEmployeePhoto', ['id' => ':id']) }}".replace(':id', selectedEmployeeId),
//             success: function (data) {
//                 if (data && data.photo) {
//                     var photoPath = "{{ asset('') }}" + data.photo;
//                     $('#photoPreview').attr('src', photoPath);
//                 } else {
//                     $('#photoPreview').attr('src', '{{ asset("images/error.png") }}');
//                 }
//             },
//             error: function () {
//                 $('#photoPreview').attr('src', '{{ asset("images/error.png") }}');
//             }
//         });
//     } else {
//         $('#photoPreview').attr('src', '{{ asset("images/personal.png") }}');
//     }
// }

function updatePhotoPreview() {
    var selectedEmployeeId = $('#EmployeeID').val();

    if (selectedEmployeeId) {
        $.ajax({
            type: "GET",
            url: "{{ route('identifications.getEmployeePhoto', ':id') }}".replace(':id', selectedEmployeeId),
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
        url: "{{ route('identifications.getAllData') }}",
        dataType: 'json',
        success: function (alldata) {
            var columns = [
                { title: "<span class='custom-font009'>បុគ្គលិក</span>" },
                { title: "<span class='custom-font009'>អត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ</span>" },
                { title: "<span class='custom-font009'>លេខសម្គាល់ចំនួនមន្ត្រីរាជការ</span>" },
                { title: "<span class='custom-font009'>អត្តលេខមន្ត្រីក្របខណ្ឌ</span>" },
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

                var identificationInfo =
                    "✍️" + "<span class='custom-font010'>អត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ ៖ </span>" + "<br>" + "👉" + (alldata[i].NationalID || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>លេខសម្គាល់ចំនួនមន្ត្រីរាជការ ៖ </span>" + "<br>" + "👉" + (alldata[i].CivilServantID || "") + "<br>" +
                    "✍️" + "<span class='custom-font010'>អត្តលេខមន្ត្រីក្របខណ្ឌ ៖ </span>" + "<br>" + "👉" + (alldata[i].EmployeeCode || "");

                data.push([
                    employeeInfo,
                    alldata[i].NationalID || "",
                    alldata[i].CivilServantID || "",
                    alldata[i].EmployeeCode || "",
                    "<img src='" + photoUrl + "' alt='Photo' style='width:140px; height:140px;' onerror=\"this.onerror=null; this.src='{{ asset('images/error.png') }}';\">",
                    "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModal' onClick='editData(" + alldata[i].IdentificationID + ")'><i class='fa fa-edit'></i></button> | " +
                    "<button type='button' class='btn btn-info' onClick='Details(" + alldata[i].IdentificationID + ")'><i class='fa fa-eye'></i></button> | " +
                    "<button type='button' class='btn btn-danger' onClick='deleteData(" + alldata[i].IdentificationID + ")'><i class='fa fa-trash'></i></button>"
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
    $('#identificationForm')[0].reset();
    // dropdownEmployeeID.setChoiceByValue("");
    // $('#photoPreview').attr('src', '{{ asset("images/personal.png") }}');
    $("#btnsave").val("បញ្ជូល");
}

function insertData() {
    $('.form-control').removeClass('is-invalid');
    $('.error-message').remove();

    var i = {
        EmployeeID: $('#EmployeeID').val(),
        NationalID: $('#NationalID').val(),
        CivilServantID: $('#CivilServantID').val(),
        EmployeeCode: $('#EmployeeCode').val()
    };

    $.ajax({
        type: "POST",
        url: "{{ route('identifications.create') }}",
        data: i,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            Swal.fire({ title: data.message, icon: "success" });
            showData();
            $('#myModal').modal('hide');
        },
        error: function (e) {
            if (e.status === 422) {
                var errors = e.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<span class="error-message">' + value[0] + '</span>');
                });
            } else {
                console.log(e.responseText);
                Swal.fire({ title: "Error", text: "An error occurred while inserting data.", icon: "error" });
            }
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
function editData(iId) {
    update_id = iId;
    $("#btnsave").val("កែប្រែ");
    $.ajax({
        type: "GET",
        url: "{{ route('identifications.getDataId', ['id' => ':id']) }}".replace(':id', iId),
        dataType: 'json',
        success: function (data) {
            var i = data;
            dropdownEmployeeID.setChoiceByValue(i.EmployeeID.toString());
            $('#NationalID').val(i.NationalID);
            $('#CivilServantID').val(i.CivilServantID);
            $('#EmployeeCode').val(i.EmployeeCode);
            if (i.Photo) {
                var photoPath = "{{ asset('') }}" + i.Photo;
                $('#photoPreview').attr('src', photoPath);
            } else {
                $('#photoPreview').attr('src', "{{ asset('images/error.png') }}");
            }
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}



function updateData() {
    var i = {
        IdentificationID: update_id,
        EmployeeID: $('#EmployeeID').val(),
        NationalID: $('#NationalID').val(),
        CivilServantID: $('#CivilServantID').val(),
        EmployeeCode: $('#EmployeeCode').val()
    };
    $.ajax({
        type: "POST",
        url: "{{ route('identifications.update', ['id' => ':id']) }}".replace(':id', update_id),
        data: i,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            Swal.fire({ title: data.message, icon: "success" });
            showData();
            $('#myModal').modal('hide');
        },
        error: function (e) {
            if (e.responseJSON && e.responseJSON.errors) {
                $('.form-control').removeClass('is-invalid');
                $('.error-message').remove();
                
                $.each(e.responseJSON.errors, function (key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<span class="error-message">' + value[0] + '</span>');
                });
                
                Swal.fire({
                    title: 'កំហុស',
                    text: 'សូមពិនិត្យមើល ឱ្យគ្រប់ប្រអប់សិន',
                    icon: 'error'
                });
            } else {
                console.log(e.responseText);
                Swal.fire({ title: "កំហុស", text: "មានបញ្ហាក្នុងការកែប្រែទិន្នន័យ។", icon: "error" });
            }
        }
    });
}


function Details(id) {
    $.ajax({
        type: "GET",
        url: "{{ route('identifications.getIdentificationDetails', ['id' => ':id']) }}".replace(':id', id),
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
    $('#detailNationalID').text(data.NationalID || '');
    $('#detailCivilServantID').text(data.CivilServantID || '');
    $('#detailEmployeeCode').text(data.EmployeeCode || '');
    $('#detailEmp_as_khmerID').text(data.Emp_as_khmerID || '');
    $('#detailLatinName').text(data.LatinName || '');
    $('#detailDateOfBirth').text(data.DateOfBirth || '');
    $('#detailNationality').text(data.Nationality || '');
    $('#detailFullName').text((data.LastName || '') + ' ' + (data.FirstName || ''));
    $('#detailGender').text(data.Gender || '');
    $('#detailPhone').text(data.Phone || '');
    // $('#detailBirthVillage').text(data.BirthVillage || '');
    // $('#detailBirthCommuneWard').text(data.BirthCommuneWard || '');
    // $('#detailBirthDistrict').text(data.BirthDistrict || '');
    // $('#detailBirthProvinceName').text(data.BirthProvinceName || '');
    // $('#detailHouseNumber').text(data.HouseNumber || '');
    // $('#detailGroupNumber').text(data.GroupNumber || '');
    // $('#detailAddressVillage').text(data.AddressVillage || '');
    // $('#detailAddressCommuneWard').text(data.AddressCommuneWard || '');
    // $('#detailAddressDistrict').text(data.AddressDistrict || '');
    // $('#detailAddressProvinceName').text(data.AddressProvinceName || '');
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
                header: "<h3 class='custom-font007 text-centerModal text3D'>ពត៌មាន មន្ត្រីក្របខណ្ឌលម្អិត</h3>"
            });
        } else {
            console.error('printThis plugin is not loaded');
            alert('មានបញ្ហាក្នុងការបោះពុម្ព។ សូមព្យាយាមម្តងទៀត។');
        }
    }, 300);
}


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
                url: "{{ route('identifications.delete', ':id') }}".replace(':id', id),
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire(
                        'បានលុប!',
                        'ទិន្នន័យត្រូវបានលុប.',
                        'success'
                    );
                    showData();
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'បរាជ័យ!',
                        'មានបញ្ហាក្នុងការលុបទិន្នន័យ: ' + xhr.responseText,
                        'error'
                    );
                }
            });
        }
    });
}





</script>
@endsection