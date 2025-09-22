<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Test Playground — SmartID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Accordion affordances */
        details summary::-webkit-details-marker {
            display: none;
        }

        details[open] .chevron {
            transform: rotate(180deg);
        }

        .chevron {
            transition: transform 200ms ease;
        }

        /* Smooth open/close (optional, not all browsers) */
        details[open]>div[data-acc-body] {
            animation: accOpen 180ms ease;
        }

        @keyframes accOpen {
            from {
                opacity: .5;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Sticky table headers for long lists */
        .tbl thead th {
            position: sticky;
            top: 0;
            background: #f9fafb;
            z-index: 1;
        }

        /* Simple scrollbar for big tables */
        .scroll-soft {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .scroll-soft::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .scroll-soft::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        .scroll-soft::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="mx-auto max-w-7xl p-6 space-y-6">

        {{-- Header --}}
        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Test Playground</h1>
                <p class="text-gray-500">
                    Data Testing aja terlalu Overpower setelah Close beta di terminate semua
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                    <span class="mr-1.5 inline-block h-2 w-2 rounded-full bg-blue-500"></span>
                    HCPM: {{ $hcpmTotal }}
                </span>
                <span
                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                    <span class="mr-1.5 inline-block h-2 w-2 rounded-full bg-green-500"></span>
                    Portal: {{ $portalTotal }}
                </span>
            </div>
        </header>

        {{-- Toolbar: actions & accordion controls --}}
        <section class="flex flex-wrap items-center gap-3">
            <a href="{{ route('test.hcpm.sync') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M4 4v6h6M20 20v-6h-6" />
                    <path d="M20 4l-6 6" />
                    <path d="M4 20l6-6" />
                </svg>
                Sync HCPM → Portal
            </a>

            <a href="{{ route('test.errors') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4M12 16h.01" />
                </svg>
                Error Pages
            </a>

            <a href="{{ url('/test-imgproxy') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                Test Imgproxy
            </a>

            <a href="{{ url('/test-reset-mail?to=you@example.com&name=Tester') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M4 4h16v16H4z" />
                    <path d="m22 6-10 7L2 6" />
                </svg>
                Kirim Email Reset (dummy)
            </a>

            <div class="ml-auto flex gap-2">
                <button id="expandAll" type="button"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Expand all
                </button>
                <button id="collapseAll" type="button"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium hover:shadow-sm hover:ring-1 hover:ring-gray-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14" />
                    </svg>
                    Collapse all
                </button>
            </div>
        </section>

        {{-- SECTION: HCPM Users --}}
        <details class="rounded-xl border border-gray-200 bg-white shadow-sm" open>
            <summary
                class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-xl px-5 py-4 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">HCPM Users</span>
                    <span
                        class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">{{ count($hcpmUsers) }}
                        users</span>
                </div>
                <svg class="chevron h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </summary>

            <div data-acc-body class="px-5 pb-5">
                <div class="overflow-auto rounded-lg border border-gray-200 scroll-soft">
                    <table class="tbl min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Username</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Role</th>
                                <th class="px-4 py-3 text-left">Department</th>
                                <th class="px-4 py-3 text-left">Struktural</th>
                                <th class="px-4 py-3 text-left">Fungsional</th>
                                <th class="px-4 py-3 text-left">Created</th>
                                <th class="px-4 py-3 text-left">Updated</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($hcpmUsers as $user)
                                <tr class="odd:bg-white even:bg-gray-50/50 hover:bg-blue-50/40">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->id }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('hcpm.show', $user->id) }}"
                                            class="font-semibold text-blue-600 hover:underline">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->username }}</td>
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
                                            class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $statusColor }}">
                                            {{ $status ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->role }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->department_id }}</td>
                                    <td class="px-4 py-3 text-gray-700">
                                        @php $struktural = $user->jobTitles->where('jenis_jabatan','Struktural'); @endphp
                                        @forelse($struktural as $jabatan)
                                            <div>{{ $jabatan->nama_jabatan }}</div>
                                        @empty
                                            <div class="italic text-gray-400">—</div>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        @php $fungsional = $user->jobTitles->where('jenis_jabatan','Fungsional'); @endphp
                                        @forelse($fungsional as $jabatan)
                                            <div>{{ $jabatan->nama_jabatan }}</div>
                                        @empty
                                            <div class="italic text-gray-400">—</div>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $user->created_at?->format('Y-m-d H:i') ?? '—' }}</td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $user->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-6 text-center text-gray-500">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </details>

        {{-- SECTION: Portal Users & Roles --}}
        <details class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <summary
                class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-xl px-5 py-4 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">Portal Users & Roles (Spatie)</span>
                    <span
                        class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">{{ count($portalUsers) }}
                        users</span>
                </div>
                <svg class="chevron h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </summary>

            <div data-acc-body class="px-5 pb-5">
                <div class="overflow-auto rounded-lg border border-gray-200 scroll-soft">
                    <table class="tbl min-w-full border-collapse text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">HCPM Status</th>
                                <th class="px-4 py-3 text-left">Acc Type</th>
                                <th class="px-4 py-3 text-left">Roles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($portalUsers as $i => $user)
                                <tr class="odd:bg-white even:bg-gray-50/50 hover:bg-emerald-50/40">
                                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->hcpm_status }}</td>
                                    <td class="px-4 py-3">{{ $user->source }}</td>
                                    <td class="px-4 py-3">
                                        @if ($user->roles->isEmpty())
                                            <em class="text-gray-400">Tidak ada</em>
                                        @else
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($user->roles as $role)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-800">{{ $role->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </details>

        {{-- SECTION: Error Playground --}}
        <details class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <summary
                class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-xl px-5 py-4 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4M12 16h.01" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">Error Pages Playground</span>
                </div>
                <svg class="chevron h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </summary>

            <div data-acc-body class="px-5 pb-5">
                <div class="flex flex-wrap gap-2">
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.404') }}">Trigger 404</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.403') }}">Trigger 403</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.401') }}">Trigger 401</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.419') }}">Trigger 419</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.429') }}">Trigger 429</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.500') }}">Trigger 500</a>
                    <a class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50" target="_blank"
                        href="{{ route('test.error.503') }}">Trigger 503</a>
                </div>

                <form class="mt-5" action="{{ route('test.error.422') }}" method="post">
                    {{-- tanpa csrf & tanpa email, biar 422 --}}
                    <button type="submit"
                        class="rounded-lg border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50">
                        POST tanpa email (422)
                    </button>
                </form>
            </div>
        </details>

        {{-- SECTION: Email Tester --}}
        <details class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <summary
                class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-xl px-5 py-4 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 4h16v16H4z" />
                            <path d="m22 6-10 7L2 6" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">Email Tester</span>
                </div>
                <svg class="chevron h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </summary>

            <div data-acc-body class="px-5 pb-5">
                <p class="mb-3 text-sm text-gray-600">Kirim email uji reset password.</p>

                <form action="{{ url('/test-reset-mail') }}" method="get" class="flex flex-wrap items-end gap-3">
                    <label class="block">
                        <span class="mb-1 block text-xs text-gray-500">Kirim ke</span>
                        <input id="to" name="to" type="email" placeholder="you@example.com"
                            class="w-64 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                    </label>

                    <label class="block">
                        <span class="mb-1 block text-xs text-gray-500">Nama</span>
                        <input id="name" name="name" type="text" placeholder="Tester"
                            class="w-48 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </label>

                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium hover:bg-gray-50">
                        Kirim
                    </button>
                </form>

                {{-- Preview kecil --}}
                <div class="mt-6 overflow-hidden rounded-lg border border-gray-200">
                    <div class="bg-[#0056D2] px-4 py-3 font-semibold text-white">{{ $appName }}</div>
                    <div class="p-4">
                        <p>Halo,</p>
                        <p class="mt-2">{{ $bodyMessage }}</p>
                        <a href="{{ config('app.url') }}"
                            class="mt-3 inline-block rounded-md bg-[#0056D2] px-3 py-2 text-sm font-medium text-white">Kunjungi
                            Portal</a>
                    </div>
                    <div class="bg-gray-100 px-4 py-2 text-xs text-gray-500">&copy; {{ date('Y') }}
                        {{ $appName }}</div>
                </div>
            </div>
        </details>

        {{-- SECTION: Utilities --}}
        <details class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <summary
                class="flex cursor-pointer select-none items-center justify-between gap-3 rounded-xl px-5 py-4 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2v4M2 12h4M12 18v4M18 12h4" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold">Utilities</span>
                </div>
                <svg class="chevron h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </summary>

            <div data-acc-body class="px-5 pb-5 space-y-4">
                {{-- Set Super Admin --}}
                <form action="{{ route('portal.set-su', ['email' => '__EMAIL__']) }}" method="get"
                    onsubmit="this.action = this.action.replace('__EMAIL__', encodeURIComponent(this.email.value));"
                    class="space-y-1">
                    <label class="block text-sm">Set Super Admin by Email</label>
                    <div class="flex flex-wrap items-center gap-2">
                        <input name="email" type="email"
                            class="w-80 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            placeholder="user@domain.com" required>
                        <button
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium hover:bg-gray-50">
                            Set
                        </button>
                    </div>
                </form>

                {{-- Reset Password --}}
                <form action="{{ route('portal.reset', ['email' => '__EMAIL__']) }}" method="get"
                    onsubmit="this.action = this.action.replace('__EMAIL__', encodeURIComponent(this.email.value));"
                    class="space-y-1">
                    <label class="block text-sm">Reset Password ke 12345678</label>
                    <div class="flex flex-wrap items-center gap-2">
                        <input name="email" type="email"
                            class="w-80 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            placeholder="user@domain.com" required>
                        <button
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium hover:bg-gray-50">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </details>
    </div>

    <script>
        // Expand / Collapse all helper
        const expandAllBtn = document.getElementById('expandAll');
        const collapseAllBtn = document.getElementById('collapseAll');

        expandAllBtn?.addEventListener('click', () => {
            document.querySelectorAll('details').forEach(d => d.open = true);
        });
        collapseAllBtn?.addEventListener('click', () => {
            document.querySelectorAll('details').forEach(d => d.open = false);
        });
    </script>
</body>

</html>
