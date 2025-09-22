<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Test Playground — SmartID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Tailwind CDN biar cepat --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card {
            @apply bg-white rounded-xl border border-gray-200 shadow-sm;
        }

        .card-header {
            @apply flex items-center justify-between px-5 py-4 border-b;
        }

        .card-body {
            @apply p-5;
        }

        details>summary {
            list-style: none;
        }

        details>summary::-webkit-details-marker {
            display: none;
        }

        .summary {
            @apply cursor-pointer select-none px-5 py-4 flex items-center justify-between;
        }

        .badge {
            @apply inline-block rounded-full text-xs font-semibold px-2.5 py-1;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        {{-- Header + counts --}}
        <header class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Test Playground</h1>
                <p class="text-gray-500">Semua alat uji di satu halaman</p>
            </div>
            <div class="flex gap-3">
                <span class="badge bg-blue-100 text-blue-800">HCPM: {{ $hcpmTotal }}</span>
                <span class="badge bg-green-100 text-green-800">Portal: {{ $portalTotal }}</span>
            </div>
        </header>



        {{-- SECTION: HCPM Users (table lengkap kamu sebelumnya) --}}
        <details open class="card">
            <summary class="summary">
                <span class="font-semibold">HCPM Users</span>
                <span class="text-sm text-gray-500">{{ count($hcpmUsers) }} users</span>
            </summary>
            <div class="card-body overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Struktural</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fungsional</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($hcpmUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium">{{ $user->id }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('hcpm.show', $user->id) }}"
                                        class="text-sm font-semibold text-blue-600 hover:underline">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->username }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $status = $user->jobDetail?->employee_status ?? null;
                                        $statusColor =
                                            $status === 'Active'
                                                ? 'bg-green-100 text-green-800'
                                                : ($status
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : 'bg-gray-100 text-gray-800');
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ $status ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->role }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $user->department_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @php $struktural = $user->jobTitles->where('jenis_jabatan','Struktural'); @endphp
                                    @forelse($struktural as $jabatan)
                                        <div class="mb-1">{{ $jabatan->nama_jabatan }}</div>
                                    @empty
                                        <div class="text-gray-400 italic">—</div>
                                    @endforelse
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @php $fungsional = $user->jobTitles->where('jenis_jabatan','Fungsional'); @endphp
                                    @forelse($fungsional as $jabatan)
                                        <div class="mb-1">{{ $jabatan->nama_jabatan }}</div>
                                    @empty
                                        <div class="text-gray-400 italic">—</div>
                                    @endforelse
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $user->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $user->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-6 text-center text-sm text-gray-500">No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>

        {{-- SECTION: Portal Users & Roles --}}
        <details class="card">
            <summary class="summary">
                <span class="font-semibold">Portal Users & Roles (Spatie)</span>
                <span class="text-sm text-gray-500">{{ count($portalUsers) }} users</span>
            </summary>
            <div class="card-body overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">HCPM Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acc Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($portalUsers as $i => $user)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-sm">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $user->hcpm_status }}</td>
                                <td class="px-4 py-3 text-sm">{{ $user->source }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($user->roles->isEmpty())
                                        <em class="text-gray-400">Tidak ada</em>
                                    @else
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-gray-100 text-gray-800">{{ $role->name }}</span>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>

        {{-- SECTION: Error Playground (inline, biar gak perlu pindah halaman) --}}
        <details class="card">
            <summary class="summary"><span class="font-semibold">Error Pages Playground</span></summary>
            <div class="card-body">
                <div class="flex flex-wrap gap-3">
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.404') }}">Trigger 404</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.403') }}">Trigger 403</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.401') }}">Trigger 401</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.419') }}">Trigger 419</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.429') }}">Trigger 429</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.500') }}">Trigger 500</a>
                    <a class="px-3 py-2 rounded border hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.503') }}">Trigger 503</a>
                </div>

                <form class="mt-5" action="{{ route('test.error.422') }}" method="post">
                    {{-- tanpa csrf & tanpa email, biar 422 --}}
                    <button type="submit" class="px-3 py-2 rounded border hover:bg-gray-50">
                        POST tanpa email (422)
                    </button>
                </form>
            </div>
        </details>

        {{-- SECTION: Email Tester (inline) --}}
        <details class="card">
            <summary class="summary"><span class="font-semibold">Email Tester</span></summary>
            <div class="card-body">
                <p class="text-sm text-gray-600 mb-3">Kirim email uji reset password.</p>
                <form action="{{ url('/test-reset-mail') }}" method="get" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="to">Kirim ke</label>
                        <input id="to" name="to" type="email" placeholder="you@example.com"
                            class="border rounded px-3 py-2 w-64" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1" for="name">Nama</label>
                        <input id="name" name="name" type="text" placeholder="Tester"
                            class="border rounded px-3 py-2 w-48">
                    </div>
                    <button class="px-3 py-2 rounded border hover:bg-gray-50" type="submit">Kirim</button>
                </form>

                {{-- Preview template sederhana (static) --}}
                <div class="mt-6 border rounded overflow-hidden">
                    <div class="bg-[#0056D2] text-white px-4 py-3 font-semibold">{{ $appName }}</div>
                    <div class="p-4">
                        <p>Halo,</p>
                        <p class="mt-2">{{ $bodyMessage }}</p>
                        <a href="{{ config('app.url') }}"
                            class="inline-block mt-3 px-3 py-2 rounded bg-[#0056D2] text-white">Kunjungi Portal</a>
                    </div>
                    <div class="bg-gray-100 px-4 py-2 text-xs text-gray-500">&copy; {{ date('Y') }}
                        {{ $appName }}</div>
                </div>
            </div>
        </details>

        {{-- SECTION: Utilities kecil --}}
        <details class="card">
            <summary class="summary"><span class="font-semibold">Utilities</span></summary>
            <div class="card-body space-y-4">
                {{-- Set Super Admin --}}
                <form action="{{ route('portal.set-su', ['email' => '__EMAIL__']) }}" method="get"
                    onsubmit="this.action = this.action.replace('__EMAIL__', encodeURIComponent(this.email.value));">
                    <label class="block text-sm mb-1">Set Super Admin by Email</label>
                    <div class="flex gap-2">
                        <input name="email" type="email" class="border rounded px-3 py-2 w-80"
                            placeholder="user@domain.com" required>
                        <button class="px-3 py-2 rounded border hover:bg-gray-50">Set</button>
                    </div>
                </form>

                {{-- Reset Password --}}
                <form action="{{ route('portal.reset', ['email' => '__EMAIL__']) }}" method="get"
                    onsubmit="this.action = this.action.replace('__EMAIL__', encodeURIComponent(this.email.value));">
                    <label class="block text-sm mb-1">Reset Password ke 12345678</label>
                    <div class="flex gap-2">
                        <input name="email" type="email" class="border rounded px-3 py-2 w-80"
                            placeholder="user@domain.com" required>
                        <button class="px-3 py-2 rounded border hover:bg-gray-50">Reset</button>
                    </div>
                </form>

            </div>
        </details>

    </div>
</body>

</html>
