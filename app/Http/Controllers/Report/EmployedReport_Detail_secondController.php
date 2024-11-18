<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Building;
use App\Models\EmploymentStatus;
use Carbon\Carbon;
use App\Exports\EmployedExports_Detail_second;
use App\Exports\EmployedExports_Detail_second_third;
use App\Models\CategoryEmployee;

class EmployedReport_Detail_secondController extends Controller
{
    public function getEmployedReport_Detail_second(Request $request)
    {
        try {
            // Capture filter parameters
            $buildingName = $request->input('BuildingName');
            $employmentStatuses = $request->input('EmploymentStatus'); // This will be an array
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $employeeTypes = $request->input('employeeType'); // This should be an array

            // Initialize an array to hold the queries
            $queries = [];

            // Query for government_employed_doctors
            if (!$employeeTypes || in_array('GovernmentEmployedDoctor', $employeeTypes)) {
                $query1 = DB::table('government_employed_doctors as ged')
                    ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                    ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                    ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                    ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                    ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                    ->join('category_employees as ce', 'ged.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                    ->leftJoin('identifications as i', 'ged.EmployeeID', '=', 'i.EmployeeID')
                    ->leftJoin('education as edu', 'ged.EmployeeID', '=', 'edu.EmployeeID')
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'emp.Phone',
                        'ged.StartDate as GedStartDate',
                        'ged.CurrentPositionDate as GedCurrentPositionDate',
                        'ged.EndDate as GedEndDate',
                        'p.PositionName',
                        'd.DepartmentName',
                        'b.BuildingName',
                        'es.StatusName',
                        'ged.government_employed_doctorID as ID',
                        'ged.EmploymentCategory',
                        DB::raw('NULL as SkillName'),
                        'ce.CategoryEmployeeName',
                        'i.NationalID',
                        'i.CivilServantID',
                        'i.EmployeeCode',
                        'edu.EducationLevel',
                        'edu.Country',
                        'edu.School',
                        'edu.Degree',
                        'ged.Institution',
                        DB::raw('NULL as HmoStartDate'),
                        DB::raw('NULL as HmoEndDate'),
                        DB::raw('NULL as HnmoStartDate'),
                        DB::raw('NULL as HnmoCurrentPositionDate'),
                        DB::raw('NULL as HnmoEndDate')
                    );
                $this->applyFilters($query1, $buildingName, $employmentStatuses, $categoryEmployeeName, $date1, $date2, $dateField);
                $queries[] = $query1;
            }

            // Query for hired_medical_officers
            if (!$employeeTypes || in_array('HiredMedicalOfficer', $employeeTypes)) {
                $query2 = DB::table('hired_medical_officers as hmo')
                    ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                    ->join('positions as p', 'hmo.PositionID', '=', 'p.PositionID')
                    ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
                    ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
                    ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                    ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                    ->leftJoin('identifications as i', 'hmo.EmployeeID', '=', 'i.EmployeeID')
                    ->leftJoin('education as edu', 'hmo.EmployeeID', '=', 'edu.EmployeeID')
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'emp.Phone',
                        DB::raw('NULL as GedStartDate'),
                        'hmo.CurrentPositionDate as HmoCurrentPositionDate',
                        DB::raw('NULL as GedEndDate'),
                        'p.PositionName',
                        'd.DepartmentName',
                        'b.BuildingName',
                        'es.StatusName',
                        'hmo.HiredMedicalOfficerID as ID',
                        DB::raw('NULL as EmploymentCategory'),
                        DB::raw('NULL as SkillName'),
                        'ce.CategoryEmployeeName',
                        'i.NationalID',
                        'i.CivilServantID',
                        'i.EmployeeCode',
                        'edu.EducationLevel',
                        'edu.Country',
                        'edu.School',
                        'edu.Degree',
                        'hmo.Institution',
                        'hmo.StartDate as HmoStartDate',
                        'hmo.EndDate as HmoEndDate',
                        DB::raw('NULL as HnmoStartDate'),
                        DB::raw('NULL as HnmoCurrentPositionDate'),
                        DB::raw('NULL as HnmoEndDate')
                    );
                $this->applyFilters($query2, $buildingName, $employmentStatuses, $categoryEmployeeName, $date1, $date2, $dateField);
                $queries[] = $query2;
            }

            // Query for hired_not_medical_officers
            if (!$employeeTypes || in_array('HiredNotMedicalOfficer', $employeeTypes)) {
                $query3 = DB::table('hired_not_medical_officers as hnmo')
                    ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                    ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                    ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                    ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                    ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                    ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                    ->leftJoin('identifications as i', 'hnmo.EmployeeID', '=', 'i.EmployeeID')
                    ->leftJoin('education as edu', 'hnmo.EmployeeID', '=', 'edu.EmployeeID')
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'emp.Phone',
                        DB::raw('NULL as GedStartDate'),
                        DB::raw('NULL as GedCurrentPositionDate'),
                        DB::raw('NULL as GedEndDate'),
                        'p.PositionName',
                        DB::raw('NULL as DepartmentName'),
                        'b.BuildingName',
                        'es.StatusName',
                        'hnmo.HiredNotMedicalOfficerID as ID',
                        DB::raw('NULL as EmploymentCategory'),
                        's.SkillName',
                        'ce.CategoryEmployeeName',
                        'i.NationalID',
                        'i.CivilServantID',
                        'i.EmployeeCode',
                        'edu.EducationLevel',
                        'edu.Country',
                        'edu.School',
                        'edu.Degree',
                        'hnmo.Institution',
                        DB::raw('NULL as HmoStartDate'),
                        DB::raw('NULL as HmoEndDate'),
                        'hnmo.StartDate as HnmoStartDate',
                        'hnmo.CurrentPositionDate as HnmoCurrentPositionDate',
                        'hnmo.EndDate as HnmoEndDate'
                    );
                $this->applyFilters($query3, $buildingName, $employmentStatuses, $categoryEmployeeName, $date1, $date2, $dateField);
                $queries[] = $query3;
            }

            // Combine queries or return empty result
            if (count($queries) == 0) {
                $employeeDetails = collect(); // Empty collection
            } else {
                $query = array_shift($queries);
                foreach ($queries as $q) {
                    $query = $query->union($q);
                }
                $employeeDetails = $query->get();
            }

            if ($employeeDetails->isEmpty()) {
                return response()->json(['error' => 'No Employees found for the specified criteria.'], 404);
            }

            // Format the date fields for display
            foreach ($employeeDetails as $employee) {
                $employee->DateOfBirth = isset($employee->DateOfBirth) ? $this->formatKhmerDate($employee->DateOfBirth) : '';
                $employee->GedStartDate = isset($employee->GedStartDate) ? $this->formatKhmerDate($employee->GedStartDate) : '';
                $employee->GedCurrentPositionDate = isset($employee->GedCurrentPositionDate) ? $this->formatKhmerDate($employee->GedCurrentPositionDate) : '';
                $employee->GedEndDate = isset($employee->GedEndDate) ? $this->formatKhmerDate($employee->GedEndDate) : '';
                $employee->HmoStartDate = isset($employee->HmoStartDate) ? $this->formatKhmerDate($employee->HmoStartDate) : '';
                $employee->HmoCurrentPositionDate = isset($employee->HmoCurrentPositionDate) ? $this->formatKhmerDate($employee->HmoCurrentPositionDate) : '';
                $employee->HmoEndDate = isset($employee->HmoEndDate) ? $this->formatKhmerDate($employee->HmoEndDate) : '';
                $employee->HnmoStartDate = isset($employee->HnmoStartDate) ? $this->formatKhmerDate($employee->HnmoStartDate) : '';
                $employee->HnmoCurrentPositionDate = isset($employee->HnmoCurrentPositionDate) ? $this->formatKhmerDate($employee->HnmoCurrentPositionDate) : '';
                $employee->HnmoEndDate = isset($employee->HnmoEndDate) ? $this->formatKhmerDate($employee->HnmoEndDate) : '';
            }

            return response()->json($employeeDetails);

        } catch (\Exception $ex) {
            return response()->json(['error' => 'An error occurred: ' . $ex->getMessage()], 500);
        }
    }

    private function applyFilters($query, $buildingName, $employmentStatuses, $categoryEmployeeName, $date1, $date2, $dateField)
    {
        if ($buildingName) {
            $query->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
        }
        if ($employmentStatuses && count($employmentStatuses) > 0) {
            $query->whereIn('es.StatusName', $employmentStatuses);
        }
        if ($categoryEmployeeName) {
            $query->where('ce.CategoryEmployeeName', 'LIKE', '%' . $categoryEmployeeName . '%');
        }
        if ($date1 && $date2 && $dateField) {
            $query->whereBetween($dateField, [$date1, $date2]);
        }
    }

    private function formatKhmerDate($dateString)
    {
        if (!$dateString) return "";

        $khmerMonths = ["មករា", "កុម្ភៈ", "មិនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"];
        $khmerNumbers = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];

        $date = Carbon::parse($dateString);

        $day = $date->format('d');
        $month = $khmerMonths[$date->month - 1];
        $year = $date->format('Y');

        $day = implode('', array_map(function ($digit) use ($khmerNumbers) {
            return $khmerNumbers[(int)$digit];
        }, str_split($day)));

        $year = implode('', array_map(function ($digit) use ($khmerNumbers) {
            return $khmerNumbers[(int)$digit];
        }, str_split($year)));

        return "{$day} {$month} {$year}";
    }

    public function exportEmployedReport_Detail_second(Request $request)
    {
        try {
            // Capture the filter and sorting parameters from the request
            $buildingName = $request->input('BuildingName');
            $statusNames = $request->input('EmploymentStatus', []);
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $sortColumn = $request->input('sortColumn');
            $sortDirection = $request->input('sortDirection');
            $employeeTypes = $request->input('employeeType');

            // Use the EmployedExports_Detail class to generate the Excel file
            return Excel::download(
                new EmployedExports_Detail_second($buildingName, $statusNames, $categoryEmployeeName, $date1, $date2, $dateField, $sortColumn, $sortDirection, $employeeTypes),
                'employed_report.xlsx'
            );
        } catch (\Exception $ex) {
            // Return a JSON error response if something goes wrong
            return response()->json(['error' => 'An error occurred during export: ' . $ex->getMessage()], 500);
        }
    }

    public function exportEmployedReport_Detail_second_third(Request $request)
    {
        try {
            // Capture the filter and sorting parameters from the request
            $buildingName = $request->input('BuildingName');
            $employmentStatuses = $request->input('EmploymentStatus');
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $sortColumn = $request->input('sortColumn');
            $sortDirection = $request->input('sortDirection');
            $employeeTypes = $request->input('employeeType');

            // Use the EmployedExports_Detail class to generate the Excel file
            return Excel::download(
                new EmployedExports_Detail_second_third($buildingName, $employmentStatuses, $categoryEmployeeName, $date1, $date2, $dateField, $sortColumn, $sortDirection, $employeeTypes),
                'employed_report.xlsx'
            );
        } catch (\Exception $ex) {
            // Return a JSON error response if something goes wrong
            return response()->json(['error' => 'An error occurred during export: ' . $ex->getMessage()], 500);
        }
    }

    public function showEmployedReportByBuildingThird()
    {
        // Retrieve all buildings, employment statuses, and category employees from the database using DB facade
        $buildings = DB::table('buildings')->get();
        $statuses = DB::table('employment_statuses')->get();
        $categories = DB::table('category_employees')->select('CategoryEmployeeID', 'CategoryEmployeeName')->get();
    
        // Return the view and pass the data to the view using compact()
        return view('EmployedReport.EmployedReport_Detail_second_third', compact('buildings', 'statuses', 'categories'));
    }

    public function showEmployedReportByBuilding()
    {
        // Retrieve all buildings, employment statuses, and category employees from the database using DB facade
        $buildings = DB::table('buildings')->get();
        $statuses = DB::table('employment_statuses')->get();
        $categories = DB::table('category_employees')->select('CategoryEmployeeID', 'CategoryEmployeeName')->get();
    
        // Return the view and pass the data to the view using compact()
        return view('EmployedReport.EmployedReport_Detail_second', compact('buildings', 'statuses', 'categories'));
    }
}