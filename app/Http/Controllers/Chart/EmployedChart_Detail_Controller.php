<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployedChart_Detail_Controller extends Controller
{
    public function index()
    {
        // ទាញយកអាគារ, ស្ថានភាព និងប្រភេទសម្រាប់តម្រង
        $buildings = DB::table('buildings')->select('BuildingName')->distinct()->get();
        $statuses = DB::table('employment_statuses')->select('StatusName')->distinct()->get();
        $categories = DB::table('category_employees')->select('CategoryEmployeeName')->distinct()->get();

        // បញ្ជូនទិន្នន័យទៅកាន់ទិដ្ឋភាពក្រាហ្វិក
        return view('Chart.EmployedChart_Detail', compact('buildings', 'statuses', 'categories'));
    }

    public function getEmployedChartData(Request $request)
    {
        // ទាញយកប៉ារ៉ាម៉ែត្រពីសំណើ
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $dateField = $request->input('dateField', 'StartDate');
        $buildingName = $request->input('BuildingName');
        $statusNames = $request->input('EmploymentStatus', []);
        $categoryEmployeeName = $request->input('CategoryEmployeeName');
        $employeeTypes = $request->input('employeeType', []);
        $groupBy = $request->input('groupBy', 'Building'); // ក្រុមលំនាំដើមតាមអាគារ

        $queries = [];

        // កំណត់វាលក្រុម
        $groupFields = [];
        $selectFields = [];
        $groupLabel = '';

        switch ($groupBy) {
            case 'EmployeeType':
                $groupFields = ['EmployeeType'];
                $selectFields = [DB::raw("'មន្ត្រីក្របខណ្ឌ' as EmployeeType")];
                $groupLabel = 'EmployeeType';
                break;
            case 'CategoryEmployeeName':
                $groupFields = ['ce.CategoryEmployeeName'];
                $selectFields = ['ce.CategoryEmployeeName as CategoryEmployeeName'];
                $groupLabel = 'CategoryEmployeeName';
                break;
            case 'Gender':
                $groupFields = ['emp.Gender'];
                $selectFields = ['emp.Gender'];
                $groupLabel = 'Gender';
                break;
            case 'EmploymentStatus':
                $groupFields = ['es.StatusName'];
                $selectFields = ['es.StatusName as StatusName'];
                $groupLabel = 'StatusName';
                break;
            default:
                $groupFields = ['b.BuildingName'];
                $selectFields = ['b.BuildingName'];
                $groupLabel = 'BuildingName';
                break;
        }

        // មន្ត្រីក្របខណ្ឌ
        if (empty($employeeTypes) || in_array('GovernmentEmployedDoctor', $employeeTypes)) {
            $query1 = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'ged.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->select(array_merge($selectFields, [DB::raw("'មន្ត្រីក្របខណ្ឌ' as EmployeeType"), DB::raw('COUNT(*) as total')]))
                ->groupBy(array_merge($groupFields));

            // អនុវត្តតម្រង
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
                $query1->whereBetween('ged.' . $dateField, [$date1, $date2]);
            }

            $queries[] = $query1;
        }

        // មន្ត្រីជាប់កិច្ចសន្យា/ជួលវេជ្ជសាស្ត្រ
        if (empty($employeeTypes) || in_array('HiredMedicalOfficer', $employeeTypes)) {
            $query2 = DB::table('hired_medical_officers as hmo')
                ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->select(array_merge($selectFields, [DB::raw("'មន្ត្រីជាប់កិច្ចសន្យា/ជួលវេជ្ជសាស្ត្រ' as EmployeeType"), DB::raw('COUNT(*) as total')]))
                ->groupBy(array_merge($groupFields));

            // អនុវត្តតម្រង
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
                $query2->whereBetween('hmo.' . $dateField, [$date1, $date2]);
            }

            $queries[] = $query2;
        }

        // មន្ត្រីជាប់កិច្ចសន្យា/ជួលមិនមែនវេជ្ជសាស្ត្រ
        if (empty($employeeTypes) || in_array('HiredNotMedicalOfficer', $employeeTypes)) {
            $query3 = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->select(array_merge($selectFields, [DB::raw("'មន្ត្រីជាប់កិច្ចសន្យា/ជួលមិនមែនវេជ្ជសាស្ត្រ' as EmployeeType"), DB::raw('COUNT(*) as total')]))
                ->groupBy(array_merge($groupFields));

            // អនុវត្តតម្រង
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
                $query3->whereBetween('hnmo.' . $dateField, [$date1, $date2]);
            }

            $queries[] = $query3;
        }

        // បញ្ចូលសំណួរទាំងអស់
        if (count($queries) == 0) {
            // គ្មានទិន្នន័យ
            return response()->json([]);
        }

        // បញ្ចូលសំណួរទាំងអស់
        $combinedQuery = array_shift($queries);
        foreach ($queries as $query) {
            $combinedQuery = $combinedQuery->unionAll($query);
        }

        // ក្រុមលទ្ធផលដែលបានបញ្ចូល
        $data = DB::table(DB::raw("({$combinedQuery->toSql()}) as sub"))
            ->mergeBindings($combinedQuery)
            ->select($groupLabel, DB::raw('SUM(total) as total_quantity'))
            ->groupBy($groupLabel)
            ->get();

        return response()->json($data);
    }
}
