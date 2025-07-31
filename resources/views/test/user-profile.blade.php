<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Karyawan - {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #00cec9;
            --dark: #2d3436;
            --light: #f5f6fa;
            --gray: #636e72;
            --success: #00b894;
            --warning: #fdcb6e;
            --danger: #d63031;
            --glass: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: var(--light);
            min-height: 100vh;
            padding: 2rem;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .avatar::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.3),
                rgba(255, 255, 255, 0)
            );
            transform: rotate(30deg);
        }
        
        .profile-info h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .profile-info p {
            color: var(--gray);
            margin-bottom: 0.5rem;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        
        .badge-primary {
            background: var(--primary);
            color: white;
        }
        
        .badge-secondary {
            background: var(--secondary);
            color: var(--dark);
        }
        
        .badge-dark {
            background: var(--dark);
            color: white;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .card-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary);
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 206, 201, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
        }
        
        .info-item {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 500;
            color: var(--secondary);
            min-width: 120px;
        }
        
        .info-value {
            flex: 1;
            color: var(--light);
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray);
            font-style: italic;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--secondary);
            border: 2px solid var(--primary);
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--secondary);
            margin-bottom: 0.25rem;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .timeline-description {
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .skill-meter {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .skill-level {
            height: 100%;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 4px;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="avatar">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->jobDetail->position ?? 'Position not specified' }}</p>
                <div>
                    <span class="badge badge-primary">{{ $user->department->name ?? 'N/A' }}</span>
                    <span class="badge badge-secondary">{{ $user->role }}</span>
                    <span class="badge badge-dark">ID: {{ $user->id }}</span>
                </div>
            </div>
        </div>
        
        <!-- Main Grid -->
        <div class="grid">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informasi Utama</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-label">Username</span>
                    <span class="info-value">{{ $user->username }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Departemen</span>
                    <span class="info-value">{{ $user->department->name ?? 'N/A' }}</span>
                </div>
            </div>
            
            <!-- Job Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informasi Pekerjaan</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                </div>
                @if($user->jobDetail)
                    <div class="info-item">
                        <span class="info-label">Posisi</span>
                        <span class="info-value">{{ $user->jobDetail->position }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">{{ $user->jobDetail->employee_status }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Departemen</span>
                        <span class="info-value">{{ $user->jobDetail->department }}</span>
                    </div>
                @else
                    <div class="empty-state">Tidak ada data job detail</div>
                @endif
                
                @if($user->jobTitles->count() > 0)
                    <div class="info-item" style="margin-top: 1rem;">
                        <span class="info-label">Jabatan</span>
                        <span class="info-value">
                            @foreach($user->jobTitles as $title)
                                <div>{{ $title->nama_jabatan }} ({{ $title->jenis_jabatan }})</div>
                            @endforeach
                        </span>
                    </div>
                @endif
            </div>
            
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informasi Pribadi</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                </div>
                @if($user->smartnakamaProfile)
                    <div class="info-item">
                        <span class="info-label">NIP</span>
                        <span class="info-value">{{ $user->smartnakamaProfile->nip }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">TTL</span>
                        <span class="info-value">{{ $user->smartnakamaProfile->birth_place }}, {{ $user->smartnakamaProfile->birth_date }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $user->smartnakamaProfile->gender }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">{{ $user->smartnakamaProfile->marital_status }}</span>
                    </div>
                @else
                    <div class="empty-state">Tidak ada profil Smartnakama</div>
                @endif
            </div>
        </div>
        
        <!-- Second Row -->
        <div class="grid">
            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Kontak</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                </div>
                @foreach($user->personalDetails as $p)
                    <div class="info-item">
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $p->address }}, {{ $p->city }}, {{ $p->state }} {{ $p->postal_code }}, {{ $p->country }}</span>
                    </div>
                @endforeach
                
                @foreach($user->contactDetails as $c)
                    <div class="info-item">
                        <span class="info-label">Telepon</span>
                        <span class="info-value">{{ $c->phone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Alt</span>
                        <span class="info-value">{{ $c->email }}</span>
                    </div>
                @endforeach
                
                @foreach($user->emergencyDetails as $e)
                    <div class="info-item" style="margin-top: 1rem;">
                        <span class="info-label">Darurat</span>
                        <span class="info-value">{{ $e->name }} ({{ $e->relation }}) - {{ $e->phone }}</span>
                    </div>
                @endforeach
            </div>
            
            <!-- Education -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Pendidikan</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                </div>
                @if($user->educationBackgrounds->count() > 0)
                    <div class="timeline">
                        @foreach($user->educationBackgrounds as $edu)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}</div>
                                <h3 class="timeline-title">{{ $edu->degree }} - {{ $edu->field_of_study }}</h3>
                                <p class="timeline-description">{{ $edu->institution }}</p>
                                <p class="timeline-description">GPA: {{ $edu->gpa }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">Tidak ada data pendidikan</div>
                @endif
            </div>
            
            <!-- Experience -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Pengalaman Kerja</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"></path>
                        </svg>
                    </div>
                </div>
                @if($user->careerExperiences->count() > 0)
                    <div class="timeline">
                        @foreach($user->careerExperiences as $exp)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ $exp->start_date }} - {{ $exp->end_date ?? 'Sekarang' }}</div>
                                <h3 class="timeline-title">{{ $exp->position }} di {{ $exp->company }}</h3>
                                <p class="timeline-description">{{ $exp->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">Tidak ada data pengalaman kerja</div>
                @endif
            </div>
        </div>
        
        <!-- Third Row -->
        <div class="grid">
            <!-- Skills -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Kompetensi</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                </div>
                @if($user->competencySpecifications->count() > 0)
                    @foreach($user->competencySpecifications as $comp)
                        <div class="info-item">
                            <span class="info-label">{{ $comp->competency }}</span>
                            <span class="info-value">
                                <div class="skill-meter">
                                    <div class="skill-level" style="width: {{ $comp->level * 20 }}%"></div>
                                </div>
                            </span>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">Tidak ada data kompetensi</div>
                @endif
            </div>
            
            <!-- Certifications -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Sertifikasi</h2>
                    <div class="card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="7"></circle>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                        </svg>
                    </div>
                </div>
                @if($user->certifications->count() > 0)
                    <div class="timeline">
                        @foreach($user->certifications as $cert)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ $cert->issue_date }}</div>
                                <h3 class="timeline-title">{{ $cert->name }}</h3>
                                <p class="timeline-description">Dikeluarkan oleh: {{ $cert->issued_by }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">Tidak ada data sertifikasi</div>
                @endif
            </div>
            
            <!-- Termination -->
            @if($user->terminationDetails->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Terminasi</h2>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                    </div>
                    @foreach($user->terminationDetails as $term)
                        <div class="info-item">
                            <span class="info-label">Tanggal</span>
                            <span class="info-value">{{ $term->date }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Alasan</span>
                            <span class="info-value">{{ $term->reason }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">{{ $term->status }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>