@extends('layout.layout')

@section('content')
<div class="container mt-5" style="border: 2px dashed #87ceeb; border-radius: 15px; padding: 15px; background-color: #e6f3ff;">
    <div class="d-flex align-items-center justify-content-center mb-3">
        <span style="font-size: 54px; margin-right: 10px;">📊</span>
        <h2 class="modal-title custom-font007 text3D m-0" style="color: #FF69B4;">ក្រាហ្វិកបង្ហាញពីបុគ្គលិកដែលបម្រើការងារ</h2>
        <span style="font-size: 54px; margin-left: 10px;">📈</span>
    </div>
  
    <br><br>

    <div class="text-center custom-font00B">
        <!-- តម្រង -->
        <div class="form-group row justify-content-center">
            <div class="col-sm-4">
                <label for="dateField" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶 ជ្រើសរើសកាលបរិច្ឆេទតម្រងទិន្នន័យ</label>
                <select id="dateField" class="form-control custom-font011 text-center">
                <option value="">ជ្រើសរើសទិន្នន័យតាមរយៈ..</option>
                    <option value="StartDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលបម្រើការងារ</option>
                    <option value="EndDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលនិវត្តន៍</option>
                    <option value="CurrentPositionDate">ច្រោះទិន្នន័យ តាមរយៈថ្ងៃចូលកាន់មុខតំណែងបច្ចុប្បន្ន</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="date1" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶 ចាប់ពីថ្ងៃ:</label>
                <input type="date" id="date1" class="form-control" />
            </div>
            <div class="col-sm-4">
                <label for="date2" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔶 ដល់ថ្ងៃ:</label>
                <input type="date" id="date2" class="form-control" />
            </div>
        </div> <br>

        <div class="form-group row justify-content-center">
        <div class="col-sm-4">
                <label for="groupBy" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷 ចងជាក្រុម</label>
                <select id="groupBy" class="form-control">
                    <option value="" selected disabled style="color: gray;text-align: center;">-- ជ្រើសរើសចងជាក្រុម --</option>
                    <option value="Building">ផ្នែក/អាគារ</option>
                    <option value="EmploymentStatus">ស្ថានភាពការងារ</option>
                    <option value="EmployeeType">ប្រភេទបុគ្គលិក</option>
                    <option value="CategoryEmployeeName">អនុប្រភេទ</option>
                    <option value="Gender">ភេទ</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="buildingName" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷 ជ្រើសរើសផ្នែក/អាគារ</label>
                <select id="buildingName" class="form-control">
                    <option value="">ជ្រើសរើសផ្នែក/អាគារ</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->BuildingName }}">{{ $building->BuildingName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <label for="categoryEmployee" style="font-family: 'Khmer os battambang', sans-serif; color: black;">🔷 ជ្រើសរើសអនុប្រភេទ</label>
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
                    <label for="employeeType" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ ធីកប្រភេទបុគ្គលិក</label>
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
                    <label for="EmploymentStatus" style="font-family: 'Khmer os battambang', sans-serif; color: black;">✅ ធីកស្ថានភាពការងារ</label>
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

        <button type="button" class="btn btn-primary" id="btnFilter">
            <i class="fa fa-search"></i> ច្រោះទិន្នន័យ
        </button>
        <button type="button" class="btn btn-secondary" id="btnreset">
            <i class="fa fa-refresh"></i> កំណត់ឡើងវិញ
        </button>
    </div>
</div>

<div class="containerB custom-font006 " >
    


    <p align="center" style="border: 2px solid #ff9ff3; border-radius: 10px; padding: 10px; background-color: #ffeaa7; width: 60%; margin: 0 auto; font-size: 23px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <button class="button" id="btnline" style="background-color: #4CAF50; color: white;">ក្រាហ្វិកបន្ទាត់</button>
        <button class="button button2" id="btncolumn" style="background-color: #008CBA; color: white;">ក្រាហ្វិកសសរ</button>
        <button class="button button3" id="btnpie" style="background-color: #f44336; color: white;">ក្រាហ្វិកផាយ</button>
        <button class="button button5" id="btndoughnut" style="background-color: #555555; color: white;">ក្រាហ្វិកដូណាត់</button>
        <button class="button button4" id="btnarea" style="background-color: #66bb6a; color: white;">ក្រាហ្វិកផ្ទៃ</button>
        <button class="button button6" id="btnspline" style="background-color: #29b6f6; color: white;">ក្រាហ្វិកខ្សែកោង</button>
        <button class="button button7" id="btnstackedcolumn" style="background-color: #ef5350; color: white;">ក្រាហ្វិកសសរដាក់ជាន់គ្នា</button>
        <button class="button button10" id="btnstackedbar" style="background-color: #ffa726; color: white;">ក្រាហ្វិកបន្ទាត់ផ្តេកដាក់ជាន់គ្នា</button>
        <button class="button button11" id="btnstackedarea" style="background-color: #ab47bc; color: white;">ក្រាហ្វិកផ្ទៃដាក់ជាន់គ្នា</button>
    </p>

    <div id="chartContainer" style="height: 500px; width: 65%; margin: 0 auto;"></div>

    <div id="div_print">
        <p style="text-align: center;"> 
            <span id="showdate">កាលបរិច្ឆេទស្រង់រូបក្រាហ្វិក: {{ date('d-m-Y') }}</span>
            <br>
            <span id="showReportDetails">ស្រង់រូបក្រាហ្វិកតាមរយៈ: <span id="reportDetailsValue"></span></span>
        </p>
        <div id="chartPrintContainer"></div>
        <h1>&nbsp;</h1>
        <p style="text-align: right; padding-right:25%;">រៀបចំដោយ </p>
        <p style="text-align: right; padding-right:25%;">ឈ្មោះ ៖ </p>
    </div>


    <button type="button" style="width:150px;" id="btnprint" class="btn btn-success">បោះពុម្ព</button>
</div>

@push('styles')
<style>
    /* បន្ថែមរចនាបថសម្រាប់ប៊ូតុងថ្មី */
    .button {
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin: 5px;
    }
    .button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0,0,0,0.15);
    }
    .button4 {background-color: #66bb6a;} /* បៃតង */
    .button6 {background-color: #29b6f6;} /* ខៀវ */
    .button7 {background-color: #ef5350;} /* ក្រហម */
    .button10 {background-color: #ffa726;} /* ទឹកក្រូច */
    .button11 {background-color: #ab47bc;} /* ស្វាយ */

    .containerB {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        
    }
    .containerB:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    #chartPrintContainer {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/canvasjs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/PrintReport.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
    $(document).ready(function () {
        // ចាប់ផ្តើម Choices.js សម្រាប់ dropdown buildingName និង categoryEmployee
        var dropdownBuildingName = new Choices(document.querySelector("#buildingName"));
        var dropdownCategoryEmployee = new Choices(document.querySelector("#categoryEmployee"));

        renderChart("column");

        $("#btnFilter").click(function () {
            renderChart(currentChartType);
        });

        $("#btnreset").click(function () {
            // កំណត់ឡើងវិញនូវគ្រប់វាលទាំងអស់
            $("#dateField").val("");
            $("#date1").val("");
            $("#date2").val("");
            dropdownBuildingName.setChoiceByValue("");
            dropdownCategoryEmployee.setChoiceByValue("");
            $("#groupBy").val("Building");
            $(".employeeType").prop("checked", false);
            $(".EmploymentStatus").prop("checked", false);
            
            // កំណត់ឡើងវិញនូវ container សម្រាប់បោះពុម្ពក្រាហ្វិក
            $("#chartPrintContainer").html('');
            
            // បង្ហាញក្រាហ្វិកឡើងវិញជាមួយនឹងការកំណត់ដើម
            renderChart("column");
        });

        // បន្ថែមព្រឹត្តិការណ៍ចុចសម្រាប់ប៊ូតុងប្រភេទក្រាហ្វិក
        $("#btnline").click(function () {
            renderChart("line");
        });

        $("#btncolumn").click(function () {
            renderChart("column");
        });

        $("#btnpie").click(function () {
            renderChart("pie");
        });

        $("#btndoughnut").click(function () {
            renderChart("doughnut");
        });

        $("#btnarea").click(function () {
            renderChart("area");
        });

        $("#btnspline").click(function () {
            renderChart("spline");
        });

        $("#btnstackedcolumn").click(function () {
            renderChart("stackedColumn");
        });

        $("#btnstackedbar").click(function () {
            renderChart("stackedBar");
        });

        $("#btnstackedarea").click(function () {
            renderChart("stackedArea");
        });

        $("#btnprint").click(function() {
            // ចាប់យកក្រាហ្វិកជារូបភាព
            var chartContainer = document.getElementById("chartContainer");
            html2canvas(chartContainer).then(function(canvas) {
                var chartImage = canvas.toDataURL('image/png');
                $("#chartPrintContainer").html('<img src="' + chartImage + '" style="width:100%;">');
                
                // ពន្យារពេលការបោះពុម្ពដើម្បីធានាថារូបភាពត្រូវបានផ្ទុក
                setTimeout(function() {
                    PrintReport();
                }, 100);
            });
        });
    });

    var currentChartType = "column";
    var chart;

    function renderChart(type) {
        currentChartType = type;
        var date1 = $("#date1").val();
        var date2 = $("#date2").val();
        var dateField = $("#dateField").val();
        var buildingName = $("#buildingName").val();
        var categoryEmployeeName = $("#categoryEmployee").val();
        var groupBy = $("#groupBy").val();

        // ប្រមូលស្ថានភាពការងារដែលបានជ្រើសរើស
        var employmentStatus = [];
        $(".EmploymentStatus:checked").each(function(){
            employmentStatus.push($(this).val());
        });

        // ប្រមូលប្រភេទបុគ្គលិកដែលបានជ្រើសរើស
        var employeeType = [];
        $(".employeeType:checked").each(function(){
            employeeType.push($(this).val());
        });

        var params = {};
        if(date1) params['date1'] = date1;
        if(date2) params['date2'] = date2;
        if(dateField) params['dateField'] = dateField;
        if(buildingName) params['BuildingName'] = buildingName;
        if(categoryEmployeeName) params['CategoryEmployeeName'] = categoryEmployeeName;
        if(employmentStatus.length > 0) params['EmploymentStatus'] = employmentStatus;
        if(employeeType.length > 0) params['employeeType'] = employeeType;
        if(groupBy) params['groupBy'] = groupBy;

        $.ajax({
            type: "GET",
            url: "{{ route('chart.getEmployedChartData') }}",
            data: params,
            dataType: "json",
            success: function (all_data) {
                var dataPoints = [];
                var groupFieldMapping = {
                    'Building': 'BuildingName',
                    'EmploymentStatus': 'StatusName',
                    'EmployeeType': 'EmployeeType',
                    'CategoryEmployeeName': 'CategoryEmployeeName',
                    'Gender': 'Gender'
                };
                var groupField = groupFieldMapping[groupBy] || 'BuildingName';

                all_data.forEach(function(item) {
                    var label = item[groupField];
                    var total = Number(item.total_quantity);

                    dataPoints.push({ y: total, label: label });
                });

                var groupByKhmer = {
                    'Building': 'ផ្នែក/អាគារ',
                    'EmploymentStatus': 'ស្ថានភាពការងារ',
                    'EmployeeType': 'ប្រភេទបុគ្គលិក',
                    'CategoryEmployeeName': 'អនុប្រភេទ',
                    'Gender': 'ភេទ'
                };

                var chartOptions = {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "បុគ្គលិកដែលបម្រើការងារតាមរយៈ " + (groupByKhmer[groupBy] || "មិនទាន់ជ្រើសរើសចងជាក្រុម"),
                        fontFamily: "Khmer OS Battambang",
                        fontSize: 14,
                        fontColor: "#000000",
                        padding: 15,
                        margin: 15,
                        borderThickness: 2,
                        borderColor: "#87CEEB",
                        cornerRadius: 5,
                        backgroundColor: "#F0F8FF"
                    },
                    axisY: {
                        title: "ចំនួន",
                        titleFontFamily: "Khmer OS Battambang",
                        labelFontFamily: "Khmer OS Battambang"
                    },
                    axisX: {
                        title: groupByKhmer[groupBy] || "មិនទាន់ជ្រើសរើសចងជាក្រុម",
                        interval: 1,
                        titleFontFamily: "Khmer OS Battambang",
                        labelFontFamily: "Khmer OS Battambang"
                    },
                    data: [{
                        type: type,
                        dataPoints: dataPoints
                    }],
                    legend: {
                        fontFamily: "Khmer OS Battambang"
                    }
                };

                // កែសម្រួលជម្រើសក្រាហ្វិកអាស្រ័យលើប្រភេទ
                if (type === "pie" || type === "doughnut") {
                    chartOptions.data[0].showInLegend = true;
                    chartOptions.data[0].legendText = "{label}";
                    chartOptions.data[0].indexLabel = "{label}: {y}";
                    if (type === "doughnut") {
                        chartOptions.data[0].innerRadius = "40%";
                    }
                } else if (type === "scatter") {
                    // កែសម្រួលសម្រាប់ក្រាហ្វិកខ្ចាយ
                    chartOptions.data[0].type = "scatter";
                    chartOptions.data[0].toolTipContent = "<span style='\"'color: {color};'\"'><strong>{label}</strong></span><br/><strong>ចំនួន:</strong> {y}";
                    chartOptions.axisX.title = "ប្រភេទ";
                } else if (type === "bubble") {
                    // កែសម្រួលសម្រាប់ក្រាហ្វិកពពុះ
                    chartOptions.data[0].type = "bubble";
                    chartOptions.data[0].toolTipContent = "<span style='\"'color: {color};'\"'><strong>{label}</strong></span><br/><strong>ចំនួន:</strong> {y}<br/><strong>ទំហំ:</strong> {z}";
                    chartOptions.axisX.title = "ប្រភេទ";
                    // បន្ថែមទំហំចៃដន្យសម្រាប់ពពុះនីមួយៗ
                    dataPoints.forEach(function(point) {
                        point.z = Math.random() * 40 + 10;
                    });
                }

                chart = new CanvasJS.Chart("chartContainer", chartOptions);
                chart.render();

                // ធ្វើបច្ចុប្បន្នភាពព័ត៌មានលម្អិតនៃរបាយការណ៍
                var dateFieldText = $("#dateField option:selected").text();
                
                if (date1 && date2) {
                    $('#showdate').html(dateFieldText + ': ' + date1 + ' ដល់ ' + date2);
                } else {
                    $('#showdate').html('កាលបរិច្ឆេទស្រង់រូបក្រាហ្វិក: ' + getCurrentDate());
                }
                
                var reportDetails = [];
                if (buildingName) reportDetails.push('អាគារ: ' + buildingName);
                if (employmentStatus.length > 0) reportDetails.push('ស្ថានភាពការងារ: ' + employmentStatus.join(', '));
                if (categoryEmployeeName) reportDetails.push('អនុប្រភេទ: ' + categoryEmployeeName);
                if (employeeType.length > 0) {
                    employeeType.forEach(function(type) {
                        if (type === 'GovernmentEmployedDoctor') {
                            reportDetails.push('ប្រភេទ: មន្ត្រីក្របខណ្ឌ');
                        } else if (type === 'HiredMedicalOfficer') {
                            reportDetails.push('ប្រភេទ: កិច្ចសន្យា/ជួល&វេជ្ជសាស្ត្រ');
                        } else if (type === 'HiredNotMedicalOfficer') {
                            reportDetails.push('ប្រភេទ: កិច្ចសន្យា/ជួល&មិនវេជ្ជសាស្ត្រ');
                        } else {
                            reportDetails.push('ប្រភេទ: ' + type);
                        }
                    });
                }
                $('#reportDetailsValue').html(reportDetails.join(', ') || '.....');
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }

    function getCurrentDate() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //មករា គឺ 0!
        var yyyy = today.getFullYear();

        return dd + '-' + mm + '-' + yyyy;
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
                $('.dataTables_info, .dataTables_paginate, .dataTables_length, .dataTables_filter').hide();
            },
            printDelay: 1000 // បន្ថែមការពន្យារពេលដើម្បីធានាថាមាតិកាត្រូវបានផ្ទុកពេញលេញ
        });
    }
</script>
@endpush
@endsection