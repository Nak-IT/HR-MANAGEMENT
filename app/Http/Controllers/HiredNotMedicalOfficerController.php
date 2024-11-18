<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInfoEmp;

use App\Models\Skill;
use App\Models\Position;
use App\Models\Building;
use App\Models\EmploymentStatus;
use App\Models\CategoryEmployee;
use Illuminate\Support\Facades\DB;
use App\Models\HiredNotMedicalOfficer;
use App\Models\HiredMedicalOfficer;
use Illuminate\Support\Facades\Validator;
use App\Models\GovernmentEmployedDoctor;
class HiredNotMedicalOfficerController extends Controller
{
    public function show() 
    {
        $employees = PersonalInfoEmp::select('EmployeeID', 'FirstName', 'LastName', 'Gender', 'Phone', 'Emp_as_khmerID')->get();
        
    
        $skills = Skill::all();
        $positions = Position::all();
        $buildings = Building::all();
        $statuses = EmploymentStatus::all();
        $categoryEmployees = CategoryEmployee::all();
        
        return view('hired_not_medical_officers.HiredNotMedicalOfficer', compact('employees', 'skills', 'positions', 'buildings', 'statuses', 'categoryEmployees'));
    }

    public function getAllData()
    {
        $result = DB::table('hired_not_medical_officers as hnmo')
            ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
            ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
            ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
            ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
            ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
            ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
            ->select(
                'hnmo.HiredNotMedicalOfficerID',
                'emp.FirstName',
                'emp.LastName',
                'emp.EmployeeID',
                'emp.Emp_as_khmerID',
                'emp.Gender',
                'emp.Phone',
                'emp.Photo',
                'hnmo.StartDate',
                'hnmo.EndDate',
                'hnmo.CurrentPositionDate',
                'p.PositionName',
                'hnmo.Institution',
                's.SkillName',
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
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងឬតួនាទីដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'SkillID.required' => 'សូមជ្រើសរើសកម្រិតជំនាញ។',
            'SkillID.exists' => 'កម្រិតជំនាញដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BuildingID.required' => 'សូមជ្រើសរើសអគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារសុខាភិបាលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:hired_not_medical_officers,EmployeeID',
            'StartDate' => 'required|date',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'Institution' => 'required|string',
            'SkillID' => 'required|exists:skills,SkillID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
        ];

        
        $validator = Validator::make($request->all(), $rules, $messages);

        
        $validator->after(function ($validator) use ($request) {
            $existsInMedicalOfficer = HiredMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();
            $existsInGovernmentEmployedDoctor = GovernmentEmployedDoctor::where('EmployeeID', $request->EmployeeID)->exists();

            if ($existsInMedicalOfficer) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលនិងជាវេជ្ជសាស្ត្រា រួចហើយ។');
            }

            if ($existsInGovernmentEmployedDoctor) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ រួចហើយ។');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $hiredNotMedicalOfficer = HiredNotMedicalOfficer::create($validator->validated());

        return response()->json(['message' => 'បញ្ចូលទិន្នន័យដោយជោគជ័យ។', 'data' => $hiredNotMedicalOfficer], 201);
    }

    public function getDataById($id)
    {
        try {
            $result = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                ->where('hnmo.HiredNotMedicalOfficerID', $id)
                ->select(
                    'hnmo.HiredNotMedicalOfficerID',
                    'hnmo.EmployeeID',
                    'hnmo.StartDate',
                    'hnmo.EndDate',
                    'hnmo.CurrentPositionDate',
                    'hnmo.PositionID',
                    'hnmo.Institution',
                    'hnmo.SkillID',
                    'hnmo.BuildingID',
                    'hnmo.CategoryEmployeeID',
                    'hnmo.StatusID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Photo',
                    'emp.Phone',
                    'p.PositionName',
                    's.SkillName',
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
            'EndDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃឆ្នាំបញ្ចប់កិច្ចសន្យា/ការងារ។',
            'CurrentPositionDate.required' => 'សូមបញ្ចូលថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'CurrentPositionDate.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវសម្រាប់ថ្ងៃកាន់មុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.required' => 'សូមជ្រើសរើសមុខតំណែងឬតួនាទីបច្ចុប្បន្ន។',
            'PositionID.exists' => 'មុខតំណែងឬតួនាទីដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'Institution.required' => 'សូមបញ្ចូលឈ្មោះអង្គភាព/ស្ថាប័ន។',
            'SkillID.required' => 'សូមជ្រើសរើសកម្រិតជំនាញ។',
            'SkillID.exists' => 'កម្រិតជំនាញដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BuildingID.required' => 'សូមជ្រើសរើសអគារសុខាភិបាល។',
            'BuildingID.exists' => 'អគារសុខាភិបាលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'CategoryEmployeeID.required' => 'សូមជ្រើសរើសប្រភេទបុគ្គលិក។',
            'CategoryEmployeeID.exists' => 'ប្រភេទបុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'StatusID.required' => 'សូមជ្រើសរើសស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួល។',
            'StatusID.exists' => 'ស្ថានភាពមន្ត្រីកិច្ចសន្យា​ឬមន្ត្រីជួលដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];

        $rules = [
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID|unique:hired_not_medical_officers,EmployeeID,' . $id . ',HiredNotMedicalOfficerID',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date',
            'CurrentPositionDate' => 'required|date',
            'PositionID' => 'required|exists:positions,PositionID',
            'Institution' => 'required|string',
            'SkillID' => 'required|exists:skills,SkillID',
            'BuildingID' => 'required|exists:buildings,BuildingID',
            'CategoryEmployeeID' => 'required|exists:category_employees,CategoryEmployeeID',
            'StatusID' => 'required|exists:employment_statuses,StatusID',
        ];

      
        $validator = Validator::make($request->all(), $rules, $messages);

      
        $validator->after(function ($validator) use ($request, $id) {
            
            $existsInMedicalOfficer = HiredMedicalOfficer::where('EmployeeID', $request->EmployeeID)->exists();
            $existsInGovernmentEmployedDoctor = GovernmentEmployedDoctor::where('EmployeeID', $request->EmployeeID)->exists();

            if ($existsInMedicalOfficer) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីបុគ្គលិក/មន្ត្រីជួលនិងជាវេជ្ជសាស្ត្រា រួចហើយ។');
            }

            if ($existsInGovernmentEmployedDoctor) {
                $validator->errors()->add('EmployeeID', 'សូមពិនិត្យឡើងវិញ: បុគ្គលិកនេះ មាននៅក្នុងបញ្ជីក្របខណ រួចហើយ។');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $hiredNotMedicalOfficer = HiredNotMedicalOfficer::findOrFail($id);
        $hiredNotMedicalOfficer->update($validator->validated());

        return response()->json(['message' => 'កែប្រែបានជោគជ័យ', 'data' => $hiredNotMedicalOfficer], 200);
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
    public function getHiredNotMedicalOfficerDetails($id)
    {
        try {
            $officerDetails = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
                ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->where('hnmo.HiredNotMedicalOfficerID', $id)
                ->select(
                    'hnmo.HiredNotMedicalOfficerID',
                    'hnmo.StartDate',
                    'hnmo.EndDate',
                    'hnmo.CurrentPositionDate',
                    'hnmo.Institution',
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
                    's.SkillName',
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
                return response()->json(['error' => 'Hired Not Medical Officer record not found'], 404);
            }
    
            // Format the dates
            $datesToFormat = ['StartDate', 'CurrentPositionDate', 'DateOfBirth', 'EducationStartDate', 'EducationEndDate', 'EndDate'];
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
            $hiredNotMedicalOfficer = HiredNotMedicalOfficer::findOrFail($id);
            $hiredNotMedicalOfficer->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
