<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Helpers\SendMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /* handle routing name "employee.index" and parsing view */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('position', function ($data) {
                    $position = $data->userDetails->position;
                    return $position;
                })
                ->addColumn('getStatus', function ($data) {
                    $getStatus = $data->getBadgeStatus();
                    return $getStatus;
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn fa-solid fa-pen-to-square fa-lg text-warning" onclick="editEmployee(\'' . Crypt::encrypt($data->id) . '\',\'' . Crypt::encrypt($data->employee_number) . '\',\'' . $data->name . '\')"></a> | <a class="btn fa-solid fa-key fa-lg text-primary" onclick="changePassword(\'' . Crypt::encrypt($data->id) . '\',\'' . Crypt::encrypt($data->employee_number) . '\',\'' . $data->name . '\')"></a> | <a class="btn fa-solid fa-trash fa-lg text-danger" onclick="deleteEmployee(\'' . Crypt::encrypt($data->id) . '\',\'' . Crypt::encrypt($data->employee_number) . '\',\'' . $data->name . '\')"></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'getStatus'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('employee.index');
    }

    /* for show data user by ID */
    public function show(Request $request)
    {
        $request_id = $request->query('id') ?? null;
        $request_empum = $request->query('empum') ?? null;

        $id = Crypt::decrypt($request_id);
        $employee_number = Crypt::decrypt($request_empum);
        $user = User::with('userDetails')->where('id', $id)->latest()->first();

        if (!$user || $user->employee_number != $employee_number) {
            return ApiFormatter::createApi(400, 'Data not found, Please review and correct your input.');
        }

        return ApiFormatter::createApi(200, 'Data found', $user);
    }

    /* for handle create user */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:P,L',
            'email' => 'required|email|max:255|unique:users,email',
            'position' => 'required|string|min:2|max:255',
            'section' => 'required|string|min:2|max:255',
            'phone_number' => 'required|string|size:12|regex:/^[0-9]+$/',
            'join_date' => 'required|date',
            'address' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            Alert::toast('Validation Unsuccessful, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        /* Auto generate password */
        $password = $this->generateRandomPassword(12);

        $user = User::create([
            'employee_number' => User::generateEmployeeNumber(),
            'name' => $request->name,
            'role' => "staff",
            'email' => $request->email,
            'password' => Hash::make($password),
            'created_by' => auth()->user()->name,
            'is_active' => 1,
        ]);

        if ($user) {
            $user->userDetails()->create([
                'position' => $request->position,
                'section' => $request->section,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'join_date' => $request->join_date,
                'created_by' => auth()->user()->name,
            ]);
        }

        /* Send To Whatsapp */
        SendMessage::WAtoPerson($request->phone_number, "Semaget Pagi., \n\nberikut password anda: *$password*  \n\nsilahkan login dan segera ganti password anda. \n \nTerimakasih, \nERINA - Employeee Information & Administration");

        Alert::toast('Employee successfully created.', 'success')->autoClose(3000);
        return redirect()->route('employee.index');
    }

    /* for handle update user */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'empum' => 'required|string',
            'name' => 'required|string|min:2|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:P,L',
            'email' => [ 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Crypt::decrypt($request->id)),],
            'position' => 'required|string|min:2|max:255',
            'section' => 'required|string|min:2|max:255',
            'phone_number' => 'required|string|size:12|regex:/^[0-9]+$/',
            'join_date' => 'required|date',
            'address' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            Alert::toast('Validation Unsuccessful, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $id = Crypt::decrypt($request->id);
        $employee_number = Crypt::decrypt($request->empum);
        $user = User::find($id);

        if (!$user || $user->employee_number != $employee_number) {
            Alert::toast('Data not found, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $updateUser = $user->update([
            'name' => $request->name,
            'role' => "staff",
            'email' => $request->email,
            'updated_by' => auth()->user()->name,
        ]);

        if ($updateUser) {
            $user->userDetails()->update([
                'position' => $request->position,
                'section' => $request->section,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'join_date' => $request->join_date,
                'updated_by' => auth()->user()->name,
            ]);
        }
        Alert::toast('Employee successfully Edited.', 'success')->autoClose(3000);
        return redirect()->route('employee.index');

    }

    /* For handle post from modal change password */
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "empum" => 'required|string',
            "id" => 'required|string',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/'],
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            Alert::toast('Validation Unsuccessful, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $id = Crypt::decrypt($request->id);
        $employee_number = Crypt::decrypt($request->empum);
        $user = User::find($id);

        if (!$user || $user->employee_number != $employee_number) {
            Alert::toast('Data not found, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $update = $user->update([
            'updated_by' => auth()->user()->name,
            'password' => Hash::make($request->password),
        ]);

        if ($update) {
            Alert::toast('Employee password edited.', 'success')->autoClose(3000);
        } else {
            Alert::toast('Failed to edit Employee. Please try again.', 'error')->autoClose(3000);
        }

        return redirect()->route('employee.index');
    }

    /* for handle request destroy */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "empum" => 'required|string',
            "id" => 'required|string',
        ]);

        if ($validator->fails()) {
            Alert::toast('Validation Unsuccessful, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $id = Crypt::decrypt($request->id);
        $employee_number = Crypt::decrypt($request->empum);
        $user = User::find($id);

        if (!$user || $user->employee_number != $employee_number) {
            Alert::toast('Data not found, Please review and correct your input.', 'error')->autoClose(3000);
            return redirect()->route('employee.index');
        }

        $inputUpdateAt = $user->update([
            'updated_by' => auth()->user()->name,
        ]);

        $inputUpdateAt = $user->userDetails->update([
            'updated_by' => auth()->user()->name,
        ]);

        $deletea = $user->userDetails->delete();
        $delete = $user->delete();

        if ($delete) {
            Alert::toast('Employee successfully deleted.', 'success')->autoClose(3000);
        } else {
            Alert::toast('Failed to delete Employee. Please try again.', 'error')->autoClose(3000);
        }

        return redirect()->route('employee.index');
    }

    /* function for generate password */
    private function generateRandomPassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;';
        $password = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $max)];
        }

        // Ensure the password meets the validation criteria
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/', $password)) {
            return $this->generateRandomPassword($length); // Recursively generate a new password if it doesn't meet criteria
        }

        return $password;
    }

    /* =============================[ ' My Profile Starred ' ]======================== */

    /* function for page MyProfile */
    public function MyProfile($id)
    {
        $HasilDecrypt = Crypt::decrypt($id);
        $dataUser = User::find($HasilDecrypt);
        return view('employee.MyProfile', compact('dataUser'));
    }

    /* for update data from MyProfile */
    public function updateFromProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "empum" => 'required|string',
            "id" => 'required|string',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/'],
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            Alert::toast('Validation Unsuccessful, Please review and correct your input.', 'error')->autoClose(3000);
            return back();
        }

        $id = Crypt::decrypt($request->id);
        $employee_number = Crypt::decrypt($request->empum);
        $user = User::find($id);

        if (!$user || $user->employee_number != $employee_number) {
            Alert::toast('Data not found, Please review and correct your input.', 'error')->autoClose(3000);
            return back();
        }

        $update = $user->update([
            'updated_by' => auth()->user()->name,
            'password' => Hash::make($request->password),
        ]);

        if ($update) {
            Alert::toast('Employee password edited.', 'success')->autoClose(3000);
        } else {
            Alert::toast('Failed to edit Employee. Please try again.', 'error')->autoClose(3000);
        }

        return back();
    }
}
