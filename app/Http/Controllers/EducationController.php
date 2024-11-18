<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\PersonalInfoEmp;
use Illuminate\Support\Facades\DB;

class EducationController extends Controller
{
    public function show() 
    {
        $employees = PersonalInfoEmp::select('EmployeeID', 'FirstName', 'LastName', 'Gender', 'Phone', 'Emp_as_khmerID')->get();
    
        return view('education.Education', compact('employees'));
    }

    public function getAllData()
    {
        $result = DB::table('education as e')
            ->join('personal_info_emp as emp', 'e.EmployeeID', '=', 'emp.EmployeeID')
            ->select(
                'e.EducationID',
                'emp.FirstName',
                'emp.LastName',
                'emp.EmployeeID',
                'emp.Emp_as_khmerID',
                'emp.Gender',
                'emp.Phone',
                'emp.Photo',
                'e.EducationLevel',
                'e.Country',
                'e.School',
                'e.Degree',
                'e.StartDate',
                'e.EndDate'
            )
            ->distinct()
            ->get();

        return response()->json($result);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID',
            'EducationLevel' => 'required|string|max:255',
            'Country' => 'required|string|max:255',
            'School' => 'required|string|max:255',
            'Degree' => 'required|string|max:255',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
        ], [
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'EducationLevel.required' => 'សូមបញ្ចូលវគ្គ ឫ កម្រិតសិក្សា។',
            'Country.required' => 'សូមបញ្ចូលប្រទេស។',
            'School.required' => 'សូមបញ្ចូលទីកន្លែងសិក្សា។',
            'Degree.required' => 'សូមបញ្ចូលសញ្ញាបត្រ។',
            'StartDate.required' => 'សូមបញ្ចូលថ្ងៃចូលសិក្សា។',
            'EndDate.required' => 'សូមបញ្ចូលថ្ងៃបញ្ចប់ការសិក្សា។',
            'EndDate.after' => 'ថ្ងៃបញ្ចប់ការសិក្សាត្រូវតែក្រោយថ្ងៃចូលសិក្សា។',
        ]);

        $education = Education::create($validatedData);
        return response()->json(['message' => 'បញ្ចូលទិន្នន័យបានជោគជ័យ', 'data' => $education]);
    }

    public function getDataById($id)
    {
        $result = DB::table('education as e')
            ->join('personal_info_emp as emp', 'e.EmployeeID', '=', 'emp.EmployeeID')
            ->where('e.EducationID', $id)
            ->select(
                'e.EducationID',
                'e.EmployeeID',
                'e.EducationLevel',
                'e.Country',
                'e.School',
                'e.Degree',
                'e.StartDate',
                'e.EndDate',
                'emp.FirstName',
                'emp.LastName',
                'emp.Photo',
                'emp.Phone'
            )
            ->first();

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'EducationLevel' => 'required|string|max:255',
            'Country' => 'required|string|max:255',
            'School' => 'required|string|max:255',
            'Degree' => 'required|string|max:255',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
        ], [
            'EducationLevel.required' => 'សូមបញ្ចូលវគ្គ ឫ កម្រិតសិក្សា។',
            'Country.required' => 'សូមបញ្ចូលប្រទេស។',
            'School.required' => 'សូមបញ្ចូលទីកន្លែងសិក្សា។',
            'Degree.required' => 'សូមបញ្ចូលសញ្ញាបត្រ។',
            'StartDate.required' => 'សូមបញ្ចូលថ្ងៃចូលសិក្សា។',
            'EndDate.required' => 'សូមបញ្ចូលថ្ងៃបញ្ចប់ការសិក្សា។',
            'EndDate.after' => 'ថ្ងៃបញ្ចប់ការសិក្សាត្រូវតែក្រោយថ្ងៃចូលសិក្សា។',
        ]);

        $education = Education::findOrFail($id);
        $education->update($validatedData);
        return response()->json(['message' => 'បច្ចុប្បន្នភាពបានជោគជ័យ', 'data' => $education]);
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
    public function getEducationDetails($id)
    {
        $educationDetails = DB::table('education as e')
            ->join('personal_info_emp as emp', 'e.EmployeeID', '=', 'emp.EmployeeID')
            ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
            ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
            ->where('e.EducationID', $id)
            ->select(
                'e.EducationID',
                'e.EducationLevel',
                'e.Country',
                'e.School',
                'e.Degree',
                'e.StartDate',
                'e.EndDate',
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
                'ap.ProvinceName as AddressProvinceName'
            )
            ->first();

        if (!$educationDetails) {
            return response()->json(['error' => 'Education record not found'], 404);
        }

        // Format the dates
        if ($educationDetails->StartDate) {
            $educationDetails->StartDate = date('d-m-Y', strtotime($educationDetails->StartDate));
        }
        if ($educationDetails->EndDate) {
            $educationDetails->EndDate = date('d-m-Y', strtotime($educationDetails->EndDate));
        }
        if ($educationDetails->DateOfBirth) {
            $educationDetails->DateOfBirth = date('d-m-Y', strtotime($educationDetails->DateOfBirth));
        }

        return response()->json($educationDetails);
    }

    public function delete($id)
    {
        try {
            $education = Education::findOrFail($id);
            $education->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
