<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfoEmp;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Gate; 
use App\Policies\PersonalInfoEmpPolicy; 
use Illuminate\Support\Facades\Auth;



class PersonalInfoEmpController extends Controller
{
    
    public function getEmployees()
    {
        $employees = PersonalInfoEmp::all();
        return response()->json([$employees]);
    }

    public function addEmployee(Request $request)
    {
        try {
        $this->authorize('create', PersonalInfoEmp::class);
        $messages = [
            'Emp_as_khmerID.unique' => 'អត្តលេខនេះមានរួចហើយ។', 
            'Emp_as_khmerID.required' => 'សូមបញ្ចូលអត្តលេខ។', 
            'FirstName.required' => 'សូមបញ្ចូលគោត្តនាម។', 
            'LastName.required' => 'សូមបញ្ចូលនាម។',
            'Gender.required' => 'សូមជ្រើសភេទ។',
            'Phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ។',
            'DateOfBirth.required' => 'សូមបញ្ចូលថ្ងៃខែឆ្នាំកំណើត។',
            'DateOfBirth.date' => 'សូមបញ្ចូលកាលបរិច្ឆេទត្រឹមត្រូវ។',
            'Nationality.required' => 'សូមបញ្ចូលសញ្ជាតិ។',
            'LatinName.required' => 'សូមបញ្ចូលឈ្មោះអក្សរឡាតាំង។',
            'Photo.image' => 'រូបភាពត្រូវតែជាប្រភេទ JPEG, PNG, JPG, GIF។',
            'Photo.max' => 'រូបភាពមិនត្រូវធំជាង 2MB។',
            'BirthProvinceID.exists' => 'ខេត្ត/រាជធានីកំណើតដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'AddressProvinceID.exists' => 'ខេត្ត/រាជធានីស្នាក់នៅបច្ចុប្បន្នដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'BirthVillage.required' => 'សូមបញ្ចូលភូមិកំណើត។',
            'BirthCommuneWard.required' => 'សូមបញ្ចូលឃុំ/សង្កាត់កំណើត។',
            'BirthDistrict.required' => 'សូមបញ្ចូលស្រុក/ខណ្ឌកំណើត។',
            'BirthProvinceID.required' => 'សូមជ្រើសរើសខេត្ត/រាជធានីកំណើត។',
            'HouseNumber.required' => 'សូមបញ្ចូលផ្ទះលេខ។',
            'GroupNumber.required' => 'សូមបញ្ចូលលេខក្រុម។',
            'AddressVillage.required' => 'សូមបញ្ចូលភូមិស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressCommuneWard.required' => 'សូមបញ្ចូលឃុំ/សង្កាត់ស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressDistrict.required' => 'សូមបញ្ចូលស្រុក/ខណ្ឌស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressProvinceID.required' => 'សូមជ្រើសរើសខេត្ត/រាជធានីស្នាក់នៅបច្ចុប្បន្ន។'
        ];

        $validated = $request->validate([
            'Emp_as_khmerID' => 'required|unique:personal_info_emp,Emp_as_khmerID',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Gender' => 'required',
            'Phone' => 'required',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'DateOfBirth' => 'required|date',
            'Nationality' => 'required',
            'LatinName' => 'required',
            'BirthVillage' => 'required|string',
            'BirthCommuneWard' => 'required|string',
            'BirthDistrict' => 'required|string',
            'BirthProvinceID' => 'required|exists:provinces,ProvinceID',
            'HouseNumber' => 'required|string',
            'GroupNumber' => 'required|string',
            'AddressVillage' => 'required|string',
            'AddressCommuneWard' => 'required|string',
            'AddressDistrict' => 'required|string',
            'AddressProvinceID' => 'required|exists:provinces,ProvinceID',
        ], $messages);

        if ($request->hasFile('Photo')) {
            $image = $request->file('Photo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['Photo'] = 'images/' . $imageName;
        }

        $employee = PersonalInfoEmp::create($validated);

        return response()->json([
            'success' => 'បុគ្គលិកបានរក្សាទុកដោយជោគជ័យ។',
            'employee' => $employee
        ], 201);
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        return response()->json(['error' => 'អ្នកមិនមានសិទ្ធិបង្កើតអ៊ែតបុគ្គលិកថ្មីបន្ថែមទេ។'], 403);
    } catch (\Exception $ex) {
        return response()->json(['error' => 'មានបញ្ហាដែលមិនបានរំពឹងទុកកើតឡើង៖ ' . $ex->getMessage()], 500);
    }
    }



    public function index()
    {
        
        // $this->authorize('viewAny', PersonalInfoEmp::class);
        $provinces = Province::all();
        return view('Employee.PersonalInfoEmp', ['provinces' => $provinces]);
    }

    // public function index()
    // {
    //     try {
    //     $this->authorize('viewAny', PersonalInfoEmp::class);
    //     $provinces = Province::all();
    //     return view('Employee.PersonalInfoEmp', ['provinces' => $provinces]);
    // } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
    //     return response()->json(['error' => 'អ្នកមិនមានសិទ្ធិមើលព័ត៌មានបុគ្គលិកទេ។'], 403);
    // }
    // }
    public function getAllData()
    {
        // $this->authorize('viewAny', PersonalInfoEmp::class);
        
        $employees = PersonalInfoEmp::select(
            'EmployeeID',  
            'Emp_as_khmerID',
            'FirstName',
            'LastName',
            'LatinName',
            'Gender',
            'DateOfBirth',
            'Nationality',
            'Phone',
            'Photo',
            'BirthVillage',
            'BirthCommuneWard',
            'BirthDistrict',
            'BirthProvinceID',
            'HouseNumber',
            'GroupNumber',
            'AddressVillage',
            'AddressCommuneWard',
            'AddressDistrict',
            'AddressProvinceID'
        )
        ->with(['birthProvince:ProvinceID,ProvinceName', 'addressProvince:ProvinceID,ProvinceName'])
        ->get()
        ->map(function ($employee) {
            $employee->BirthProvinceName = $employee->birthProvince->ProvinceName ?? null;
            $employee->AddressProvinceName = $employee->addressProvince->ProvinceName ?? null;
            unset($employee->birthProvince, $employee->addressProvince);
            
            // Check permissions for the current user
            $employee->canUpdate = Gate::allows('update', $employee);
            $employee->canDelete = Gate::allows('delete', $employee);
            
            return $employee;
        });

        return response()->json($employees);
    }

    // public function getEmployeeById($id)
    // {
    //     $employee = PersonalInfoEmp::find($id);

    //     if ($employee) {
    //         return response()->json($employee);
    //     } else {
    //         return response()->json(['error' => 'Employee not found.'], 404);
    //     }
    // }


    public function getEmployeeById($id)
{
    $employee = PersonalInfoEmp::findOrFail($id);

    try {
        // អនុញ្ញាតសកម្មភាព getEmployeeById
        $this->authorize('getEmployeeById', $employee);

        return response()->json($employee);
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        // បញ្ជាក់សារសម្រាប់សកម្មភាពដែលមិនត្រូវបានអនុញ្ញាត
        return response()->json(['error' => 'អ្នកមិនមានសិទ្ធិgetEmployeeByIdនេះទេ។'], 403);
    } catch (\Exception $ex) {
        return response()->json(['error' => 'មានកំហុសដែលមិនបានរំពឹងទុកកើតឡើង៖ ' . $ex->getMessage()], 500);
    }
}


    public function updateEmployee(Request $request, $id)
    {
        $employee = PersonalInfoEmp::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found.'], 404);
        }
        try {
        $this->authorize('update', $employee);

        $messages = [
            'Emp_as_khmerID.required' => 'សូមបញ្ចូលអត្តលេខបុគ្គលិក។',
            'Emp_as_khmerID.unique' => 'អត្តលេខនេះមានរួចហើយ។ សូមព្យាយាមបញ្ចូលអត្តលេខថ្មី។',
            'FirstName.required' => 'សូមបញ្ចូលគោត្តនាម។', 
            'LastName.required' => 'សូមបញ្ចូលនាម។',
            'Gender.required' => 'សូមជ្រើសភេទ។',
            'Phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ។',
            'DateOfBirth.required' => 'សូមបញ្ចូលថ្ងៃខែឆ្នាំកំណើត។',
            'DateOfBirth.date' => 'សូមបញ្ចូលថ្ងៃខែឆ្នាំកំណើតឱ្យបានត្រឹមត្រូវ។',
            'Nationality.required' => 'សូមបញ្ចូលសញ្ជាតិ។',
            'LatinName.required' => 'សូមបញ្ចូលឈ្មោះអក្សរឡាតាំង។',
            'Photo.image' => 'រូបភាពត្រូវតែជាប្រភេទ JPEG, PNG, JPG, GIF។',
            'Photo.max' => 'រូបភាពមិនត្រូវធំជាង 2MB។',
            'BirthVillage.required' => 'សូមបញ្ចូលភូមិកំណើត។',
            'BirthCommuneWard.required' => 'សូមបញ្ចូលឃុំ/សង្កាត់កំណើត។',
            'BirthDistrict.required' => 'សូមបញ្ចូលស្រុក/ខណ្ឌកំណើត។',
            'BirthProvinceID.required' => 'សូមជ្រើសរើសខេត្ត/រាជធានីកំណើត។',
            'BirthProvinceID.exists' => 'ខេត្ត/រាជធានីកំណើតដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'HouseNumber.required' => 'សូមបញ្ចូលផ្ទះលេខ។',
            'GroupNumber.required' => 'សូមបញ្ចូលក្រុមលេខ។',
            'AddressVillage.required' => 'សូមបញ្ចូលភូមិស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressCommuneWard.required' => 'សូមបញ្ចូលឃុំ/សង្កាត់ស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressDistrict.required' => 'សូមបញ្ចូលស្រុក/ខណ្ឌស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressProvinceID.required' => 'សូមជ្រើសរើសខេត្ត/រាជធានីស្នាក់នៅបច្ចុប្បន្ន។',
            'AddressProvinceID.exists' => 'ខេត្ត/រាជធានីដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
        ];
    
        $validated = $request->validate([
            'Emp_as_khmerID' => 'required|unique:personal_info_emp,Emp_as_khmerID,' . $id . ',EmployeeID',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Gender' => 'required',
            'Phone' => 'required',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'DateOfBirth' => 'required|date',
            'Nationality' => 'required',
            'LatinName' => 'required',
            'BirthVillage' => 'required|string',
            'BirthCommuneWard' => 'required|string',
            'BirthDistrict' => 'required|string',
            'BirthProvinceID' => 'required|exists:provinces,ProvinceID',
            'HouseNumber' => 'required|string',
            'GroupNumber' => 'required|string',
            'AddressVillage' => 'required|string',
            'AddressCommuneWard' => 'required|string',
            'AddressDistrict' => 'required|string',
            'AddressProvinceID' => 'required|exists:provinces,ProvinceID',
        ], $messages);

        if ($request->hasFile('Photo')) {
            $image = $request->file('Photo');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['Photo'] = 'images/' . $imageName;

            if ($employee->Photo && file_exists(public_path($employee->Photo))) {
                unlink(public_path($employee->Photo));
            }
        }

        $employee->update($validated);

        return response()->json([
            'success' => 'Employee updated successfully.',
            'employee' => $employee
        ]);
    } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        return response()->json(['error' => 'អ្នកមិនមានសិទ្ធិក្នុងការកែប្រែព័ត៌មានបុគ្គលិកនេះទេ។'], 403);
    } catch (\Exception $ex) {
        return response()->json(['error' => 'មានបញ្ហាដែលមិនបានរំពឹងទុកកើតឡើង៖ ' . $ex->getMessage()], 500);
    }
    }
    public function deleteEmployee($id)
    {
        $employee = PersonalInfoEmp::findOrFail($id);
    
        try {
            $this->authorize('delete', $employee);
            $employee->delete();
    
            return response()->json(['message' => 'បុគ្គលិកត្រូវបានលុបដោយជោគជ័យ។'], 200);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // សារសម្រាប់សកម្មភាពដែលគ្មានការអនុញ្ញាត
            return response()->json(['error' => 'អ្នកមិនមានសិទ្ធិលុបបុគ្គលិកនេះទេ។'], 403);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'មានកំហុសដែលមិនបានរំពឹងទុក៖ ' . $ex->getMessage()], 500);
        }
    }
    

    public function getEmployeeDetails($id)
    {
        $employeeDetails = PersonalInfoEmp::where('EmployeeID', $id)
            ->select([
                'EmployeeID',
                'Emp_as_khmerID',
                'FirstName',
                'LastName',
                'LatinName',
                'Gender',
                'DateOfBirth',
                'Nationality',
                'Phone',
                'Photo',
                'BirthVillage',
                'BirthCommuneWard',
                'BirthDistrict',
                'BirthProvinceID',
                'HouseNumber',
                'GroupNumber',
                'AddressVillage',
                'AddressCommuneWard',
                'AddressDistrict',
                'AddressProvinceID'
            ])
            ->with(['birthProvince:ProvinceID,ProvinceName', 'addressProvince:ProvinceID,ProvinceName'])
            ->first();

        if (!$employeeDetails) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employeeDetails->DateOfBirth = $employeeDetails->DateOfBirth ? $employeeDetails->DateOfBirth->format('Y-m-d') : null;
        $employeeDetails->PhotoUrl = $employeeDetails->Photo ? url('images/' . $employeeDetails->Photo) : null;
        $employeeDetails->BirthProvinceName = $employeeDetails->birthProvince ? $employeeDetails->birthProvince->ProvinceName : null;
        $employeeDetails->AddressProvinceName = $employeeDetails->addressProvince ? $employeeDetails->addressProvince->ProvinceName : null;

        return response()->json($employeeDetails);
    }
}


