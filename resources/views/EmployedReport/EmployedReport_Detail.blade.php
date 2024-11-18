@extends('layout.layout')

@section('content')
<div class="container">
<div class="form-group row justify-content-center">
<div class="col-sm-1">
<a href="{{ route('report.government_employed_report') }}" class="custom-list-item1 clickable3" style="border: 3px solid #ff69b4; border-radius: 25px; padding: 15px; background-color: #fff0f5; box-shadow: 0 6px 12px rgba(255,105,180,0.2), 0 8px 16px rgba(255,20,147,0.2); transition: all 0.4s ease; display: inline-block; margin-bottom: 20px;">
    <span class="custom-font006" style="font-size: 22px;">🔙 </span>
</a>
</div>
<div class="col-sm-11">
    <h2 class="modal-title custom-font007BB text3D">របាយការណ៍បែបបទទី១</h2>
</div>
    <br>
    </div>

    <div class="text-center custom-font00B">
        <div class="form-group row justify-content-center">
            <div class="col-sm-4">
                <label for="dateField" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶ជ្រើសរើសកាលបរិច្ឆេទច្រោះទិន្នន័យ</label>
                <select id="dateField" class="form-control custom-font011 text-center">
                    <option value="">ជ្រើសរើសទិន្នន័យតាមរយៈ..</option>
                    <option value="StartDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលបម្រើការងារ</option>
                    <option value="EndDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលនិវត្តន៍</option>
                    <option value="CurrentPositionDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលកាន់មុខតំណែងបច្ចុប្បន្ន</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="date1" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶ចាប់ពីថ្ងៃ:</label>
                <input type="date" id="date1" class="form-control" />
            </div>
            <div class="col-sm-4">
                <label for="date2" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶ដល់ថ្ងៃ:</label>
                <input type="date" id="date2" class="form-control" />
            </div>
        </div> <br>

        <div class="form-group row justify-content-center">
            <div class="col-sm-6">
                <label for="buildingName" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷ជ្រើសរើសផ្នែក/អាគារ</label>
                <select id="buildingName" class="form-control">
                    <option value="">ជ្រើសរើសផ្នែក/អាគារ</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->BuildingName }}">{{ $building->BuildingName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="categoryEmployee" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷ជ្រើសរើសអនុប្រភេទ</label>
                <select id="categoryEmployee" class="form-control">
                    <option value="">ជ្រើសរើសអនុប្រភេទ</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->CategoryEmployeeName }}">{{ $category->CategoryEmployeeName }}</option>
                    @endforeach
                </select>
            </div>
        </div> <br>

        <div class="form-group row justify-content-center">

            <div class="col-sm-6">
                <div style="border: 2px dashed #87ceeb; border-radius: 15px; padding: 15px; background-color: #f0f8ff;">
                    <label for="employeeType" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ធីកប្រភេទបុគ្គលិក</label>
                    <div>
                        <label class="checkbox-inline custom-font011">
                            <input type="checkbox" name="employeeType[]" value="GovernmentEmployedDoctor" class="employeeType"> មន្ត្រីក្របខណ្ឌ
                        </label>
                        <label class="checkbox-inline custom-font011">
                            <input type="checkbox" name="employeeType[]" value="HiredMedicalOfficer" class="employeeType"> កិច្ចសន្យា/ជួល&វេជ្ជសាស្ត្រ
                        </label>
                        <label class="checkbox-inline custom-font011">
                            <input type="checkbox" name="employeeType[]" value="HiredNotMedicalOfficer" class="employeeType"> កិច្ចសន្យា/ជួល&មិនវេជ្ជសាស្ត្រ
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div style="border: 2px dashed #ff69b4; border-radius: 15px; padding: 15px; background-color: #fff5f7;">
                    <label for="EmploymentStatus" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ធីកស្ថានភាពការងារ</label>
                    <div>
                        @foreach($statuses as $status)
                            <label class="checkbox-inline custom-font011">
                                <input type="checkbox" name="EmploymentStatus[]" value="{{ $status->StatusName }}" class="EmploymentStatus"> {{ $status->StatusName }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> <br>

        <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnsearch">
                <i class="fa fa-search"></i> ចុចច្រោះរកទិន្នន័យ
            </button>
            <button type="button" class="btn btn-secondary" id="btnreset">
                <i class="fa fa-refresh"></i> ត្រឡប់ឡើងវិញ
            </button>
            <button type="button" class="btn btn-success" id="btnexport">
                <i class="fa fa-file-excel-o"></i> នាំចេញទៅ Excel
            </button>
        </div>
    </div>
</div>
<style>
span {
    font-size: 22px;
    font-family: "Khmer os battambang", sans-serif;
    color: black;
}
</style>
<div id="div_print">
    <p style="text-align: center;"> 
        <span id="showdate">កាលបរិច្ឆេទស្រង់របាយការណ៍: {{ date('d-m-Y') }}</span>
        <br>
        <span id="showReportDetails">ស្រង់របាយការណ៍តាមរយៈ: <span id="reportDetailsValue"></span></span>
    </p>
    <div id="display">content .......</div>
    <h1>&nbsp;</h1>
    <p style="text-align: right; padding-right:25%;">រៀបចំរបាយការដោយ </p>
    <p style="text-align: right; padding-right:25%;">ឈ្មោះ ៖ </p>
</div>

<br />
<button type="button" style="width:150px;" id="btnprint" class="btn btn-success" onclick="PrintReport();">Print</button>

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/ModalDetail2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/PrintReport.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">

<script type="text/javascript">
    $(document).ready(function () {
        displayData();

        var dropdownBuildingName = new Choices(document.querySelector("#buildingName"));
        var dropdownCategoryEmployee = new Choices(document.querySelector("#categoryEmployee"));

        // Attach change event listeners to checkboxes and other inputs
        $(".EmploymentStatus, .employeeType").change(function(){
            triggerDataFetch();
        });

        $("#date1, #date2, #dateField").change(function(){
            triggerDataFetch();
        });

        $("#buildingName, #categoryEmployee").change(function(){
            triggerDataFetch();
        });

        // Remove the Search button click handler as it's no longer needed
        // $("#btnsearch").click(function(){
        //     triggerDataFetch();
        // });

        $("#btnreset").click(function(){
            $("#date1").val('');
            $("#date2").val('');
            $("#dateField").val('');
            dropdownBuildingName.setChoiceByValue('');
            dropdownCategoryEmployee.setChoiceByValue('');
            $('.EmploymentStatus').prop('checked', false);
            $('.employeeType').prop('checked', false);
            $('#showdate').html('កាលបរិច្ឆេទស្រង់របាយការណ៍: ' + getCurrentDate());
            $('#reportDetailsValue').html('ទាំងអស់');
            fetchReportData();
        });

        $("#btnexport").click(function(){
            var date1 = $("#date1").val();
            var date2 = $("#date2").val();
            var dateField = $("#dateField").val();
            var buildingName = $("#buildingName").val();
            var categoryEmployeeName = $("#categoryEmployee").val();

            // Collect checked employment statuses
            var statusNames = [];
            $(".EmploymentStatus:checked").each(function(){
                statusNames.push($(this).val());
            });

            // Collect checked employee types
            var employeeTypes = [];
            $(".employeeType:checked").each(function(){
                employeeTypes.push($(this).val());
            });

            // Capture the sorting order from DataTable
            var table = $('#dataTable').DataTable();
            var order = table.order();
            var sortColumn = order[0][0]; // Column index
            var sortDirection = order[0][1]; // Sorting direction: asc/desc

            var url = '{{ route("EmployedReport.exportEmployedReport_Detail") }}';
            var params = [];
            if (date1 && date2) {
                params.push('date1=' + date1);
                params.push('date2=' + date2);
                params.push('dateField=' + dateField);
            }
            if (buildingName) {
                params.push('BuildingName=' + buildingName);
            }
            if (statusNames.length > 0) {
                statusNames.forEach(function(status){
                    params.push('EmploymentStatus[]=' + encodeURIComponent(status));
                });
            }
            if (categoryEmployeeName) {
                params.push('CategoryEmployeeName=' + categoryEmployeeName);
            }
            if (employeeTypes.length > 0) {
                employeeTypes.forEach(function(type){
                    params.push('employeeType[]=' + encodeURIComponent(type));
                });
            }
            // Add sorting parameters to the export URL
            params.push('sortColumn=' + sortColumn);
            params.push('sortDirection=' + sortDirection);

            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            window.location.href = url;
        });

        function triggerDataFetch() {
            var date1 = $("#date1").val();
            var date2 = $("#date2").val();
            var dateField = $("#dateField").val();
            var buildingName = $("#buildingName").val();
            var categoryEmployeeName = $("#categoryEmployee").val();

            // Collect checked employment statuses
            var employmentStatus = [];
            $(".EmploymentStatus:checked").each(function(){
                employmentStatus.push($(this).val());
            });

            // Collect checked employee types
            var employeeType = [];
            $(".employeeType:checked").each(function(){
                employeeType.push($(this).val());
            });

            var dateFieldText = $("#dateField option:selected").text();
            
            if (date1 && date2) {
                $('#showdate').html(dateFieldText + ': ' + date1 + ' ដល់ ' + date2);
            } else {
                $('#showdate').html('កាលបរិច្ឆេទស្រង់របាយការណ៍: ' + getCurrentDate());
            }
            
            var reportDetails = [];
            if (buildingName) reportDetails.push('អាគារ: ' + buildingName);
            if (employmentStatus.length > 0) reportDetails.push('ស្ថានភាពការងារ: ' + employmentStatus.join(', '));
            if (categoryEmployeeName) reportDetails.push('អនុប្រភេទ: ' + categoryEmployeeName);
            if (employeeType.length > 0) {
                employeeType.forEach(function(type) {
                    if (type === 'GovernmentEmployedDoctor') {
                        reportDetails.push('ប្រភេទ: មន្ត្រីសុខាភិបាលក្របខណ្ឌ');
                    } else if (type === 'HiredMedicalOfficer') {
                        reportDetails.push('ប្រភេទ: ជួល/កិច្ចសន្យា&វេជ្ជសាស្ត្រ');
                    } else if (type === 'HiredNotMedicalOfficer') {
                        reportDetails.push('ប្រភេទ: ជួល/កិច្ចសន្យា&មិនមែនវេជ្ជសាស្ត្រ');
                    } else {
                        reportDetails.push('ប្រភេទ: ' + type);
                    }
                });
            }
            $('#reportDetailsValue').html(reportDetails.join(', ') || '.....');
            
            fetchReportData(date1, date2, dateField, buildingName, employmentStatus, categoryEmployeeName, employeeType);
        }

    });

    function displayData() {
        fetchReportData();
    }

    function getCurrentDate() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        return dd + '-' + mm + '-' + yyyy;
    }

    function fetchReportData(date1 = '', date2 = '', dateField = '', buildingName = '', employmentStatus = [], categoryEmployeeName = '', employeeType = []) {
        var url = '{{ route("EmployedReport.getEmployedReport_Detail") }}';
        var params = [];
        if (date1 && date2) {
            params.push('date1=' + encodeURIComponent(date1));
            params.push('date2=' + encodeURIComponent(date2));
            params.push('dateField=' + encodeURIComponent(dateField));
        }

        if (buildingName) {
            params.push('BuildingName=' + encodeURIComponent(buildingName));
        }

        if (employmentStatus && employmentStatus.length > 0) {
            employmentStatus.forEach(function(status){
                params.push('EmploymentStatus[]=' + encodeURIComponent(status));
            });
        }

        if (categoryEmployeeName) {
            params.push('CategoryEmployeeName=' + encodeURIComponent(categoryEmployeeName));
        }

        if (employeeType && employeeType.length > 0) {
            employeeType.forEach(function(type){
                params.push('employeeType[]=' + encodeURIComponent(type));
            });
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                // Show a loading indicator if needed
            },
            success: function (data) {
                if (data && data.length > 0) {
                    var str = "<table id='dataTable' border='1' class='table table-striped'>" +
                        "<thead>" +
                        "<tr>" +
                        "<th>ល.រ</th>" +
                        "<th>នាមនិងគោត្តនាម</th>" +
                        "<th>អក្សរឡាតាំង</th>" +
                        "<th>ភេទ</th>" +
                        "<th>ថ្ងៃខែឆ្នាំកំណើត</th>" +
                        "<th>ថ្ងៃខែឆ្នាំចូលបម្រើការងារ</th>" +
                        "<th>ថ្ងៃខែឆ្នាំចូលកាន់មុខតំណែងបច្ចុប្បន្ន</th>" +
                        "<th>ថ្ងៃខែឆ្នាំចូលនិវត្តន៍</th>" +
                        "<th>តួនាទី</th>" +
                        "<th>ជំនាញ/ឯកទេស</th>" +
                        "<th>អាគារ</th>" +
                        "<th>ស្ថានភាពការងារ</th>" +
                        "<th>ប្រភេទបុគ្គលិក</th>" +
                        "<th>លេខសម្គាល់</th>" +
                        "</tr>" +
                        "</thead><tbody>";

                    data.forEach(function (employee, index) {
                        str += "<tr>";
                        str += "<td>" + (index + 1) + "</td>";
                        str += "<td>" + (employee.FirstName || '') + " " + (employee.LastName || '') + "</td>";
                        str += "<td>" + (employee.LatinName || '') + "</td>";
                        str += "<td>" + (employee.Gender || '') + "</td>";
                        str += "<td>" + (employee.DateOfBirth || '') + "</td>";
                        str += "<td>" + (employee.GedStartDate || employee.HmoStartDate || employee.HnmoStartDate || '') + "</td>";
                        str += "<td>" + (employee.GedCurrentPositionDate || employee.HmoCurrentPositionDate || employee.HnmoCurrentPositionDate || '') + "</td>";
                        str += "<td>" + (employee.GedEndDate || employee.HmoEndDate || employee.HnmoEndDate || '') + "</td>";
                        str += "<td>" + (employee.PositionName || '') + "</td>";
                        str += "<td>" + (employee.DepartmentName || employee.SkillName || '') + "</td>";
                        str += "<td>" + (employee.BuildingName || '') + "</td>";
                        str += "<td>" + (employee.StatusName || '') + "</td>";
                        str += "<td>" + (employee.CategoryEmployeeName || '') + "</td>";
                        str += "<td>" + (employee.ID || '') + "</td>";
                        str += "</tr>";
                    });
                    str += "</tbody><tfoot><tr><th colspan='12'>Total Employees</th><th>" + data.length + "</th></tr></tfoot>";
                    str += "</table>";
                    $("#display").html(str);

                    // Initialize DataTables after rendering the table
                    $('#dataTable').DataTable({
                        destroy: true, // Destroy any existing table to avoid duplicates
                        columnDefs: [
                            { targets: [ 13], visible: false } // Hide columns 12 and 13
                        ],
                        language: {
                            search: "",
                            lengthMenu: "បង្ហាញ _MENU_ ធាតុ",
                            info: "បង្ហាញពី _START_ ដល់ _END_ នៃ _TOTAL_ ធាតុ",
                            paginate: {
                                first: "ដំបូង",
                                last: "ចុងក្រោយ",
                                next: "បន្ទាប់",
                                previous: "ថយក្រោយ"
                            },
                            searchPlaceholder: "ស្វែងរក..."
                        },
                        initComplete: function () {
                            $('.dataTables_filter input').addClass('custom-font00B');
                            $('.dataTables_filter input').css({
                                'font-size': '12px',
                                'font-family': '"Khmer os battambang", sans-serif',
                                'color': 'red'
                            });
                            $('.dataTables_filter input').attr('placeholder', 'ស្វែងរក...');
                            $('.dataTables_filter input').attr('style', 'text-align: left;');
                            $('.dataTables_filter').css('text-align', 'right');
                        }
                    });
                } else {
                    $("#display").html("<p>គ្មានទិន្នន័យត្រូវបានរកឃើញទេ។</p>");
                }
            },
            error: function (ex) {
                console.error(ex.responseText);
                $("#display").html("<p>មិនទទួលបានទិន្នន័យទេ។</p>");
            },
            complete: function() {
                // Hide the loading indicator if needed
            }
        });
    }

    function PrintReport() {
        $('#div_print').printThis({
            importCSS: false,
            importStyle: true,
            loadCSS: '{{ asset("css/custom-print-style3.css") }}',
            header: "<h3 style='text-align: center; font-family: \"Khmer M1\", sans-serif;'>របាយការណ៍</h3>",
            beforePrint: function() {
                $('.dataTables_info, .dataTables_paginate, .dataTables_length, .dataTables_filter').hide();
            },
            afterPrint: function() {
                $('.dataTables_info, .dataTables_paginate, .dataTables_length, .dataTables_filter').show();
            }
        });
    }

</script>
@endpush
@endsection
