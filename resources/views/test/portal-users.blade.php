<!DOCTYPE html>
<html>

<head>
    <title>Portal Users & Roles</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .badge {
            background: #e3e3e3;
            border-radius: 4px;
            padding: 3px 7px;
            margin-right: 4px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">User Portal & Role dari Spatie</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Acc Type</th>
                <th>Roles</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->hcpm_status }}</td>
                    <td>{{ $user->source }}</td>
                    <td>
                        @if ($user->roles->isEmpty())
                            <em style="color:#999;">Tidak ada</em>
                        @else
                            @foreach ($user->roles as $role)
                                <span class="badge">{{ $role->name }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada user ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
