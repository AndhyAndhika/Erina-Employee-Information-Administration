@extends('layouts.app', ['title' => 'Dashboard'])
@section('content')
<div class="row mb-3">
    <p class="fw-bold h3">Employee</p>
</div>
<div class="row">
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header fw-bold font-monospace fs-5"><i class="fa-solid fa-clipboard-list"></i>
                List of Employee
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-primary float-end" onclick="addNewEmployee()"><i class="fa-solid fa-plus"></i> New Employee</button>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="Table_Employee" class="table table-striped-columns table-hover table-bordered nowrap display  w-100" style="overflow-x: scroll">
                                <thead class="table-info">
                                    <tr>
                                        <th class="text-center">MP CODE</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">POSITION</th>
                                        <th class="text-center">EMAIL</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Modal Employee --}}
<x-modal id="modal_employee">
    <x-slot name="title">New Employee</x-slot>
    <x-slot name="body">
        <form id="Form_employee" action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
            @csrf
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="name" class="form-label">Name<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth<sup class="text-danger">*</sup></label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="gender" class="form-label">Gender<sup class="text-danger">*</sup></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki - Laki</option>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="email" class="form-label">Email<sup class="text-danger">*</sup></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="position" class="form-label">Position<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="position" name="position" placeholder="Position" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="section" class="form-label">Section<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="section" name="section" placeholder="Section" required>
                </div>

                <div class="col-6 mb-3">
                    <label for="phone_number" class="form-label">Phone Number<sup class="text-danger">*</sup></label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" pattern="[0-9]{12}" placeholder="0851xxxxxxxx" required>
                    <div class="form-text">Please enter your phone number in the format 0851xxxxxxxx.</div>
                </div>
                <div class="col-6 mb-3">
                    <label for="join_date" class="form-label">Join Date<sup class="text-danger">*</sup></label>
                    <input type="date" class="form-control" id="join_date" name="join_date" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="address" class="form-label">Address<sup class="text-danger">*</sup></label>
                    <textarea class="form-control" id="address" name="address" placeholder="Address" required></textarea>
                </div>
            </div>
            <div class="row">
                <div id="formTambahan4"></div>
                <div id="formTambahan5"></div>
                <div class="col">
                    <button type="submit" class="btn btn-primary float-end"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                </div>
            </div>
        </form>
    </x-slot>
</x-modal>

    {{-- Modal Change Password --}}
<x-modal id="modal_changePassword">
    <x-slot name="title">Change Password</x-slot>
    <x-slot name="body">
        <form id="Form_changePassword" action="{{ route('employee.change_password') }}" method="POST" enctype="multipart/form-data" onsubmit="validatePassword()">
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

    {{-- Modal Delete Data --}}
<x-modal id="modal_deleteData">
    <x-slot name="title">Delete Data</x-slot>
    <x-slot name="body">
        <form id="Form_deleteData" action="{{ route('employee.destroy') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-exclamation-triangle"></i> Are you sure you want to delete this data?
                    </div>
                </div>
            <div class="row">
                <div id="formTambahan2"></div>
                <div id="formTambahan3"></div>
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
        /* scirpt for add account */
        const addNewEmployee = () => {
            $('#modal_employee').modal('show');
            $("#modal_employeeLabel").html("New Employee");
            $("#Form_employee").attr("action", "{{ route('employee.store') }}");
            $("#name, #date_of_birth, #gender, #email, #position, #section, #phone_number, #join_date, #address, #formTambahan4, #formTambahan5").val("");
        }

        /* script for edited account */
        const editEmployee = (id, empum, name) => {
            $('#modal_employee').modal('show');
            $("#modal_employeeLabel").html(`Edit Manpower : ${name}`);
            $("#Form_employee").attr("action", "{{ route('employee.update') }}");
            $("#name, #date_of_birth, #gender, #email, #position, #section, #phone_number, #join_date, #address").val("Loading...");

            $.ajax({
                dataType: "json",
                url: "{{ route('employee.show') }}"+`?id=${id}&empum=${empum}`,
                success: function (res) {
                    $("#name").val(res.data.name);
                    $("#date_of_birth").val(res.data.user_details.date_of_birth);
                    $("#gender").val(res.data.user_details.gender);
                    $("#email").val(res.data.email);
                    $("#position").val(res.data.user_details.position);
                    $("#section").val(res.data.user_details.section);
                    $("#phone_number").val(res.data.user_details.phone_number);
                    $("#join_date").val(res.data.user_details.join_date);
                    $("#address").val(res.data.user_details.address);
                    $("#formTambahan4").html(`<input type="hidden" name="id" value="${id}" required>`);
                    $("#formTambahan5").html(`<input type="hidden" name="empum" value="${empum}" required>`);
                },
                error: function(err) {
                    toastr.error(err)
                },
            });
        }

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

        /* Script for delete account */
        const deleteEmployee = (id, empum, name) => {
            $('#modal_deleteData').modal('show');
            $("#modal_deleteDataLabel").html(`Delete Data : ${name}`);
            $("#formTambahan2").html(`<input type="hidden" name="empum" value="${empum}" required>`);
            $("#formTambahan3").html(`<input type="hidden" name="id" value="${id}" required>`);
        }

        /* Datatables Employee */
        var Table_Employee = $('#Table_Employee').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee.index') }}",
            columns: [
                { data: 'employee_number', name: 'employee_number' },
                { data: 'name', name: 'name' },
                { data: 'position', name: 'position' },
                { data: 'email', name: 'email' },
                { data: 'getStatus', name: 'getStatus' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "columnDefs": [{ className: "text-center", "targets": [0, 4, 5] }, { className: "text-uppercase", "targets": [4] }]
        });
    </script>


    {{-- <script>
        /* add new manpower */
        const addNewManpower = () => {
            $('#modal_manpower').modal('show');
            $("#modal_manpowerLabel").html("New Manpower");
            $("#Form_Manpower").attr("action", "{{ route('manpower.store') }}");
            $("#nomor_pegawai, #name, #position, #email").val("");
            $("#formTambahan").html("");
        }

        /* Edit data manpower */
        const editManpower = (id, name) => {
            $('#modal_manpower').modal('show');
            $("#modal_manpowerLabel").html(`Edit Manpower : ${name}`);
            $("#Form_Manpower").attr("action", "{{ route('manpower.update') }}");
            $("#nomor_pegawai, #name, #position, #email").val("Loading...");
            $.ajax({
                dataType: "json",
                url: "{{ url('/manpower/data/find') }}"+`/${id}`,
                success: function (res) {
                    $("#nomor_pegawai").val(res.data.nomor_pegawai);
                    $("#name").val(res.data.name);
                    $("#position").val(res.data.role);
                    $("#email").val(res.data.email);
                    $("#formTambahan").html(`<input type="hidden" name="id" value="${res.data.id}" required>`);
                },
                error: function(err) {
                    toastr.error(err)
                },
            });
        }

        /* Change Password */
        const changePassword = (id, name) => {
            $('#modal_changePassword').modal('show');
            $("#modal_changePasswordLabel").html(`Change Password For : ${name}`);
            $("#formTambahan1").html(`<input type="hidden" name="id" value="${id}" required>`);
        }

        const validatePassword = () => {
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            if (password != confirm_password) {
                event.preventDefault();
                toastr.error('Password is not match please check again.!', 'Password not match!')
                $("#password, #confirm_password").val("");
            }else{
                DisabledButtomSubmit();
            }
        }

        /* Delete Data */
        const deleteData = (id, name) => {
            $('#modal_deleteData').modal('show');
            $("#modal_deleteDataLabel").html(`Delete Data : ${name}`);
            $("#formTambahan2").html(`<input type="hidden" name="id" value="${id}" required>`);
        }

        /* Datatables Manpower */
        var Table_Manpower = $('#Table_Manpower').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manpower.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nomor_pegawai', name: 'nomor_pegawai' },
                { data: 'name', name: 'name' },
                { data: 'role', name: 'role' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "columnDefs": [{ className: "text-center", "targets": [0, 5] }, { className: "text-uppercase", "targets": [3] }]
        });
    </script> --}}
@endpush
