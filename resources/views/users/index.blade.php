@extends('layouts.app')

<!-- <link href="{{ asset('css/ModalDetail2.css') }}" rel="stylesheet" asp-append-version="true" /> -->

<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">
<link rel="stylesheet" href="{{ asset('css/indexUser.css') }}">

<script type="text/javascript" src="{{asset('js/jquery-3.4.1.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="{{ asset('lib/choices.js/js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/choices.js/css/choices.min.css') }}">
@section('content')
<div class="container">
<h2 class="custom-font006 "><br>បញ្ជីUser(អ្នកចូលប្រើប្រាស់ប្រព័ន្ធ)</h2>
   

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'ជោគជ័យ',
                    text: "{{ session('success') }}", // Changed to double quotes
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'កំហុស',
                    text: "{{ session('error') }}",
                });
            });
        </script>
    @endif

    <table id="usersTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ឈ្មោះ</th>
                <th>អ៊ីមែល</th>
                <th>សិទ្ធិអ្នកប្រើប្រាស់</th>
                <th>សកម្មភាព</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <!-- Show the delete button for all users, including the logged-in user -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">លុប</button>
                        </form>

                        <!-- Show edit role button for all users -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editRoleModal{{ $user->id }}">កែប្រែសិទ្ធិអ្នកប្រើប្រាស់</button>

                        <!-- Edit Role Modal -->
                        <div class="modal fade" id="editRoleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRoleModalLabel{{ $user->id }}">កែប្រែសិទ្ធិឱ្យ User ឈ្មោះ{{ $user->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="បិទ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if(session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-group">
                                                <label for="role">ជ្រើសរើសសិទ្ធិUserអ្នកប្រើប្រាស់</label>
                                                <select name="role" id="role" class="form-control" required>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>manager</option>
                                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>member</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">ធ្វើបច្ចុប្បន្នភាពសិទ្ធិUserអ្នកប្រើប្រាស់</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ទាំងអស់"]],
            "language": {
                "search": "ស្វែងរក៖",
                "lengthMenu": "បង្ហាញ _MENU_ ធាតុ",
                "info": "បង្ហាញ _START_ ដល់ _END_ នៃ _TOTAL_ ធាតុ",
                "infoEmpty": "បង្ហាញ 0 ដល់ 0 នៃ 0 ធាតុ",
                "infoFiltered": "(ចម្រាញ់ចេញពី _MAX_ ធាតុសរុប)",
                "paginate": {
                    "first": "ដំបូង",
                    "last": "ចុងក្រោយ",
                    "next": "បន្ទាប់",
                    "previous": "មុន"
                }
            }
        });
    });
</script>
@endsection
