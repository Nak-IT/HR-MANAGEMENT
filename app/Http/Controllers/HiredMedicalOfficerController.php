<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInfoEmp;
use App\Models\Department;
use App\Models\Position;
use App\Models\Building;
use App\Models\EmploymentStatus;
use App\Models\CategoryEmployee;
use App\Models\HiredMedicalOfficer;
use App\Models\HiredNotMedicalOfficer;
use Illuminate\Support\Facades\Validator;
use App\Models\GovernmentEmployedDoctor;

class HiredMedicalOfficerController extends Controller
{
    public function show() 
    {
        $employees = PersonalInfoEmp::select('EmployeeID', 'FirstName', 'LastName', 'Gender', 'Phone', 'Emp_as_khmerID')->get();
        
        $departments = Department::all();
        $positions = Position::all();
        $buildings = Building::all();
        $statuses = EmploymentStatus::all();
        $categoryEmployees = CategoryEmployee::all();
        
        return view('hired_medical_officers.HiredMedicalOfficer', compact('employees', 'departments', 'positions', 'buildings', 'statuses', 'categoryEmployees'));
    }

    public function getAllData()
    {
        $result = DB::table('hired_medical_officers as hmo')
            ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
            ->join('positions as p', 'hmo.PositionID', '=', 'p.PositionID')
            ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
            ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
            ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
            ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
            ->select(
                'hmo.HiredMedicalOfficerID',
                'emp.FirstName',
                'emp.LastName',
                'emp.EmployeeID',
                'emp.Emp_as_khmerID',
                'emp.Gender',
                'emp.Phone',
                'emp.Photo',
                'hmo.StartDate',
                'hmo.CurrentPositionDate',
                'hmo.EndDate',
                'p.PositionName',
                'hmo.Institution',
                'd.DepartmentName',
                'b.BuildingName',
                'ce.CategoryEmployeeName',
                'es.StatusName'
            )
            ->distinct()
            ->get();

        return response()->json($result);
    }

    public function create(Request $request)
    {
        $messages = [
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'EmployeeID.unique' => 'បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។',
            'StartDate.required' => 'សូមបញ្ចូលថ្ងៃចូលបម្រើការងារ។',
            'StartDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃចូលបម្រើការងារ។',
            'EndDate.nullable' => 'សូមបញ្ចូលថ្ងៃឆ្នាំបញ្ចប់កិច្ចសន្យា/ការងារ។',
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'DepartmentID.required' => 'សូមជ្រើសរើសឯកទេស។',
            'DepartmentID.exists' => 'ឯកទេសដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BuildingID.required' => 'សូមជ្រើសរើសអគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារសុខាភិបាលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:hired_medical_officers,EmployeeID',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'Institution' => 'required|string',
            'DepartmentID' => 'required|exists:departments,DepartmentID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
        ];

        
     
       $validator = Validator::make($request->all(), $rules, $messages);

      
       $validator->after(function ($validator) use ($request) {
         
           $existsInNotMedicalOfficer = HiredNotMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();

           if ($existsInNotMedicalOfficer) {
               $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្រ្ត រួចហើយ។');
           }

          
           $existsInGovernmentEmployedDoctor = GovernmentEmployedDoctor::where('EmployeeID', $request->EmployeeID)->exists();

           if ($existsInGovernmentEmployedDoctor) {
               $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។');
           }
       });

       if ($validator->fails()) {
           return response()->json(['errors' => $validator->errors()], 422);
       }

      
       $hiredMedicalOfficer = HiredMedicalOfficer::create($validator->validated());

       return response()->json(['message' => 'បញ្ចូលបានជោគជ័យ', 'data' => $hiredMedicalOfficer], 201);
    }

    public function getDataById($id)
    {
        try {
            $result = DB::table('hired_medical_officers as hmo')
                ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hmo.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
                ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                ->where('hmo.HiredMedicalOfficerID', $id)
                ->select(
                    'hmo.HiredMedicalOfficerID',
                    'hmo.EmployeeID',
                    'hmo.StartDate',
                    'hmo.CurrentPositionDate',
                    'hmo.EndDate',
                    'hmo.PositionID',
                    'hmo.Institution',
                    'hmo.DepartmentID',
                    'hmo.BuildingID',
                    'hmo.CategoryEmployeeID',
                    'hmo.StatusID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Photo',
                    'emp.Phone',
                    'p.PositionName',
                    'd.DepartmentName',
                    'b.BuildingName',
                    'ce.CategoryEmployeeName',
                    'es.StatusName'
                )
                ->first();
    
            if (!$result) {
                return response()->json(['error' => 'Record not found'], 404);
            }
    
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'EmployeeID.unique' => 'បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។',
            'StartDate.required' => 'សូមបញ្ចូលថ្ងៃចូលបម្រើការងារ។',
            'StartDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃចូលបម្រើការងារ។',
            'EndDate.nullable' => 'សូមបញ្ចូលថ្ងៃឆ្នាំបញ្ចប់កិច្ចសន្យា/ការងារ។',
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងឬតួនាទីបច្ចុប្បន្នដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'DepartmentID.required' => 'សូមជ្រើសរើសឯកទេស។',
            'DepartmentID.exists' => 'ឯកទេសដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BuildingID.required' => 'សូមជ្រើសរើសអគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារសុខាភិបាលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:hired_medical_officers,EmployeeID,'.$id.',HiredMedicalOfficerID',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'Institution' => 'required|string',
            'DepartmentID' => 'required|exists:departments,DepartmentID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
        ];

        
        $validator = Validator::make($request->all(), $rules, $messages);

        
        $validator->after(function ($validator) use ($request, $id) {
           
            $existsInNotMedicalOfficer = HiredNotMedicalOfficer::where('EmployeeID', $request->EmployeeID)
                ->where('EmployeeID', '!=', $id)
                ->exists();

            if ($existsInNotMedicalOfficer) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្ត្រ រួចហើយ។');
            }

            
            $existsInGovernmentEmployedDoctor = GovernmentEmployedDoctor::where('EmployeeID', $request->EmployeeID)
                ->where('EmployeeID', '!=', $id)
                ->exists();

            if ($existsInGovernmentEmployedDoctor) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ្ឌ រួចហើយ។');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $hiredMedicalOfficer = HiredMedicalOfficer::findOrFail($id);
        $hiredMedicalOfficer->update($validator->validated());

        return response()->json(['message' => 'កែប្រែបានជោគជ័យ', 'data' => $hiredMedicalOfficer], 200);
    }



    

    public function getEmployeePhoto($employeeId)
    {
        $employee = PersonalInfoEmp::where('EmployeeID', $employeeId)
                                   ->select('Photo')
                                   ->first();

        if ($employee) {
            return response()->json(['photo' => $employee->Photo]);
        } else {
            return response()->json(['photo' => '']);
        }
    }
    public function getHiredMedicalOfficerDetails($id)
    {
        try {
            $officerDetails = DB::table('hired_medical_officers as hmo')
                ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hmo.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
                ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->where('hmo.HiredMedicalOfficerID', $id)
                ->select(
                    'hmo.HiredMedicalOfficerID',
                    'hmo.StartDate',
                    'hmo.CurrentPositionDate',
                    'hmo.Institution',
                    'emp.EmployeeID',
                    'emp.Emp_as_khmerID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.LatinName',
                    'emp.Gender',
                    'emp.DateOfBirth',
                    'emp.Nationality',
                    'emp.Phone',
                    'emp.Photo',
                    'emp.BirthVillage',
                    'emp.BirthCommuneWard',
                    'emp.BirthDistrict',
                    'bp.ProvinceName as BirthProvinceName',
                    'emp.HouseNumber',
                    'emp.GroupNumber',
                    'emp.AddressVillage',
                    'emp.AddressCommuneWard',
                    'emp.AddressDistrict',
                    'ap.ProvinceName as AddressProvinceName',
                    'p.PositionName',
                    'd.DepartmentName',
                    'b.BuildingName',
                    'es.StatusName',
                    'ce.CategoryEmployeeName',
                    'i.IdentificationID',
                    'i.NationalID',
                    'i.CivilServantID',
                    'i.EmployeeCode',
                    'e.EducationID',
                    'e.EducationLevel',
                    'e.Country',
                    'e.School',
                    'e.Degree',
                    'e.StartDate as EducationStartDate',
                    'e.EndDate as EducationEndDate'
                )
                ->first();
    
            if (!$officerDetails) {
                return response()->json(['error' => 'Hired Medical Officer record not found'], 404);
            }
    
            // Format the dates
            $datesToFormat = ['StartDate', 'CurrentPositionDate', 'DateOfBirth', 'EducationStartDate', 'EducationEndDate'];
            foreach ($datesToFormat as $dateField) {
                if (!empty($officerDetails->$dateField)) {
                    $officerDetails->$dateField = date('d-m-Y', strtotime($officerDetails->$dateField));
                }
            }
    
            return response()->json($officerDetails);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $hiredMedicalOfficer = HiredMedicalOfficer::findOrFail($id);
            $hiredMedicalOfficer->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
