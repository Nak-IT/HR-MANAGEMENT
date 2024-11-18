<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class PersonalInfoEmpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'EmployeeID' => $this->EmployeeID,
            'Emp_as_khmerID' => $this->Emp_as_khmerID,
            'FirstName' => $this->FirstName,
            'LastName' => $this->LastName,
            'LatinName' => $this->LatinName,
            'Gender' => $this->Gender,
            'DateOfBirth' => $this->DateOfBirth,
            'Nationality' => $this->Nationality,
            'Phone' => $this->Phone,
            'Photo' => $this->Photo,
            'BirthVillage' => $this->BirthVillage,
            'BirthCommuneWard' => $this->BirthCommuneWard,
            'BirthDistrict' => $this->BirthDistrict,
            'BirthProvinceID' => $this->BirthProvinceID,
            'HouseNumber' => $this->HouseNumber,
            'GroupNumber' => $this->GroupNumber,
            'AddressVillage' => $this->AddressVillage,
            'AddressCommuneWard' => $this->AddressCommuneWard,
            'AddressDistrict' => $this->AddressDistrict,
            'AddressProvinceID' => $this->AddressProvinceID,
            'BirthProvinceName' => $this->birthProvince->ProvinceName ?? null,
            'AddressProvinceName' => $this->addressProvince->ProvinceName ?? null,
            'canUpdate' => Gate::allows('update', $this),
            'canDelete' => Gate::allows('delete', $this),
        ];
    }
}
