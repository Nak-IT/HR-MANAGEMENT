<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GovernmentEmployedDoctor;
use App\Models\HiredMedicalOfficer;
use App\Models\HiredNotMedicalOfficer;
use App\Models\EmploymentStatus;
use App\Models\PersonalInfoEmp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers extends Controller
{
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_type' => 'required',
            'EmployeeID' => 'required',
            'StatusID' => 'required',
            'EndDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $employeeType = $request->input('employee_type');
        $employeeId = $request->input('EmployeeID');
        $statusId = $request->input('StatusID');

        try {
            if ($employeeType == 'government_employed_doctor') {
                $employee = GovernmentEmployedDoctor::where('EmployeeID', $employeeId)->first();

                if (!$employee) {
                    return response()->json(['error' => 'Employee not found'], 404);
                }
            } elseif ($employeeType == 'hired_medical_officer') {
                $employee = HiredMedicalOfficer::where('EmployeeID', $employeeId)->first();

                if (!$employee) {
                    return response()->json(['error' => 'Employee not found'], 404);
                }
            } elseif ($employeeType == 'hired_not_medical_officer') {
                $employee = HiredNotMedicalOfficer::where('EmployeeID', $employeeId)->first();

                if (!$employee) {
                    return response()->json(['error' => 'Employee not found'], 404);
                }
            } else {
                return response()->json(['error' => 'Invalid employee type'], 400);
            }

          
            $employee->StatusID = $statusId;
            $employee->EndDate = $request->input('EndDate');
            $employee->save();

            $status = EmploymentStatus::find($statusId);
            $statusName = $status ? $status->StatusName : 'Unknown';

            return response()->json(['message' => 'Status and EndDate updated successfully', 'data' => $employee, 'status_name' => $statusName]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStatuses()
    {
        $statuses = EmploymentStatus::all();
        return response()->json($statuses);
    }

    public function getEmployees(Request $request)
    {
        $employeeType = $request->input('employee_type');

        try {
            if ($employeeType == 'government_employed_doctor') {
                $employees = DB::table('government_employed_doctors as ged')
                    ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                    ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                    ->select('emp.EmployeeID', 'emp.FirstName', 'emp.LastName', 'emp.Emp_as_khmerID', 'i.EmployeeCode')
                    ->get();
            } elseif ($employeeType == 'hired_medical_officer') {
                $employees = DB::table('hired_medical_officers as hmo')
                    ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                    ->select('emp.EmployeeID', 'emp.FirstName', 'emp.LastName', 'emp.Emp_as_khmerID')
                    ->get();
            } elseif ($employeeType == 'hired_not_medical_officer') {
                $employees = DB::table('hired_not_medical_officers as hnmo')
                    ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                    ->select('emp.EmployeeID', 'emp.FirstName', 'emp.LastName', 'emp.Emp_as_khmerID')
                    ->get();
            } else {
                return response()->json(['error' => 'Invalid employee type'], 400);
            }

            
            $employees = $employees->map(function ($employee) {
                $employee->EmployeeID = (string) $employee->EmployeeID;
                return $employee;
            });

            return response()->json($employees);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
       
        $employees = [];
        $statuses = EmploymentStatus::all();

        return view('update_status.index', compact('employees', 'statuses'));
    }

    public function filterEmployees(Request $request)
    {
        $employeeType = $request->input('employee_type');
        $employees = [];

        if ($employeeType == 'government_employed_doctor') {
            $employees = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->select(
                    'emp.EmployeeID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Emp_as_khmerID',
                    'emp.Photo',
                    'emp.DateOfBirth',
                    'emp.Gender',
                    'emp.Phone',
                    'ged.StatusID',
                    'es.StatusName',
                    'i.NationalID',
                    'i.CivilServantID',
                    'i.EmployeeCode',
                    'd.DepartmentName'
                )
                ->get();
        } elseif ($employeeType == 'hired_medical_officer') {
            $employees = DB::table('hired_medical_officers as hmo')
                ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
                ->select(
                    'emp.EmployeeID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Emp_as_khmerID',
                    'emp.Photo',
                    'emp.DateOfBirth',
                    'emp.Gender',
                    'emp.Phone',
                    'hmo.StatusID',
                    'es.StatusName',
                    'i.NationalID',
                    'i.CivilServantID',
                    'i.EmployeeCode',
                    'd.DepartmentName'
                )
                ->get();
        } elseif ($employeeType == 'hired_not_medical_officer') {
            $employees = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                ->select(
                    'emp.EmployeeID',
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.Emp_as_khmerID',
                    'emp.Photo',
                    'emp.DateOfBirth',
                    'emp.Gender',
                    'emp.Phone',
                    'hnmo.StatusID',
                    'es.StatusName',
                    'i.NationalID',
                    'i.CivilServantID',
                    'i.EmployeeCode',
                    's.SkillName'
                )
                ->get();
        } else {
            return response()->json(['error' => 'Invalid employee type'], 400);
        }

       
        $employees = $employees->map(function ($employee) use ($employeeType) {
            return [
                'EmployeeID' => (string) $employee->EmployeeID, 
                'FirstName' => $employee->FirstName,
                'LastName' => $employee->LastName,
                'Emp_as_khmerID' => $employee->Emp_as_khmerID,
                'StatusID' => $employee->StatusID,
                'StatusName' => $employee->StatusName,
                'Photo' => $employee->Photo,
                'Gender' => $employee->Gender,
                'NationalID' => $employee->NationalID ?? '',
                'CivilServantID' => $employee->CivilServantID ?? '',
                'EmployeeCode' => $employee->EmployeeCode ?? '',
                'EmployeeType' => $employeeType, 
                'DepartmentName' => $employee->DepartmentName ?? '',
                'SkillName' => $employee->SkillName ?? '',
            ];
        });

        return response()->json(['employees' => $employees]);
    }

    // public function getEmployeeStatus(Request $request)
    // {
    //     $employeeId = $request->input('EmployeeID');
    //     $employeeType = $request->input('employee_type');

    //     try {
    //         if ($employeeType == 'government_employed_doctor') {
    //             $status = DB::table('government_employed_doctors')
    //                 ->where('EmployeeID', $employeeId)
    //                 ->value('StatusID');
    //         } elseif ($employeeType == 'hired_medical_officer') {
    //             $status = DB::table('hired_medical_officers')
    //                 ->where('EmployeeID', $employeeId)
    //                 ->value('StatusID');
    //         } elseif ($employeeType == 'hired_not_medical_officer') {
    //             $status = DB::table('hired_not_medical_officers')
    //                 ->where('EmployeeID', $employeeId)
    //                 ->value('StatusID');
    //         } else {
    //             return response()->json(['error' => 'Invalid employee type'], 400);
    //         }

    //         if (!$status) {
    //             return response()->json(['error' => 'Employee not found'], 404);
    //         }

    //         return response()->json(['StatusID' => $status]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


    public function getEmployeeStatus(Request $request)
    {
        $employeeId = $request->input('EmployeeID');
        $employeeType = $request->input('employee_type');
    
        try {
            if ($employeeType == 'government_employed_doctor') {
                $employee = GovernmentEmployedDoctor::where('EmployeeID', $employeeId)->first();
            } elseif ($employeeType == 'hired_medical_officer') {
                $employee = HiredMedicalOfficer::where('EmployeeID', $employeeId)->first();
            } elseif ($employeeType == 'hired_not_medical_officer') {
                $employee = HiredNotMedicalOfficer::where('EmployeeID', $employeeId)->first();
            } else {
                return response()->json(['error' => 'Invalid employee type'], 400);
            }
    
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
    
           
            $statusName = EmploymentStatus::where('StatusID', $employee->StatusID)->value('StatusName');
    
         
            $formattedEndDate = $employee->EndDate ? date('Y-m-d', strtotime($employee->EndDate)) : null;
    
            return response()->json([
                'StatusID' => $employee->StatusID,
                'StatusName' => $statusName,
                'EndDate' => $formattedEndDate,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    


    public function getEmployeePhoto($id)
{
    try {
        $employee = DB::table('personal_info_emp')
            ->where('EmployeeID', $id)
            ->select('Photo')
            ->first();

        if ($employee && $employee->Photo) {
            return response()->json(['photo' => $employee->Photo]);
        } else {
            return response()->json(['photo' => null]);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    
}
