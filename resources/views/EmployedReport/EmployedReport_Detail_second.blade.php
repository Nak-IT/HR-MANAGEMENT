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
    <h2 class="modal-title custom-font007BB text3D">របាយការណ៍បែបបទទី២</h2>
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
                <label for="categoryEmployee" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷ជ្រើសរើសផ្នែក/អាគារ</label>
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
                    <option value="">ជ្រើសរើសប្រភេទបុគ្គលិក</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->CategoryEmployeeName }}">{{ $category->CategoryEmployeeName }}</option>
                    @endforeach
                </select>
            </div>
        </div> <br>

        <div class="form-group row justify-content-center">

            <div class="col-sm-6">
                <div style="border: 2px dashed #87ceeb; border-radius: 15px; padding: 15px; background-color: #f0f8ff;">
                    <label for="categoryEmployee" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ធីកប្រភេទបុគ្គលិក</label>
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
                    <label for="categoryEmployee" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ធីកស្ថានភាពការងារ</label>
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

        <!-- Add Employee Type Selection -->
        <!-- <div class="form-group row justify-content-center">
            <div class="col-sm-5">
                <label>ជ្រើសរើសប្រភេទបុគ្គលិក (Employee Type)</label>
                <div>
                    <input type="checkbox" name="employeeType[]" value="GovernmentEmployedDoctor" class="employeeType"> មន្ត្រីសុខាភិបាលក្របខណ្ឌ<br>
                    <input type="checkbox" name="employeeType[]" value="HiredMedicalOfficer" class="employeeType"> វេជ្ជបណ្ឌិតជួល<br>
                    <input type="checkbox" name="employeeType[]" value="HiredNotMedicalOfficer" class="employeeType"> មិនមែនវេជ្ជបណ្ឌិតជួល<br>
                </div>
            </div>
        </div> -->

        <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnsearch">
                <i class="fa fa-search"></i> ចុចច្រោះរកទិន្នន័យ
            </button>
            <button type="button" class="btn btn-secondary" id="btnreset">
                <i class="fa fa-refresh"></i> ត្រឡប់ឡើងវិញ
            </button>
            <button type="button" class="btn btn-success" id="btnexport">
                <i class="fa fa-file-excel-o"></i> នាំចេញទៅ Excel(១)
            </button>
            <button type="button" class="btn btn-success" id="btnexport_third">
                <i class="fa fa-file-excel-o"></i> នាំចេញទៅ Excel(២)
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
        // var dropdownEmploymentStatus = new Choices(document.querySelector("#EmploymentStatus")); // Removed since EmploymentStatus is now checkboxes
        var dropdownCategoryEmployee = new Choices(document.querySelector("#categoryEmployee"));

        $("#btnsearch").click(function(){
            searchAndFetchData();
        });

        $("#btnreset").click(function(){
            $("#date1").val('');
            $("#date2").val('');
            $("#dateField").val('');
            dropdownBuildingName.setChoiceByValue('');
            // Reset EmploymentStatus checkboxes
            $("input[name='EmploymentStatus[]']:checked").prop("checked", false);
            dropdownCategoryEmployee.setChoiceByValue('');
            $("input[name='employeeType[]']:checked").prop("checked", false);
            $('#showdate').html('កាលបរិច្ឆេទស្រង់របាយការណ៍: ' + getCurrentDate());
            $('#reportDetailsValue').html('ទាំងអស់');
            fetchReportData();
        });

        $("#btnexport").click(function(){
            exportData('{{ route("EmployedReport.exportEmployedReport_Detail_second") }}');
        });

        $("#btnexport_third").click(function(){
            exportData('{{ route("EmployedReport.exportEmployedReport_Detail_second_third") }}');
        });

        // Add event listener for checkbox changes
        $("input[name='employeeType[]'], input[name='EmploymentStatus[]']").change(function(){
            searchAndFetchData();
        });

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

    function searchAndFetchData() {
        var date1 = $("#date1").val();
        var date2 = $("#date2").val();
        var dateField = $("#dateField").val();
        var buildingName = $("#buildingName").val();
        var categoryEmployeeName = $("#categoryEmployee").val();
        var dateFieldText = $("#dateField option:selected").text();

        // Capture selected Employment Statuses
        var employmentStatuses = [];
        $("input[name='EmploymentStatus[]']:checked").each(function() {
            employmentStatuses.push($(this).val());
        });

        // Capture selected Employee Types
        var employeeTypes = [];
        $("input[name='employeeType[]']:checked").each(function() {
            employeeTypes.push($(this).val());
        });

        if (date1 && date2) {
            $('#showdate').html(dateFieldText + ': ' + date1 + ' ដល់ ' + date2);
        } else {
            $('#showdate').html('កាលបរិច្ឆេទស្រង់របាយការណ៍: ' + getCurrentDate());
        }

        var reportDetails = [];
        if (buildingName) reportDetails.push('អាគារ: ' + buildingName);
        if (employmentStatuses.length > 0) {
            reportDetails.push('ស្ថានភាពការងារ: ' + employmentStatuses.join(', '));
        }
        if (categoryEmployeeName) reportDetails.push('ប្រភេទបុគ្គលិក: ' + categoryEmployeeName);
        if (employeeTypes && employeeTypes.length > 0) {
            employeeTypes.forEach(function(type) {
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

        fetchReportData(date1, date2, dateField, buildingName, employmentStatuses, categoryEmployeeName, employeeTypes);
    }

    function fetchReportData(date1 = '', date2 = '', dateField = '', buildingName = '', employmentStatuses = [], categoryEmployeeName = '', employeeTypes = []) {
        var url = '{{ route("EmployedReport.getEmployedReport_Detail_second") }}';
        var params = [];
        if (date1 && date2) {
            params.push('date1=' + encodeURIComponent(date1));
            params.push('date2=' + encodeURIComponent(date2));
            params.push('dateField=' + encodeURIComponent(dateField));
        }

        if (buildingName) {
            params.push('BuildingName=' + encodeURIComponent(buildingName));
        }

        if (employmentStatuses && employmentStatuses.length > 0) {
            employmentStatuses.forEach(function(status) {
                params.push('EmploymentStatus[]=' + encodeURIComponent(status));
            });
        }

        if (categoryEmployeeName) {
            params.push('CategoryEmployeeName=' + encodeURIComponent(categoryEmployeeName));
        }
        if (employeeTypes && employeeTypes.length > 0) {
            employeeTypes.forEach(function(type) {
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
            success: function (data) {
                if (data && data.length > 0) {
                    var str = "<table id='dataTable' border='1' class='table table-striped'>" +
                        "<thead>" +
                        "<tr>" +
                        "<th rowspan='2'>ល.រ</th>" +
                        "<th rowspan='2'>នាមនិងគោត្តនាម</th>" +
                        "<th rowspan='2'>អក្សរឡាតាំង</th>" +
                        "<th rowspan='2'>ភេទ</th>" +
                        "<th colspan='3' style='text-align: center;'>កាលបរិច្ឆេទ</th>" +
                        "<th rowspan='2'>តំណែងបច្ចុប្បន្ន</th>" +
                        "<th rowspan='2'>ប្រភេទក្របខណ្ឌ</th>" +
                        "<th rowspan='2'>សញ្ញាបត្រ</th>" +
                        "<th rowspan='2'>ជំនាញ/ឯកទេស</th>" +
                        "<th rowspan='2'>គ្រឹស្ថានសិក្សា</th>" +
                        "<th rowspan='2'>ប្រទេស</th>" +
                        "<th rowspan='2'>អាគារ</th>" +
                        "<th rowspan='2'>លេខទូរស័ព្ទ</th>" +
                        "<th rowspan='2'>ស្ថានភាពការងារ</th>" +
                        "<th rowspan='2'>ប្រភេទបុគ្គលិក</th>" +
                        "<th colspan='2' style='text-align: center;'>កាលបរិច្ឆេទកិច្ចសន្យា</th>" +
                        "</tr>" +
                        "<tr>" +
                        "<th>កំណើត</th>" +
                        "<th>ចូលបម្រើការងារ</th>" +
                        "<th>ចូលនិវត្តន៍</th>" +
                        "<th>ចូលកិច្ចសន្យា</th>" +
                        "<th>បញ្ចប់កិច្ចសន្យា</th>" +
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
                        str += "<td>" + (employee.GedEndDate || employee.HmoEndDate || employee.HnmoEndDate ||  'មិនទាន់បញ្ចូល') + "</td>";
                        str += "<td>" + (employee.PositionName || '') + "</td>";
                        str += "<td>" + (employee.EmploymentCategory || 'មិនមែនក្របខណ្ឌ') + "</td>";
                        str += "<td>" + (employee.Degree || 'មិនទាន់បញ្ចូល') + "</td>";
                        str += "<td>" + (employee.DepartmentName || employee.SkillName || '') + "</td>";
                        str += "<td>" + (employee.School || 'មិនទាន់បញ្ចូល') + "</td>";
                        str += "<td>" + (employee.Country || 'មិនទាន់បញ្ចូល') + "</td>";
                        str += "<td>" + (employee.BuildingName || '') + "</td>";
                        str += "<td>" + (employee.Phone || '') + "</td>";
                        str += "<td>" + (employee.StatusName || '') + "</td>";
                        str += "<td>" + (employee.CategoryEmployeeName || '') + "</td>";
                        str += "<td>" + (employee.HmoStartDate || employee.HnmoStartDate ||  '') + "</td>";
                        str += "<td>" + (employee.HmoEndDate || employee.HnmoEndDate ||  'មិនទាន់បញ្ចូល') + "</td>";
                        str += "</tr>";
                    });
                    str += "</tbody>";

                    // Use '__COLSPAN__' as the placeholder
                    str += "</tbody><tfoot><tr><th colspan='@{{COLSPAN}}'>សារុប</th><th style='font-family: \"Khmer M1\", sans-serif; color: #007bff;'>" + formatKhmerNumber(data.length) + " នាក់</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot>";
                    str += "</table>";

                    function formatKhmerNumber(number) {
                        var khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                        return number.toString().split('').map(function(digit) {
                            return khmerDigits[parseInt(digit)];
                        }).join('');
                    }

                    // Append the table to the display div
                    $("#display").html(str);

                    // Now, after the table is in the DOM, calculate total columns
                    var totalColumns = $('#dataTable thead tr:first th').length;

                    // Subtract one for the 'Total Employees' count column
                    var colspan = totalColumns - 1;

                    // Replace the placeholder with the actual colspan value
                    $('#dataTable tfoot th[colspan="__COLSPAN__"]').attr('colspan', colspan);

                    // Determine columns to hide based on selected employeeTypes
                    var columnsToHide = [];

                    // If no employeeTypes are selected, assume all types are selected
                    if (!employeeTypes || employeeTypes.length === 0) {
                        employeeTypes = ['GovernmentEmployedDoctor', 'HiredMedicalOfficer', 'HiredNotMedicalOfficer'];
                        columnsToHide = columnsToHide.concat([4,5, 6,7,8,9,10,11,12,13,14, 17, 18]);
                    }

                    // If 'GovernmentEmployedDoctor' is NOT selected, hide columns 4, 5, 6
                    if (!employeeTypes.includes('GovernmentEmployedDoctor')) {
                       
                        columnsToHide = columnsToHide.concat([4, 5, 6,8,9,11,12,14,15,16]);
                    }

                    // If neither 'HiredMedicalOfficer' nor 'HiredNotMedicalOfficer' is selected, hide columns 17, 18
                    if (!employeeTypes.includes('HiredMedicalOfficer') && !employeeTypes.includes('HiredNotMedicalOfficer')) {
                        columnsToHide = columnsToHide.concat([17, 18]);
                        columnsToHide = columnsToHide.concat([15, 16, 17, 18]);
                    }

                    // Remove duplicates from columnsToHide
                    columnsToHide = [...new Set(columnsToHide)];

                    // Build columnDefs
                    var columnDefs = [];
                    if (columnsToHide.length > 0) {
                        columnDefs.push({ targets: columnsToHide, visible: false });
                    }

                    // Destroy existing DataTable if it exists
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().destroy();
                    }

                    // Initialize DataTable
                    $('#dataTable').DataTable({
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
                        },
                        columnDefs: columnDefs
                    });
                } else {
                    $("#display").html("<p>គ្មានទិន្នន័យត្រូវបានរកឃើញទេ។</p>");
                }
            },
            error: function (ex) {
                console.error(ex.responseText);
                $("#display").html("<p>មិនទទួលបានទិន្នន័យទេ។</p>");
            }
        });
    }

    function exportData(url) {
        var date1 = $("#date1").val();
        var date2 = $("#date2").val();
        var dateField = $("#dateField").val();
        var buildingName = $("#buildingName").val();
        var categoryEmployeeName = $("#categoryEmployee").val();
        var employeeTypes = [];
        $("input[name='employeeType[]']:checked").each(function() {
            employeeTypes.push($(this).val());
        });

        // Capture selected Employment Statuses
        var employmentStatuses = [];
        $("input[name='EmploymentStatus[]']:checked").each(function() {
            employmentStatuses.push($(this).val());
        });

        // Capture the sorting order from DataTable
        var table = $('#dataTable').DataTable();
        var order = table.order();
        var sortColumn = order[0][0]; // Column index
        var sortDirection = order[0][1]; // Sorting direction: asc/desc

        var params = [];
        if (date1 && date2) {
            params.push('date1=' + date1);
            params.push('date2=' + date2);
            params.push('dateField=' + dateField);
        }
        if (buildingName) {
            params.push('BuildingName=' + buildingName);
        }
        if (employmentStatuses && employmentStatuses.length > 0) {
            employmentStatuses.forEach(function(status) {
                params.push('EmploymentStatus[]=' + encodeURIComponent(status));
            });
        }
        if (categoryEmployeeName) {
            params.push('CategoryEmployeeName=' + categoryEmployeeName);
        }
        if (employeeTypes && employeeTypes.length > 0) {
            employeeTypes.forEach(function(type) {
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
