@extends('admin.layout')

@section('title', 'Users')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Users</h1>
        <p class="text-slate-500">Manage registered users and their accounts</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
        <div class="p-6">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-slate-500 text-sm border-b border-slate-100">
                        <th class="pb-4 font-medium">ID</th>
                        <th class="pb-4 font-medium">Name</th>
                        <th class="pb-4 font-medium">Email</th>
                        <th class="pb-4 font-medium">Role</th>
                        <th class="pb-4 font-medium">Orders</th>
                        <th class="pb-4 font-medium">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="table-row border-b border-slate-50 last:border-0">
                            <td class="py-4 font-medium text-slate-800">{{ $user->id }}</td>
                            <td class="py-4 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="py-4">
                                @if($user->is_admin)
                                    <span class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-3 py-1 rounded-full text-sm font-medium">Admin</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-sm font-medium">User</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">{{ $user->orders->count() }}</span>
                            </td>
                            <td class="py-4 text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
@endsection
