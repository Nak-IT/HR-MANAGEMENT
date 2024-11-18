@extends('layouts.app_A')
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@section('content')
<div class="container">
    <h1>Backup and Restore Settings</h1>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session("status") }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif

    <form action="{{ route('backup.updateSchedule') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="backup_time">Backup Time (HH:MM)</label>
            <input type="time" id="backup_time" name="backup_time" class="form-control" value="{{ $schedule->backup_time ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="restore_time">Restore Time (HH:MM)</label>
            <input type="time" id="restore_time" name="restore_time" class="form-control" value="{{ $schedule->restore_time ?? '' }}">
        </div>
        <div class="form-group">
            <label for="clean_time">Clean-up Time (HH:MM)</label>
            <input type="time" id="clean_time" name="clean_time" class="form-control" value="{{ $schedule->clean_time ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Schedule</button>
    </form>

    <hr>

</div>
@endsection
