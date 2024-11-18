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
            $statusName = $request->input('EmploymentStatus');
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');

            // Query for government_employed_doctors
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

            // Query for hired_medical_officers
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

            // Query for hired_not_medical_officers
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

            // Apply filters to all queries
            foreach ([$query1, $query2, $query3] as $query) {
                if ($buildingName) {
                    $query->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
                }
                if ($statusName) {
                    $query->where('es.StatusName', 'LIKE', '%' . $statusName . '%');
                }
                if ($categoryEmployeeName) {
                    $query->where('ce.CategoryEmployeeName', 'LIKE', '%' . $categoryEmployeeName . '%');
                }
                if ($date1 && $date2 && $dateField) {
                    $query->whereBetween($dateField, [$date1, $date2]);
                }
            }

            // Combine the three queries using UNION
            $query = $query1->union($query2)->union($query3);

            // Execute the combined query
            $employeeDetails = $query->get();

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
            $statusName = $request->input('StatusName');
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $sortColumn = $request->input('sortColumn');
            $sortDirection = $request->input('sortDirection');

            // Use the EmployedExports_Detail class to generate the Excel file
            return Excel::download(
                new EmployedExports_Detail_second($buildingName, $statusName, $categoryEmployeeName, $date1, $date2, $dateField, $sortColumn, $sortDirection),
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
            $statusName = $request->input('StatusName');
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $sortColumn = $request->input('sortColumn');
            $sortDirection = $request->input('sortDirection');

            // Use the EmployedExports_Detail class to generate the Excel file
            return Excel::download(
                new EmployedExports_Detail_second_third($buildingName, $statusName, $categoryEmployeeName, $date1, $date2, $dateField, $sortColumn, $sortDirection),
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