<?php 

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

use App\Models\Building;
use App\Models\EmploymentStatus;
use Carbon\Carbon;
use App\Exports\EmployedExports_Detail;
use App\Exports\EmployedExports_Detail_second;


class EmployedReport_Detail_Controller extends Controller
{
    public function getEmployedReport_Detail(Request $request)
    {
        try {
            // Capture filter parameters
            $buildingName = $request->input('BuildingName');
            $statusNames = $request->input('EmploymentStatus', []); // Adjusted to handle array of statuses
            $categoryEmployeeName = $request->input('CategoryEmployeeName');  // CategoryEmployeeName filter
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $employeeTypes = $request->input('employeeType', []); // Adjusted to handle array of employee types

            // Prepare an array to hold all queries
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
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'ged.StartDate as GedStartDate',
                        'ged.CurrentPositionDate as GedCurrentPositionDate',
                        'ged.EndDate as GedEndDate',
                        'p.PositionName',
                        'd.DepartmentName',  // DepartmentName for government_employed_doctors
                        'b.BuildingName',
                        'es.StatusName',
                        'ged.government_employed_doctorID as ID',
                        'ged.EmploymentCategory',
                        DB::raw('NULL as SkillName'), // No SkillName for government_employed_doctors
                        'ce.CategoryEmployeeName' // Get CategoryEmployeeName from category_employees
                    );

                // Apply filters to government_employed_doctors query
                if ($buildingName) {
                    $query1->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
                }
                if (!empty($statusNames)) {
                    $query1->whereIn('es.StatusName', $statusNames);
                }
                if ($categoryEmployeeName) {
                    $query1->where('ce.CategoryEmployeeName', 'LIKE', '%' . $categoryEmployeeName . '%');
                }
                if ($date1 && $date2 && $dateField) {
                    $query1->whereBetween($dateField, [$date1, $date2]);
                }

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
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'hmo.StartDate as HmoStartDate',
                        'hmo.CurrentPositionDate as HmoCurrentPositionDate',
                        'hmo.EndDate as HmoEndDate',
                        'p.PositionName',
                        'd.DepartmentName', // DepartmentName for hired_medical_officers
                        'b.BuildingName',
                        'es.StatusName',
                        'hmo.HiredMedicalOfficerID as ID',
                        DB::raw("'hired_medical_officers' as EmploymentCategory"),
                        DB::raw('NULL as SkillName'), // No SkillName for hired_medical_officers
                        'ce.CategoryEmployeeName' // Get CategoryEmployeeName from category_employees
                    );

                // Apply filters to hired_medical_officers query
                if ($buildingName) {
                    $query2->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
                }
                if (!empty($statusNames)) {
                    $query2->whereIn('es.StatusName', $statusNames);
                }
                if ($categoryEmployeeName) {
                    $query2->where('ce.CategoryEmployeeName', 'LIKE', '%' . $categoryEmployeeName . '%');
                }
                if ($date1 && $date2 && $dateField) {
                    $query2->whereBetween($dateField, [$date1, $date2]);
                }

                $queries[] = $query2;
            }

            // Query for hired_not_medical_officers
            if (!$employeeTypes || in_array('HiredNotMedicalOfficer', $employeeTypes)) {
                $query3 = DB::table('hired_not_medical_officers as hnmo')
                    ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                    ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                    ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                    ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                    ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID') // Join with skills table
                    ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID') // Join with category_employees
                    ->select(
                        'emp.FirstName',
                        'emp.LastName',
                        'emp.LatinName',
                        'emp.Gender',
                        'emp.DateOfBirth',
                        'hnmo.StartDate as HnmoStartDate',
                        'hnmo.CurrentPositionDate as HnmoCurrentPositionDate',
                        'hnmo.EndDate as HnmoEndDate',
                        'p.PositionName',
                        DB::raw('NULL as DepartmentName'), // No DepartmentName for hired_not_medical_officers
                        'b.BuildingName',
                        'es.StatusName',
                        'hnmo.HiredNotMedicalOfficerID as ID',
                        DB::raw("'hired_not_medical_officers' as EmploymentCategory"),
                        's.SkillName', // SkillName for hired_not_medical_officers
                        'ce.CategoryEmployeeName' // Get CategoryEmployeeName from category_employees
                    );

                // Apply filters to hired_not_medical_officers query
                if ($buildingName) {
                    $query3->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
                }
                if (!empty($statusNames)) {
                    $query3->whereIn('es.StatusName', $statusNames);
                }
                if ($categoryEmployeeName) {
                    $query3->where('ce.CategoryEmployeeName', 'LIKE', '%' . $categoryEmployeeName . '%');
                }
                if ($date1 && $date2 && $dateField) {
                    $query3->whereBetween($dateField, [$date1, $date2]);
                }

                $queries[] = $query3;
            }

            if (count($queries) == 0) {
                // No employee types selected, return an empty result
                return response()->json([], 200);
            }

            // Combine the queries using UNION
            $combinedQuery = array_shift($queries);
            foreach ($queries as $query) {
                $combinedQuery = $combinedQuery->union($query);
            }

            // Execute the combined query
            $employeeDetails = $combinedQuery->get();

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

    public function exportEmployedReport_Detail(Request $request)
    {
        try {
            // Capture the filter and sorting parameters from the request
            $buildingName = $request->input('BuildingName');
            $statusNames = $request->input('EmploymentStatus', []); // Adjusted to handle array of statuses
            $categoryEmployeeName = $request->input('CategoryEmployeeName');
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField');
            $sortColumn = $request->input('sortColumn');
            $sortDirection = $request->input('sortDirection');
            $employeeTypes = $request->input('employeeType', []); // Adjusted to handle array of employee types

            // Use the EmployedExports_Detail class to generate the Excel file
            return Excel::download(
                new EmployedExports_Detail(
                    $buildingName,
                    $statusNames,
                    $categoryEmployeeName,
                    $date1,
                    $date2,
                    $dateField,
                    $sortColumn,
                    $sortDirection,
                    $employeeTypes
                ),
                'employed_report.xlsx'
            );
        } catch (\Exception $ex) {
            // Log the error and redirect back with an error message
            Log::error('Export error: ' . $ex->getMessage());
            return redirect()->back()->with('error', 'An error occurred during export. Please try again.');
        }
    }

    public function showEmployedReportByBuilding()
    {
        // Retrieve all buildings, employment statuses, and category employees from the database
        $buildings = Building::all();
        $statuses = EmploymentStatus::all();
        $categories = DB::table('category_employees')->select('CategoryEmployeeID', 'CategoryEmployeeName')->get(); // Get CategoryEmployeeID and CategoryEmployeeName

        // Return the view and pass the data to the view using compact()
        return view('EmployedReport.EmployedReport_Detail', compact('buildings', 'statuses', 'categories'));
    }
}
