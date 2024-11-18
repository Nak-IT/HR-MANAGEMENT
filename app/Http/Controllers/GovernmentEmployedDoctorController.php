<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GovernmentEmployedDoctor;
use App\Models\PersonalInfoEmp;
use App\Models\Department;
use App\Models\Position;
use App\Models\Building;
use App\Models\EmploymentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\HiredMedicalOfficer;
use App\Models\HiredNotMedicalOfficer;
use App\Models\CategoryEmployee;
class GovernmentEmployedDoctorController extends Controller
{
    public function show() 
    {
        $employees = PersonalInfoEmp::select('EmployeeID', 'FirstName', 'LastName', 'Gender', 'Phone', 'Emp_as_khmerID')->get();
        
        $departments = Department::all();
        $positions = Position::all();
        $buildings = Building::all();
        $statuses = EmploymentStatus::all();
        $categoryEmployees = CategoryEmployee::all();
        return view('government_employed_doctors.GovernmentEmployedDoctor', compact('employees', 'departments', 'positions', 'buildings', 'statuses', 'categoryEmployees'));
    }

    public function getAllData()
    {
        $result = DB::table('government_employed_doctors as ged')
            ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
            ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
            ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
            ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
            
            ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
            ->select(
                'ged.government_employed_doctorID',
                'emp.FirstName',
                'emp.LastName',
                'emp.EmployeeID',
                'emp.Emp_as_khmerID',
                'emp.Gender',
                'emp.Phone',
                'emp.Photo',
                'ged.StartDate',
                'ged.EndDate',
                'ged.CurrentPositionDate',
                'p.PositionName',
                'ged.EmploymentCategory',
                'ged.Institution',
                'd.DepartmentName',
                'b.BuildingName',
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
            'EndDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃខែឆ្នាំចូលនិវត្តន៍។',
            'EndDate.after_or_equal' => 'ថ្ងៃខែឆ្នាំចូលនិវត្តន៍ត្រូវតែធំជាងឬស្មើថ្ងៃចូលបម្រើការងារ។',
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃកាន់មុខតំណែងបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃកាន់មុខតំណែងបច្ចុប្បន្ន។',
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងបច្ចុប្បន្នដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'EmploymentCategory.required' => 'សូមបញ្ចូលប្រភេទក្របខ័ណ្ឌ។',
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'DepartmentID.required' => 'សូមជ្រើសរើសជំនាញ/ឯកទេស។',
            'DepartmentID.exists' => 'ជំនាញ/ឯកទេសដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BuildingID.required' => 'សូមជ្រើសរើសអគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារសុខាភិបាលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីក្របខណ្ឌ។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីក្របខណ្ឌដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:government_employed_doctors,EmployeeID',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'EmploymentCategory' => 'required|string',
            'Institution' => 'required|string',
            'DepartmentID' => 'required|exists:departments,DepartmentID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        
        $validator->after(function ($validator) use ($request) {
            
            $existsInMedicalOfficer = HiredMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();

            if ($existsInMedicalOfficer) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលនិងជាវេជ្ជសាស្ត្រា រួចហើយ។');
            }

            
            $existsInNotMedicalOfficer = HiredNotMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();

            if ($existsInNotMedicalOfficer) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្ត្រ រួចហើយ។');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $governmentEmployedDoctor = GovernmentEmployedDoctor::create($validator->validated());
        return response()->json(['message' => 'បញ្ចូលបានជោគជ័យ', 'data' => $governmentEmployedDoctor], 201);
    }

    public function getDataById($id)
    {
        try {
            $result = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'ged.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->where('ged.government_employed_doctorID', $id)
                ->select(
                    'ged.government_employed_doctorID',
                    'ged.EmployeeID',
                    'ged.StartDate',
                    'ged.EndDate',
                    'ged.CurrentPositionDate',
                    'ged.PositionID',
                    'ged.EmploymentCategory',
                    'ged.Institution',
                    'ged.DepartmentID',
                    'ged.BuildingID',
                    'ged.StatusID',
                    'ged.CategoryEmployeeID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Photo',
                    'emp.Phone',
                    'p.PositionName',
                    'd.DepartmentName',
                    'b.BuildingName',
                    'es.StatusName',
                    'ce.CategoryEmployeeName'
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
          
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក/មន្ត្រីសុខាភិបាល។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'EmployeeID.unique' => 'បុគ្គលិកនេះមានរួចហើយក្នុងប្រព័ន្ធ។',
            
           
            'StartDate.required' => 'សូមបញ្ចូលថ្ងៃចូលបម្រើការងារ។',
            'StartDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃចូលបម្រើការងារ។',
            
            
            'EndDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃខែឆ្នាំចូលនិវត្តន៍។',
            'EndDate.after_or_equal' => 'ថ្ងៃខែឆ្នាំចូលនិវត្តន៍ត្រូវតែធំជាងឬស្មើថ្ងៃចូលបម្រើការងារ។',
            
            
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃ​ខែឆ្នាំកាន់តំណែងបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃ​ខែឆ្នាំកាន់តំណែងបច្ចុប្បន្ន។',
            
            
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងបច្ចុប្បន្នដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            
            
            'EmploymentCategory.required' => 'សូមបញ្ចូលប្រភេទក្របខ័ណ្ឌ។',
            'EmploymentCategory.string' => 'ប្រភេទក្របខ័ណ្ឌត្រូវតែជាstring។',
            
            
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'Institution.string' => 'ឈ្មោះអង្គភាព/ស្ថាប័នត្រូវតែជាstring។',
            
            
            'DepartmentID.required' => 'សូមជ្រើសរើសជំនាញ/ឯកទេស។',
            'DepartmentID.exists' => 'ជំនាញ/ឯកទេសដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            
            
            'BuildingID.required' => 'សូមជ្រើសរើសអាគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',

            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',



            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីក្របខណ្ឌ។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីក្របខណ្ឌដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:government_employed_doctors,EmployeeID,' . $id . ',government_employed_doctorID',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'EmploymentCategory' => 'required|string',
            'Institution' => 'required|string',
            'DepartmentID' => 'required|exists:departments,DepartmentID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $id) {
            
            $currentRecord = GovernmentEmployedDoctor::find($id);

            
            if ($request->EmployeeID != $currentRecord->EmployeeID) {
                
                $existsInMedicalOfficer = HiredMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();

                if ($existsInMedicalOfficer) {
                    $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះមាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលនិងជាវេជ្ជសាស្ត្រ រួចហើយ។');
                }

                
                $existsInNotMedicalOfficer = HiredNotMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();

                if ($existsInNotMedicalOfficer) {
                    $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះមាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលមិនមែនជាវេជ្ជសាស្ត្រ រួចហើយ។');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       
        $governmentEmployedDoctor = GovernmentEmployedDoctor::findOrFail($id);
        $governmentEmployedDoctor->update($validator->validated());

        return response()->json(['message' => 'អាប់ដែត បានជោគជ័យ', 'data' => $governmentEmployedDoctor], 200);
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

    public function getGovernmentEmployedDoctorDetails($id)
    {
        try {
            $doctorDetails = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID') // Changed this line
                ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
                ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->where('ged.government_employed_doctorID', $id)
                ->select(
                    'ged.government_employed_doctorID',
                    'ged.StartDate',
                    'ged.EndDate',
                    'ged.CurrentPositionDate',
                    'ged.EmploymentCategory',
                    'ged.Institution',
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
    
            if (!$doctorDetails) {
                return response()->json(['error' => 'Government Employed Doctor record not found'], 404);
            }
    
            // Format the dates
            $datesToFormat = ['StartDate', 'EndDate', 'CurrentPositionDate', 'DateOfBirth', 'EducationStartDate', 'EducationEndDate'];
            foreach ($datesToFormat as $dateField) {
                if (!empty($doctorDetails->$dateField)) {
                    $doctorDetails->$dateField = date('d-m-Y', strtotime($doctorDetails->$dateField));
                }
            }
    
            return response()->json($doctorDetails);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $governmentEmployedDoctor = GovernmentEmployedDoctor::findOrFail($id);
            $governmentEmployedDoctor->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
