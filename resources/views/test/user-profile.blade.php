<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Karyawan - {{ $user->name }} | Smartnakama HR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .progress-bar { 
            height: 8px;
            border-radius: 4px;
            background-color: #e0e0e0;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profil Karyawan</h1>
                <p class="text-gray-600">Manajemen Sumber Daya Manusia Smartnakama</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    ID: {{ $user->username }}
                </span>
                <a href="{{ url('/hcpm-users') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Main Profile Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-blue-800 text-4xl font-bold shadow-md">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-blue-100">{{ $user->email }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="bg-blue-500/30 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-user-tag mr-1"></i> {{ $user->role }}
                            </span>
                            @if($user->jobDetail)
                            <span class="bg-blue-500/30 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-briefcase mr-1"></i> {{ $user->jobDetail->position }}
                            </span>
                            <span class="bg-blue-500/30 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-building mr-1"></i> {{ $user->jobDetail->department }}
                            </span>
                            @endif
                            <span class="bg-blue-500/30 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-circle mr-1"></i> {{ $user->jobDetail->employee_status ?? 'Status Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto">
                    <button class="tab-btn active px-6 py-4 font-medium text-sm border-b-2 border-blue-600 text-blue-600" data-tab="personal">
                        <i class="fas fa-user mr-2"></i> Personal
                    </button>
                    <button class="tab-btn px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="employment">
                        <i class="fas fa-briefcase mr-2"></i> Pekerjaan
                    </button>
                    <button class="tab-btn px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="contact">
                        <i class="fas fa-address-book mr-2"></i> Kontak
                    </button>
                    <button class="tab-btn px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="education">
                        <i class="fas fa-graduation-cap mr-2"></i> Pendidikan
                    </button>
                    <button class="tab-btn px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="skills">
                        <i class="fas fa-tools mr-2"></i> Kompetensi
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Personal Tab -->
                <div class="tab-content active" id="personal-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-id-card text-blue-600 mr-2"></i> Informasi Dasar
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Username</span>
                                    <span class="font-medium">{{ $user->username }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-medium">{{ $user->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Role</span>
                                    <span class="font-medium">{{ $user->role }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Department ID</span>
                                    <span class="font-medium">{{ $user->department_id }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Smartnakama Profile -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-id-badge text-blue-600 mr-2"></i> Profil Smartnakama
                            </h3>
                            @if($user->smartnakamaProfile)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">NIP</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->nip ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tempat/Tgl Lahir</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->birth_place ?? '-' }}, {{ $user->smartnakamaProfile->birth_date ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jenis Kelamin</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->gender ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status Pernikahan</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->marital_status ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Agama</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->religion ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Golongan Darah</span>
                                    <span class="font-medium">{{ $user->smartnakamaProfile->blood_type ?? '-' }}</span>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 py-3">Tidak ada data profil Smartnakama</p>
                            @endif
                        </div>

                        <!-- Data Pribadi -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-blue-600 mr-2"></i> Data Pribadi
                            </h3>
                            @forelse($user->personalDetails as $personal)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Alamat</span>
                                    <span class="font-medium text-right">{{ $personal->address }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kota</span>
                                    <span class="font-medium">{{ $personal->city }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Provinsi</span>
                                    <span class="font-medium">{{ $personal->state }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kode Pos</span>
                                    <span class="font-medium">{{ $personal->postal_code }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Negara</span>
                                    <span class="font-medium">{{ $personal->country }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data pribadi</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Employment Tab -->
                <div class="tab-content hidden" id="employment-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Detail -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-briefcase text-blue-600 mr-2"></i> Detail Pekerjaan
                            </h3>
                            @if($user->jobDetail)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Posisi</span>
                                    <span class="font-medium">{{ $user->jobDetail->position }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Departemen</span>
                                    <span class="font-medium">{{ $user->jobDetail->department }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status Karyawan</span>
                                    <span class="font-medium">{{ $user->jobDetail->employee_status }}</span>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 py-3">Tidak ada data pekerjaan</p>
                            @endif
                        </div>

                        <!-- Salary Details -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-money-bill-wave text-blue-600 mr-2"></i> Detail Gaji
                            </h3>
                            @forelse($user->salaryDetails as $salary)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Gaji Pokok</span>
                                    <span class="font-medium">Rp{{ number_format($salary->base_salary, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bonus</span>
                                    <span class="font-medium">Rp{{ number_format($salary->bonus, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Potongan</span>
                                    <span class="font-medium">Rp{{ number_format($salary->deduction, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Berlaku Sejak</span>
                                    <span class="font-medium">{{ $salary->effective_date }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data gaji</p>
                            @endforelse
                        </div>

                        <!-- Termination Details -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 col-span-1 md:col-span-2">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-sign-out-alt text-blue-600 mr-2"></i> Detail Pemutusan
                            </h3>
                            @forelse($user->terminationDetails as $termination)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Alasan</span>
                                    <span class="font-medium">{{ $termination->reason }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal</span>
                                    <span class="font-medium">{{ $termination->date }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data pemutusan kerja</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Contact Tab -->
                <div class="tab-content hidden" id="contact-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kontak -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-phone-alt text-blue-600 mr-2"></i> Kontak
                            </h3>
                            @forelse($user->contactDetails as $contact)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Telepon</span>
                                    <span class="font-medium">{{ $contact->phone }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email Alternatif</span>
                                    <span class="font-medium">{{ $contact->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Alamat</span>
                                    <span class="font-medium">{{ $contact->address }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data kontak</p>
                            @endforelse
                        </div>

                        <!-- Kontak Darurat -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-exclamation-triangle text-blue-600 mr-2"></i> Kontak Darurat
                            </h3>
                            @forelse($user->emergencyDetails as $emergency)
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama</span>
                                    <span class="font-medium">{{ $emergency->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hubungan</span>
                                    <span class="font-medium">{{ $emergency->relation }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Telepon</span>
                                    <span class="font-medium">{{ $emergency->phone }}</span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data kontak darurat</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Education Tab -->
                <div class="tab-content hidden" id="education-tab">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Pendidikan -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-graduation-cap text-blue-600 mr-2"></i> Pendidikan
                            </h3>
                            @forelse($user->educationBackgrounds as $edu)
                            <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                                <h4 class="font-semibold text-gray-800">{{ $edu->degree }} - {{ $edu->field_of_study }}</h4>
                                <p class="text-gray-600">{{ $edu->institution }}</p>
                                <div class="flex justify-between mt-2 text-sm">
                                    <span class="text-gray-500">
                                        <i class="far fa-calendar mr-1"></i> 
                                        {{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}
                                    </span>
                                    <span class="font-medium">
                                        GPA: {{ $edu->gpa }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data pendidikan</p>
                            @endforelse
                        </div>

                        <!-- Pengalaman Kerja -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-building text-blue-600 mr-2"></i> Pengalaman Kerja
                            </h3>
                            @forelse($user->careerExperiences as $exp)
                            <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                                <h4 class="font-semibold text-gray-800">{{ $exp->position }}</h4>
                                <p class="text-gray-600">{{ $exp->company }}</p>
                                <p class="text-gray-500 text-sm mt-1">{{ $exp->description }}</p>
                                <div class="mt-2 text-sm text-gray-500">
                                    <i class="far fa-calendar mr-1"></i> 
                                    {{ $exp->start_date }} - {{ $exp->end_date ?? 'Sekarang' }}
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data pengalaman kerja</p>
                            @endforelse
                        </div>

                        <!-- Sertifikasi -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-certificate text-blue-600 mr-2"></i> Sertifikasi
                            </h3>
                            @forelse($user->certifications as $cert)
                            <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                                <h4 class="font-semibold text-gray-800">{{ $cert->name }}</h4>
                                <p class="text-gray-600">Dikeluarkan oleh: {{ $cert->issued_by }}</p>
                                <div class="mt-2 text-sm text-gray-500">
                                    <i class="far fa-calendar mr-1"></i> 
                                    {{ $cert->issue_date }}
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data sertifikasi</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Skills Tab -->
                <div class="tab-content hidden" id="skills-tab">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Kompetensi -->
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tools text-blue-600 mr-2"></i> Kompetensi
                            </h3>
                            @forelse($user->competencySpecifications as $skill)
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span class="font-medium text-gray-700 capitalize">{{ $skill->competency }}</span>
                                    <span class="text-sm font-medium text-blue-600">{{ $skill->level }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 
                                        {{ $skill->level == 'Pemula' ? '25%' : 
                                          ($skill->level == 'Menengah' ? '50%' : 
                                          ($skill->level == 'Mahir' ? '75%' : '100%')) 
                                        }}">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 py-3">Tidak ada data kompetensi</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500 mt-8">
            <p>Sistem Manajemen SDM Smartnakama - Data diperbarui pada {{ date('d F Y H:i') }}</p>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    b.classList.add('text-gray-500');
                });
                
                // Add active class to clicked button
                btn.classList.add('active', 'text-blue-600', 'border-blue-600');
                btn.classList.remove('text-gray-500');
                
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });
                
                // Show corresponding tab content
                const tabId = btn.getAttribute('data-tab') + '-tab';
                document.getElementById(tabId).classList.remove('hidden');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>