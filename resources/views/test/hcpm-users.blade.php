<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HCPM Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-2xl font-bold mb-4">Daftar User dari HCPM</h1>

    <table class="min-w-full bg-white shadow-md rounded border border-gray-200">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="py-2 px-4 text-left">ID</th>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Username</th>
                <th class="py-2 px-4 text-left">Email</th>
                <th class="py-2 px-4 text-left">Role</th>
                <th class="py-2 px-4 text-left">Department ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-2 px-4">{{ $user->id }}</td>
                <td class="py-2 px-4">{{ $user->name }}</td>
                <td class="py-2 px-4">{{ $user->username }}</td>
                <td class="py-2 px-4">{{ $user->email }}</td>
                <td class="py-2 px-4">{{ $user->role }}</td>
                <td class="py-2 px-4">{{ $user->department_id }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">Tidak ada user ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
