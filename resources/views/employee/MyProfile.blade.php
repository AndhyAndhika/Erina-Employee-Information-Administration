@extends('layouts.app', ['title' => 'Dashboard'])
@section('content')
<div class="row mb-3">
    <p class="fw-bold h3">My Profile</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        {{-- <button type="button" class="btn btn-primary float-end" onclick="updateDataProfile()"><i class="fa-solid fa-save"></i> Update</button> --}}
                        <button type="button" class="btn btn-warning float-end" onclick="changePassword('{{Crypt::encrypt($dataUser->id)}}', '{{Crypt::encrypt($dataUser->employee_number)}}', '{{$dataUser->name}}')"><i class="fa-solid fa-key"></i> Change Password</button>
                    </div>
                    <div class="col-12">
                        <form id="Form_employee" action="{{ route('employee.updateFromProfile') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="employee_number" class="form-label fw-bold text-capitalize">Employee Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="employee_number" name="employee_number" value="{{$dataUser->employee_number}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold text-capitalize">Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="name" name="name" value="{{$dataUser->name}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold text-capitalize">Email <sup class="text-danger">*</sup></label>
                                        <input type="email" class="form-control-plaintext" id="email" name="email" value="{{$dataUser->email}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="position" class="form-label fw-bold text-capitalize">Position <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="position" name="position" value="{{ $dataUser->userDetails->position}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="section" class="form-label fw-bold text-capitalize">Section <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="section" name="section" value="{{ $dataUser->userDetails->section}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label fw-bold text-capitalize">gender <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="gender" name="gender" value="{{ $dataUser->userDetails->gender}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label fw-bold text-capitalize">phone <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="phone_number" name="phone_number" value="{{ $dataUser->userDetails->phone_number}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold text-capitalize">address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="address" name="address" value="{{ $dataUser->userDetails->address}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="date_of_birth" class="form-label fw-bold text-capitalize">date of birth <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="date_of_birth" name="date_of_birth" value="{{ $dataUser->userDetails->date_of_birth}}" disabled readonly required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="join_date" class="form-label fw-bold text-capitalize">join date <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control-plaintext" id="join_date" name="join_date" value="{{ $dataUser->userDetails->join_date}}" disabled readonly required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Modal Change Password --}}
    <x-modal id="modal_changePassword">
        <x-slot name="title">Change Password</x-slot>
        <x-slot name="body">
            <form id="Form_changePassword" action="{{ route('employee.updateFromProfile') }}" method="POST" enctype="multipart/form-data" onsubmit="validatePassword()">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="password" class="form-label">New Password<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="confirm password" required>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-exclamation-triangle"></i> Password must be at least 8 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="formTambahan"></div>
                    <div id="formTambahan1"></div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary float-end"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>

@endsection
@push('js')
<script>
        /* Sript For ChangePassword */
        const changePassword = (id, empum, name) => {
            $('#modal_changePassword').modal('show');
            $("#modal_changePasswordLabel").html(`Change Password For : ${name}`);
            $("#formTambahan").html(`<input type="hidden" name="empum" value="${empum}" required>`);
            $("#formTambahan1").html(`<input type="hidden" name="id" value="${id}" required>`);
        }

        const validatePassword = () => {
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/;

            if (password != confirm_password) {
                event.preventDefault();
                toastr.error('Password is not match please check again.!', 'Password not match!')
                $("#password, #confirm_password").val("");
            } else if (!password.match(passwordRegex)) {
                event.preventDefault();
                toastr.error('Password must be at least 8 characters long, contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.', 'Invalid Password!')
                $("#password, #confirm_password").val("");
            } else {
                DisabledButtomSubmit();
            }
        }


</script>
@endpush
