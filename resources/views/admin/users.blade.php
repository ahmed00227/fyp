@extends('admin_layout')

@section('body')
    <div class="container mt-4">
        <h1 class="mb-4 " style="font-weight: bold;font-size: 2rem">Users of MediFast</h1>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ ucwords($user->name) }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('H:i d/m/y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }} <!-- Laravel pagination -->
    </div>
@endsection

