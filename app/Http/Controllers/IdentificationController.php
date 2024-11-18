<?php

namespace App\Http\Controllers;

use App\Models\Identification;
use App\Models\PersonalInfoEmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentificationController extends Controller
{

    public function show() 
    {
        $employees = PersonalInfoEmp::select('EmployeeID', 'FirstName', 'LastName', 'Gender', 'Phone', 'Emp_as_khmerID')->get();
    
       
        return view('identifications.Identification', compact('employees'));
    }
    

    

    public function getAllData()
    {
        $result = DB::table('identifications as i')
            ->join('personal_info_emp as emp', 'i.EmployeeID', '=', 'emp.EmployeeID')
            ->select(
                'i.IdentificationID',
                'emp.FirstName',
                'emp.LastName',
                'emp.EmployeeID',
                'emp.Emp_as_khmerID',
                'emp.Gender',
                'emp.Phone',
                'emp.Photo',
                'i.NationalID',
                'i.CivilServantID',
                'i.EmployeeCode'
            )
            ->distinct()
            ->get();

        return response()->json($result);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID',
            'NationalID' => 'required|string|max:255',
            'CivilServantID' => 'required|string|max:255',
            'EmployeeCode' => 'required|string|max:255',
        ], [
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'NationalID.required' => 'សូមបញ្ចូលអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ។',
            'CivilServantID.required' => 'សូមបញ្ចូលលេខសម្គាល់ចំនួនមន្ត្រីរាជការ។',
            'EmployeeCode.required' => 'សូមបញ្ចូលអត្តលេខមន្ត្រីក្របខណ្ឌ។',
        ]);

        $identification = Identification::create($validatedData);
        return response()->json(['message' => 'បញ្ចូលទិន្នន័យបានជោគជ័យ', 'data' => $identification]);
    }

    public function getDataById($id)
    {
        $result = DB::table('identifications as ident')
            ->join('personal_info_emp as emp', 'ident.EmployeeID', '=', 'emp.EmployeeID')
            ->where('ident.IdentificationID', $id)
            ->select(
                'ident.IdentificationID',
                'ident.EmployeeID',
                'ident.NationalID',
                'ident.CivilServantID',
                'ident.EmployeeCode',
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
            'EmployeeID' => 'required|exists:personal_info_emp,EmployeeID',
            'NationalID' => 'required|string|max:255',
            'CivilServantID' => 'required|string|max:255',
            'EmployeeCode' => 'required|string|max:255',
        ], [
            'EmployeeID.required' => 'សូមជ្រើសរើសបុគ្គលិក។',
            'EmployeeID.exists' => 'បុគ្គលិកដែលបានជ្រើសរើសមិនមានក្នុងប្រព័ន្ធ។',
            'NationalID.required' => 'សូមបញ្ចូលអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ។',
            'CivilServantID.required' => 'សូមបញ្ចូលលេខសម្គាល់ចំនួនមន្ត្រីរាជការ។',
            'EmployeeCode.required' => 'សូមបញ្ចូលអត្តលេខមន្ត្រីក្របខណ្ឌ។',
        ]);

        $identification = Identification::findOrFail($id);
        $identification->update($validatedData);
        return response()->json(['message' => 'កែប្រែទិន្នន័យបានជោគជ័យ', 'data' => $identification]);
    }
    public function getEmployeePhoto($employeeId = null)
    {
        if ($employeeId === null) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $employee = PersonalInfoEmp::where('EmployeeID', $employeeId)
                                   ->select('Photo')
                                   ->first();

        if ($employee) {
            return response()->json(['photo' => $employee->Photo]);
        } else {
            return response()->json(['photo' => '']);
        }
    }

    public function getIdentificationDetails($id)
    {
        $identificationDetails = DB::table('identifications as i')
            ->join('personal_info_emp as emp', 'i.EmployeeID', '=', 'emp.EmployeeID')
            ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
            ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
            ->where('i.IdentificationID', $id)
            ->select(
                'i.IdentificationID',
                'i.NationalID',
                'i.CivilServantID',
                'i.EmployeeCode',
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

        if (!$identificationDetails) {
            return response()->json(['error' => 'Identification not found'], 404);
        }

        // Format the DateOfBirth
        if ($identificationDetails->DateOfBirth) {
            $identificationDetails->DateOfBirth = date('d-m-Y', strtotime($identificationDetails->DateOfBirth));
        }

        return response()->json($identificationDetails);
    }


    public function delete($id)
    {
        try {
            $identification = Identification::findOrFail($id);
            $identification->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
