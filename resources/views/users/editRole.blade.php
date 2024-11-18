@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Role for {{ $user->name }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="role">Select Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>
@endsection
