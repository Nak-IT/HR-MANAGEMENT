<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployedExports_Detail_second implements FromQuery, WithMapping, WithHeadings, WithStyles, WithEvents
{
    use Exportable;

    protected $buildingName;
    protected $statusNames = [];
    protected $categoryEmployeeName;
    protected $date1;
    protected $date2;
    protected $dateField;
    protected $sortColumn;
    protected $sortDirection;
    private $rowNumber = 0;
    private $headerRowCount;
    private $maleCount = 0;
    private $femaleCount = 0;
    protected $employeeTypes;

    public function __construct($buildingName, $statusNames = [], $categoryEmployeeName = null, $date1 = null, $date2 = null, $dateField = 'StartDate', $sortColumn = null, $sortDirection = 'asc', $employeeTypes = [])
    {
        $this->buildingName = $buildingName;
        $this->statusNames = $statusNames;
        $this->categoryEmployeeName = $categoryEmployeeName;
        $this->date1 = $date1;
        $this->date2 = $date2;
        $this->dateField = $dateField;
        $this->sortColumn = $sortColumn;
        $this->sortDirection = $sortDirection;
        $this->headerRowCount = 0; // Initial value, will be updated in registerEvents
        $this->employeeTypes = $employeeTypes;
    }

    public function query()
    {
        $queries = [];

        if (!$this->employeeTypes || in_array('GovernmentEmployedDoctor', $this->employeeTypes)) {
            // Build $query1 and apply filters
            $query1 = DB::table('government_employed_doctors as ged')
                ->join('personal_info_emp as emp', 'ged.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'ged.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'ged.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'ged.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'ged.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'ged.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->select(
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.LatinName',
                    'emp.Gender',
                    'emp.DateOfBirth',
                    'ged.StartDate',
                    'ged.CurrentPositionDate',
                    'ged.EndDate',
                    'p.PositionName',
                    'd.DepartmentName',
                    'b.BuildingName',
                    'es.StatusName',
                    'ged.government_employed_doctorID as ID',
                    DB::raw('NULL as SkillName'),
                    'ce.CategoryEmployeeName',
                    DB::raw('NULL as Institution'),
                    'ged.EmploymentCategory',
                    'e.Degree',
                    'e.School',
                    'e.Country',
                    'emp.Phone',
                    'i.EmployeeCode'
                );

            // Apply filters to $query1
            if ($this->buildingName) {
                $query1->where('b.BuildingName', 'LIKE', '%' . $this->buildingName . '%');
            }
            if (!empty($this->statusNames)) {
                $query1->whereIn('es.StatusName', $this->statusNames);
            }
            if ($this->categoryEmployeeName) {
                $query1->where('ce.CategoryEmployeeName', 'LIKE', '%' . $this->categoryEmployeeName . '%');
            }
            if ($this->date1 && $this->date2 && $this->dateField) {
                $query1->whereBetween($this->dateField, [$this->date1, $this->date2]);
            }

            $queries[] = $query1;
        }

        if (!$this->employeeTypes || in_array('HiredMedicalOfficer', $this->employeeTypes)) {
            // Build $query2 and apply filters
            $query2 = DB::table('hired_medical_officers as hmo')
                ->join('personal_info_emp as emp', 'hmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hmo.PositionID', '=', 'p.PositionID')
                ->join('departments as d', 'hmo.DepartmentID', '=', 'd.DepartmentID')
                ->join('buildings as b', 'hmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hmo.StatusID', '=', 'es.StatusID')
                ->join('category_employees as ce', 'hmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->select(
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.LatinName',
                    'emp.Gender',
                    'emp.DateOfBirth',
                    'hmo.StartDate',
                    'hmo.CurrentPositionDate',
                    'hmo.EndDate',
                    'p.PositionName',
                    'd.DepartmentName',
                    'b.BuildingName',
                    'es.StatusName',
                    'hmo.HiredMedicalOfficerID as ID',
                    DB::raw('NULL as SkillName'),
                    'ce.CategoryEmployeeName',
                    'hmo.Institution',
                    DB::raw('NULL as EmploymentCategory'),
                    'e.Degree',
                    'e.School',
                    'e.Country',
                    'emp.Phone',
                    'i.EmployeeCode'
                );

            // Apply filters to $query2
            if ($this->buildingName) {
                $query2->where('b.BuildingName', 'LIKE', '%' . $this->buildingName . '%');
            }
            if (!empty($this->statusNames)) {
                $query2->whereIn('es.StatusName', $this->statusNames);
            }
            if ($this->categoryEmployeeName) {
                $query2->where('ce.CategoryEmployeeName', 'LIKE', '%' . $this->categoryEmployeeName . '%');
            }
            if ($this->date1 && $this->date2 && $this->dateField) {
                $query2->whereBetween($this->dateField, [$this->date1, $this->date2]);
            }

            $queries[] = $query2;
        }

        if (!$this->employeeTypes || in_array('HiredNotMedicalOfficer', $this->employeeTypes)) {
            // Build $query3 and apply filters
            $query3 = DB::table('hired_not_medical_officers as hnmo')
                ->join('personal_info_emp as emp', 'hnmo.EmployeeID', '=', 'emp.EmployeeID')
                ->join('positions as p', 'hnmo.PositionID', '=', 'p.PositionID')
                ->join('buildings as b', 'hnmo.BuildingID', '=', 'b.BuildingID')
                ->join('employment_statuses as es', 'hnmo.StatusID', '=', 'es.StatusID')
                ->join('skills as s', 'hnmo.SkillID', '=', 's.SkillID')
                ->join('category_employees as ce', 'hnmo.CategoryEmployeeID', '=', 'ce.CategoryEmployeeID')
                ->leftJoin('identifications as i', 'emp.EmployeeID', '=', 'i.EmployeeID')
                ->leftJoin('education as e', 'emp.EmployeeID', '=', 'e.EmployeeID')
                ->select(
                    'emp.FirstName',
                    'emp.LastName',
                    'emp.LatinName',
                    'emp.Gender',
                    'emp.DateOfBirth',
                    'hnmo.StartDate',
                    'hnmo.CurrentPositionDate',
                    'hnmo.EndDate',
                    'p.PositionName',
                    DB::raw('NULL as DepartmentName'),
                    'b.BuildingName',
                    'es.StatusName',
                    'hnmo.HiredNotMedicalOfficerID as ID',
                    's.SkillName',
                    'ce.CategoryEmployeeName',
                    DB::raw('NULL as Institution'),
                    DB::raw('NULL as EmploymentCategory'),
                    'e.Degree',
                    'e.School',
                    'e.Country',
                    'emp.Phone',
                    'i.EmployeeCode'
                );

            // Apply filters to $query3
            if ($this->buildingName) {
                $query3->where('b.BuildingName', 'LIKE', '%' . $this->buildingName . '%');
            }
            if (!empty($this->statusNames)) {
                $query3->whereIn('es.StatusName', $this->statusNames);
            }
            if ($this->categoryEmployeeName) {
                $query3->where('ce.CategoryEmployeeName', 'LIKE', '%' . $this->categoryEmployeeName . '%');
            }
            if ($this->date1 && $this->date2 && $this->dateField) {
                $query3->whereBetween($this->dateField, [$this->date1, $this->date2]);
            }

            $queries[] = $query3;
        }

        // Combine the queries
        if (count($queries) == 0) {
            // No employee types selected, return an empty query
            return DB::table('personal_info_emp')->whereRaw('1=0');
        } else {
            // Combine the queries
            $combinedQuery = array_shift($queries);
            foreach ($queries as $q) {
                $combinedQuery = $combinedQuery->union($q);
            }

            // Apply sorting
            $sortBy = $this->getSortColumnName($this->sortColumn);

            return DB::table(DB::raw("({$combinedQuery->toSql()}) as subquery"))
                ->mergeBindings($combinedQuery)
                ->orderBy($sortBy, $this->sortDirection);
        }
    }

    private function getSortColumnName($sortColumnIndex)
    {
        switch ($sortColumnIndex) {
            case '1':
                return 'FirstName';
            case '2':
                return 'LatinName';
            case '3':
                return 'Gender';
            case '4':
                return 'DateOfBirth';
            case '5':
                return 'StartDate';
            // Add other cases as needed
            default:
                return 'ID';
        }
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $row->DateOfBirth = !empty($row->DateOfBirth) ? $this->formatKhmerDate($row->DateOfBirth) : '';
        $row->StartDate = !empty($row->StartDate) ? $this->formatKhmerDate($row->StartDate) : '';
        $row->CurrentPositionDate = !empty($row->CurrentPositionDate) ? $this->formatKhmerDate($row->CurrentPositionDate) : '';
        $row->EndDate = !empty($row->EndDate) ? $this->formatKhmerDate($row->EndDate) : '';

        $fullName = trim($row->FirstName . ' ' . $row->LastName);

        // Count male and female for the footer
        if ($row->Gender === 'ប្រុស') {
            $this->maleCount++;
        } elseif ($row->Gender === 'ស្រី') {
            $this->femaleCount++;
        }

        return [
            $this->rowNumber,
            $fullName,
            $row->LatinName,
            $row->Gender,
            $row->DateOfBirth,
            $row->StartDate,
            $row->EndDate ?? 'មិនទាន់បញ្ចូល',
            $row->PositionName,
            $row->EmploymentCategory ?? 'មិនមែនក្របខណ្ឌ',
            $row->Degree ?? 'មិនទាន់បញ្ចូល',
            $row->DepartmentName ?? $row->SkillName,
            $row->School ?? 'មិនទាន់បញ្ចូល',
            $row->Country ?? 'មិនទាន់បញ្ចូល',
            $row->BuildingName,
            $row->Phone,
            '', // Added empty field for 'ផ្សេងៗ'
        ];
    }

    private function formatKhmerDate($dateString)
    {
        if (!$dateString) return "";

        $khmerMonths = ["មករា", "កុម្ភៈ", "មិនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"];
        $khmerNumbers = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];

        $date = Carbon::parse($dateString);

        $day = implode('', array_map(function ($digit) use ($khmerNumbers) {
            return $khmerNumbers[(int)$digit];
        }, str_split($date->format('d'))));

        $year = implode('', array_map(function ($digit) use ($khmerNumbers) {
            return $khmerNumbers[(int)$digit];
        }, str_split($date->format('Y'))));

        return "{$day} {$khmerMonths[$date->month - 1]} {$year}";
    }

    public function headings(): array
    {
        return [
            [
                'ល.រ',
                'នាមនិងគោត្តនាម',
                'អក្សរឡាតាំង',
                'ភេទ',
                'កាលបរិច្ឆេទ',
                '',
                '',
                'តំណែងបច្ចុប្បន្ន',
                'ប្រភេទក្របខណ្ឌ',
                'សញ្ញាបត្រ',
                'ជំនាញ/ឯកទេស',
                'គ្រឹស្ថានសិក្សា',
                'ប្រទេស',
                'អាគារ',
                'លេខទូរស័ព្ទ',
                'ផ្សេងៗ', // Added new header for 'ផ្សេងៗ'
            ],
            [
                '',
                '',
                '',
                '',
                'ថ្ងៃខែឆ្នាំកំណើត',
                'ថ្ងៃចូលបម្រើការងារ',
                'ថ្ងៃចូលនិវត្តន៍',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '', // Added empty subheader for 'ផ្សេងៗ'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Calculate total rows (data + header)
        $totalRows = $this->rowNumber + $this->headerRowCount + 2;

        // Define the full cell range (headers + data rows)
        $cellRange = 'A1:P' . $totalRows; // Changed 'O' to 'P' to include the new column

        // Apply styles to the entire range
        $sheet->getStyle($cellRange)->applyFromArray([
            'font' => [
                'name' => 'Khmer OS Battambang',
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Apply styles to the header rows
        $sheet->getStyle('A' . ($this->headerRowCount + 1) . ':P' . ($this->headerRowCount + 2))->applyFromArray([
            'font' => [
                'name' => 'Khmer M1',
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'yellow'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'blue'],
            ],
        ]);

        // Merge cells for the main header
        $sheet->mergeCells('E' . ($this->headerRowCount + 1) . ':G' . ($this->headerRowCount + 1));

        // Apply conditional styling for non-empty rows dynamically
        for ($row = $this->headerRowCount + 3; $row <= $this->rowNumber + $this->headerRowCount + 2; $row++) {
            // Check if the row contains actual data (this assumes column A has the row number)
            if (!empty($sheet->getCell('A' . $row)->getValue())) {
                // Apply white background to the row with data
                $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFFFFF'], // White background
                    ],
                ]);
            }
        }

        // Auto size columns
        foreach (range('A', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }


    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
        
                // Insert header rows dynamically before the table
                $sheet->insertNewRowBefore(1, 7);
                $this->headerRowCount = 7;
        
                // 1. Centered header: "ព្រះរាជាណាចក្រកម្ពុជា"
                $sheet->mergeCells('A1:P1');
                $sheet->setCellValue('A1', 'ព្រះរាជាណាចក្រកម្ពុជា');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'name' => 'Khmer M1'],
                    'alignment' => ['horizontal' => 'center'],
                ]);
        
                // 2. Centered header: "ជាតិ សាសនា​ ព្រះមហាក្សត្រ"
                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', 'ជាតិ សាសនា​ ព្រះមហាក្សត្រ');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'name' => 'Khmer M1'],
                    'alignment' => ['horizontal' => 'center'],
                ]);
        
                // 3. Left-aligned "មន្ទីរសុខាភិបាលខេត្តបាត់ដំបង"
                $sheet->mergeCells('A4:P4');
                $sheet->setCellValue('A4', 'មន្ទីរសុខាភិបាលខេត្តបាត់ដំបង');
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => ['size' => 14, 'name' => 'Khmer OS Battambang'],
                    'alignment' => ['horizontal' => 'left'],
                ]);
        
                // 4. Left-aligned "មន្ទីរពេទ្យបង្អែកខេត្តបាត់ដំបង"
                $sheet->mergeCells('A5:P5');
                $sheet->setCellValue('A5', 'មន្ទីរពេទ្យបង្អែកខេត្តបាត់ដំបង');
                $sheet->getStyle('A5')->applyFromArray([
                    'font' => ['size' => 14, 'name' => 'Khmer OS Battambang'],
                    'alignment' => ['horizontal' => 'left'],
                ]);
        
                // 5. Centered title: "បញ្ជីរាយនាមផ្នែក.....បំរើការក្នុងមន្ទីរពេទ្យបង្អែកខេត្តបាត់ដំបង"
                $sheet->mergeCells('A7:P7');
                $sheet->setCellValue('A7', 'បញ្ជីរាយនាមនុងមន្ទីរពេទ្យបង្អែកខេត្តបាត់ដំបង');
                $sheet->getStyle('A7')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'name' => 'Khmer OS Battambang'],
                    'alignment' => ['horizontal' => 'center'],
                ]);
    
                // Footer starts after the last row of data
                $footerStartRow = $this->rowNumber + $this->headerRowCount + 4;
        
                // Footer with dynamic gender count
                $totalCount = $this->maleCount + $this->femaleCount;
                $footerText = "(ប្រុស " . $this->maleCount . " នាក់ , ស្រី " . $this->femaleCount . " នាក់ (សរុប " . $totalCount . " នាក់))";
                $sheet->mergeCells('A' . ($footerStartRow) . ':P' . ($footerStartRow));
                $sheet->setCellValue('A' . $footerStartRow, $footerText);
                $sheet->getStyle('A' . $footerStartRow)->applyFromArray([
                    'alignment' => ['horizontal' => 'left'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('F' . ($footerStartRow + 1) . ':P' . ($footerStartRow + 1));
                $sheet->setCellValue('F' . ($footerStartRow + 1), 'ថ្ងៃ      ខែ       ឆ្នាំ  ព.ស. ២៥៦៦');
                $sheet->getStyle('F' . ($footerStartRow + 1))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('F' . ($footerStartRow + 2) . ':P' . ($footerStartRow + 2));
                $sheet->setCellValue('F' . ($footerStartRow + 2), 'ថ្ងៃ      ខែ       ឆ្នាំ  គ.ស. ២០២៣');
                $sheet->getStyle('F' . ($footerStartRow + 2))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('F' . ($footerStartRow + 3) . ':P' . ($footerStartRow + 3));
                $sheet->setCellValue('F' . ($footerStartRow + 3), 'អ្នកធ្វើតារាង');
                $sheet->getStyle('F' . ($footerStartRow + 3))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('A' . ($footerStartRow + 5) . ':P' . ($footerStartRow + 5));
                $sheet->setCellValue('A' . ($footerStartRow + 5), 'បានឃើញ និងឯកភាព');
                $sheet->getStyle('A' . ($footerStartRow + 5))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('A' . ($footerStartRow + 6) . ':P' . ($footerStartRow + 6));
                $sheet->setCellValue('A' . ($footerStartRow + 6), 'ថ្ងៃ     ខែ     ឆ្នាំ   ខាល ចត្វាស័ក ព.ស ២៥៦៦');
                $sheet->getStyle('A' . ($footerStartRow + 6))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('A' . ($footerStartRow + 7) . ':P' . ($footerStartRow + 7));
                $sheet->setCellValue('A' . ($footerStartRow + 7), 'បាត់ដំបង, ថ្ងៃ     ខែ     ឆ្នាំ   គ.ស ២០២៣');
                $sheet->getStyle('A' . ($footerStartRow + 7))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
    
                $sheet->mergeCells('A' . ($footerStartRow + 8) . ':P' . ($footerStartRow + 8));
                $sheet->setCellValue('A' . ($footerStartRow + 8), 'ប្រធានមន្ទីរពេទ្យបង្អែកខេត្ត');
                $sheet->getStyle('A' . ($footerStartRow + 8))->applyFromArray([
                    'alignment' => ['horizontal' => 'center'],
                    'font' => ['name' => 'Khmer OS Battambang'],
                ]);
            },
        ];
    }
    
    
    
}