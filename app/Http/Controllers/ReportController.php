<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\GovernmentEmployedDoctorsExport;

use App\Exports\GovernmentEmployedDoctorsExport_by_BuildingName;
use App\Exports\HiredMedicalOfficersExport;
use App\Exports\HiredNotMedicalOfficersExport;
use App\Models\Building;
use App\Models\EmploymentStatus;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function getGovernmentEmployedReport(Request $request)
    {
        try {
            $query = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
                ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
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
                );

            if ($request->has('date1') && $request->has('date2') && $request->has('dateField')) {
                $date1 = $request->input('date1');
                $date2 = $request->input('date2');
                $dateField = $request->input('dateField');

                if (in_array($dateField, ['StartDate', 'EndDate'])) {
                    $query->whereBetween('ged.' . $dateField, [$date1, $date2]);
                } else if($dateField == 'CurrentPositionDate'){
                    $query->whereBetween('ged.CurrentPositionDate', [$date1, $date2]);
                } else {
                    $query->whereBetween('ged.StartDate', [$date1, $date2]);
                }
            }

            $doctorDetails = $query->get();

            if ($doctorDetails->isEmpty()) {
                return response()->json(['error' => 'No Government Employed Doctors found'], 404);
            }

            $dateFields = [
                'StartDate', 'EndDate', 'CurrentPositionDate',
                'DateOfBirth', 'EducationStartDate', 'EducationEndDate'
            ];

            foreach ($doctorDetails as $doctor) {
                foreach ($dateFields as $field) {
                    if (!empty($doctor->$field)) {
                        $doctor->$field = date('d-m-Y', strtotime($doctor->$field));
                    }
                }
            }

            return response()->json($doctorDetails);

        } catch (\Exception $ex) {
            return response()->json(['error' => 'An error occurred: ' . $ex->getMessage()], 500);
        }
    }

    public function getHiredMedicalOfficerReport(Request $request)
    {
        try {
            $query = DB::table('hired_medical_officers as hmo')
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
                );

            if ($request->has('date1') && $request->has('date2') && $request->has('dateField')) {
                $date1 = $request->input('date1');
                $date2 = $request->input('date2');
                $dateField = $request->input('dateField');

                if (in_array($dateField, ['StartDate'])) {
                    $query->whereBetween('hmo.' . $dateField, [$date1, $date2]);
                } else if($dateField == 'CurrentPositionDate'){
                    $query->whereBetween('hmo.CurrentPositionDate', [$date1, $date2]);
                } else {
                    $query->whereBetween('hmo.StartDate', [$date1, $date2]);
                }
            }

            $officerDetails = $query->get();

            if ($officerDetails->isEmpty()) {
                return response()->json(['error' => 'No Hired Medical Officers found'], 404);
            }

            $dateFields = [
                'StartDate', 'CurrentPositionDate', 'DateOfBirth', 'EducationStartDate', 'EducationEndDate'
            ];

            foreach ($officerDetails as $officer) {
                foreach ($dateFields as $field) {
                    if (!empty($officer->$field)) {
                        $officer->$field = date('d-m-Y', strtotime($officer->$field));
                    }
                }
            }

            return response()->json($officerDetails);

        } catch (\Exception $ex) {
            return response()->json(['error' => 'An error occurred: ' . $ex->getMessage()], 500);
        }
    }

    public function getHiredNotMedicalOfficerReport(Request $request)
    {
        try {
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');
            $dateField = $request->input('dateField', 'StartDate');

            $query = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->select(
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.LatinName',
                    'emp.Gender',
                    'emp.DateOfBirth',
                    'hnmo.StartDate',
                    'hnmo.CurrentPositionDate',
                    'p.PositionName',
                    'ce.CategoryEmployeeName',
                    'e.Degree',
                    's.SkillName',
                    'e.School',
                    'e.Country',
                    'b.BuildingName',
                    'emp.Phone',
                    'hnmo.Institution'
                );

            if ($date1 && $date2) {
                if (in_array($dateField, ['StartDate', 'CurrentPositionDate'])) {
                    $query->whereBetween('hnmo.' . $dateField, [$date1, $date2]);
                } else {
                    $query->whereBetween('hnmo.StartDate', [$date1, $date2]);
                }
            }

            $officerDetails = $query->get();

            if ($officerDetails->isEmpty()) {
                return response()->json(['error' => 'No Hired Not Medical Officers found'], 404);
            }

            $dateFields = ['StartDate', 'CurrentPositionDate', 'DateOfBirth'];

            foreach ($officerDetails as $officer) {
                foreach ($dateFields as $field) {
                    if (!empty($officer->$field)) {
                        $officer->$field = date('d-m-Y', strtotime($officer->$field));
                    }
                }
            }

            return response()->json($officerDetails);

        } catch (\Exception $ex) {
            return response()->json(['error' => 'An error occurred: ' . $ex->getMessage()], 500);
        }
    }

    public function getGovernmentEmployedReport_by_BuildingName(Request $request)
    {
        try {
            $query = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->leftJoin('provinces as bp', 'emp.BirthProvinceID', '=', 'bp.ProvinceID')
                ->leftJoin('provinces as ap', 'emp.AddressProvinceID', '=', 'ap.ProvinceID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
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
                );
    
            if ($request->has('BuildingName')) {
                $buildingName = $request->input('BuildingName');
                $query->where('b.BuildingName', 'LIKE', '%' . $buildingName . '%');
            }

            if ($request->has('EmploymentStatus')) {
                $statusName = $request->input('EmploymentStatus');
                $query->where('es.StatusName', 'LIKE', '%' . $statusName . '%');
            }
    
            if ($request->has('date1') && $request->has('date2') && $request->has('dateField')) {
                $date1 = $request->input('date1');
                $date2 = $request->input('date2');
                $dateField = $request->input('dateField');
    
                if (in_array($dateField, ['StartDate', 'EndDate', 'CurrentPositionDate'])) {
                    $query->whereBetween('ged.' . $dateField, [$date1, $date2]);
                } else {
                    $query->whereBetween('ged.StartDate', [$date1, $date2]);
                }
            }
    
            $doctorDetails = $query->get();
    
            if ($doctorDetails->isEmpty()) {
                return response()->json(['error' => 'No Government Employed Doctors found for the specified criteria.'], 404);
            }
    
            $dateFields = [
                'StartDate', 'EndDate', 'CurrentPositionDate',
                'DateOfBirth', 'EducationStartDate', 'EducationEndDate'
            ];
    
            foreach ($doctorDetails as $doctor) {
                foreach ($dateFields as $field) {
                    if (!empty($doctor->$field)) {
                        $doctor->$field = date('d-m-Y', strtotime($doctor->$field));
                    }
                }
            }
    
            return response()->json($doctorDetails);
    
        } catch (\Exception $ex) {
            return response()->json(['error' => 'An error occurred: ' . $ex->getMessage()], 500);
        }
    }

    public function showGovernmentEmployedReportByBuilding()
    {
        $buildings = Building::all(); 
        $statuses = EmploymentStatus::all();
        return view('report.GovernmentEmployedReport_by_BuildingName', compact('buildings', 'statuses'));
    }
}
