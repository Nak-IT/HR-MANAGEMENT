<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // បង្ហាញបញ្ជីUser(អ្នកប្រើប្រាស់)ទាំងអស់ (អាចចូលប្រើបានដោយUser(អ្នកប្រើប្រាស់)ដែលបានផ្ទៀងផ្ទាត់ទាំងអស់)
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // បង្ហាញទម្រង់សម្រាប់កែប្រែសិទ្ធិរបស់User(អ្នកប្រើប្រាស់) (អាចចូលប្រើបានតែដោយAdminប៉ុណ្ណោះ)
    public function editRole($id)
    {
        // ស្វែងរកUser(អ្នកប្រើប្រាស់)តាម ID
        $user = User::find($id);

        // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)មានឬអត់
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'រកមិនឃើញUser(អ្នកប្រើប្រាស់)។');
        }

        // ការពារAdminពីការកែប្រែសិទ្ធិរបស់ខ្លួនឯង
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'អ្នកមិនអាចកែប្រែសិទ្ធិរបស់អ្នកបានទេ។');
        }

        // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)ដែលបានចូលគឺជាAdminឬអត់
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'មានតែAdminទេដែលអាចកែប្រែសិទ្ធិUser(អ្នកប្រើប្រាស់)បាន។');
        }

        return view('users.editRole', compact('user'));
    }

    // ធ្វើបច្ចុប្បន្នភាពតួនាទីរបស់User(អ្នកប្រើប្រាស់) (មានតែAdminទេដែលអាចធ្វើបាន)
    public function updateRole(Request $request, $id)
    {
        // ផ្ទៀងផ្ទាត់ការបញ្ចូលតួនាទី
        $request->validate([
            'role' => 'required|in:admin,manager,member',
        ]);

        // ស្វែងរកUser(អ្នកប្រើប្រាស់)តាម ID
        $user = User::find($id);

        // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)មានឬអត់
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'រកមិនឃើញUser(អ្នកប្រើប្រាស់)។');
        }

        // ការពារAdminពីការកែប្រែសិទ្ធិរបស់ខ្លួនឯង
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'អ្នកមិនអាចកែប្រែសិទ្ធិរបស់អ្នកបានទេ។');
        }

        // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)ដែលបានចូលគឺជាAdminឬអត់
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'មានតែAdminទេដែលអាចកែប្រែសិទ្ធិUser(អ្នកប្រើប្រាស់)បាន។');
        }

        // ធ្វើបច្ចុប្បន្នភាពតួនាទីរបស់User(អ្នកប្រើប្រាស់)
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('users.index')->with('success', 'តួនាទីUser(អ្នកប្រើប្រាស់)ត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ។');
    }

    // វិធីសាស្ត្រផ្សេងទៀតនៃ controller (លុប, ។ល។) នៅតែដដែល
     // លុបUser(អ្នកប្រើប្រាស់) (មានតែAdminទេដែលអាចលុបបាន)
     public function destroy($id)
     {
         // ស្វែងរកUser(អ្នកប្រើប្រាស់)តាម ID
         $user = User::find($id);
 
         // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)មានឬអត់
         if (!$user) {
             return redirect()->route('users.index')->with('error', 'រកមិនឃើញUser(អ្នកប្រើប្រាស់)។');
         }
 
         // ការពារAdminដែលបានចូលពីការលុបខ្លួនឯង
         if ($user->id === Auth::id()) {
             return redirect()->route('users.index')->with('error', 'អ្នកមិនអាចលុបខ្លួនឯងបានទេ។');
         }
 
         // ពិនិត្យមើលថាតើUser(អ្នកប្រើប្រាស់)ដែលបានចូលគឺជាAdminឬអត់
         if (Auth::user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'មានតែAdminទេដែលអាចលុបUser(អ្នកប្រើប្រាស់)បាន។');
        }

        // លុបUser(អ្នកប្រើប្រាស់)
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User(អ្នកប្រើប្រាស់)ត្រូវបានលុបដោយជោគជ័យ។');
    }
}
