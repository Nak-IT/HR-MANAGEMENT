<?php

namespace App\Policies;

use App\Models\PersonalInfoEmp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonalInfoEmpPolicy
{
    use HandlesAuthorization;

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចមើលបុគ្គលិកណាមួយបានឬទេ។
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin']);
    }

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចមើលព័ត៌មានលម្អិតរបស់បុគ្គលិកជាក់លាក់មួយបានឬទេ។
     */
    public function view(User $user, PersonalInfoEmp $employee)
    {
        return in_array($user->role, ['admin', 'manager', 'member']);
    }

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចទទួលបានបុគ្គលិកតាម ID បានឬទេ។
     */
    public function getEmployeeById(User $user, PersonalInfoEmp $employee)
    {
        return in_array($user->role, ['admin', 'manager', 'member']);
    }

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចបង្កើតបុគ្គលិកបានឬទេ។
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចធ្វើបច្ចុប្បន្នភាពបុគ្គលិកបានឬទេ។
     */
    public function update(User $user, PersonalInfoEmp $employee)
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    /**
     * កំណត់ថាតើអ្នកប្រើប្រាស់អាចលុបបុគ្គលិកបានឬទេ។
     */
    public function delete(User $user, PersonalInfoEmp $employee)
    {
        return $user->role === 'admin';
    }
}
