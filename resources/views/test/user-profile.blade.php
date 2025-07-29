<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengguna - {{ $user->name }}</title>
</head>

<body>
    <h1>Profil Pengguna: {{ $user->name }}</h1>
    <hr>

    <h2>Informasi Dasar</h2>
    <ul>
        <li>Username: {{ $user->username }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Role: {{ $user->role }}</li>
        <li>Department ID: {{ $user->department_id }}</li>
        <li>Status: {{ $user->jobDetail->employee_status }}</li>

    </ul>

    <h2>Smartnakama Profile</h2>
    @if ($user->smartnakamaProfile)
        <ul>
            <li>NIP: {{ $user->smartnakamaProfile->nip }}</li>
            <li>Tempat Lahir: {{ $user->smartnakamaProfile->birth_place }}</li>
            <li>Tanggal Lahir: {{ $user->smartnakamaProfile->birth_date }}</li>
            <li>Jenis Kelamin: {{ $user->smartnakamaProfile->gender }}</li>
            <li>Status Pernikahan: {{ $user->smartnakamaProfile->marital_status }}</li>
            <li>Agama: {{ $user->smartnakamaProfile->religion }}</li>
            <li>Golongan Darah: {{ $user->smartnakamaProfile->blood_type }}</li>
        </ul>
    @else
        <p>Tidak ada data smartnakama profile.</p>
    @endif

    <h2>Job Detail</h2>
    @if ($user->jobDetail)
        <ul>
            <li>Posisi: {{ $user->jobDetail->position }}</li>
            <li>Departemen: {{ $user->jobDetail->department }}</li>
        </ul>
    @else
        <p>Tidak ada data job detail.</p>
    @endif

    <h2>Gaji</h2>
    @forelse($user->salaryDetails as $salary)
        <ul>
            <li>Gaji Pokok: Rp{{ number_format($salary->base_salary) }}</li>
            <li>Bonus: Rp{{ number_format($salary->bonus) }}</li>
            <li>Potongan: Rp{{ number_format($salary->deduction) }}</li>
            <li>Berlaku Sejak: {{ $salary->effective_date }}</li>
        </ul>
    @empty
        <p>Tidak ada data gaji.</p>
    @endforelse

    <h2>Termination</h2>
    @forelse($user->terminationDetails as $termination)
        <ul>
            <li>Alasan: {{ $termination->reason }}</li>
            <li>Tanggal: {{ $termination->date }}</li>
        </ul>
    @empty
        <p>Tidak ada data pemutusan kerja.</p>
    @endforelse

    <h2>Kontak</h2>
    @forelse($user->contactDetails as $contact)
        <ul>
            <li>No. Telepon: {{ $contact->phone }}</li>
            <li>Email Alternatif: {{ $contact->email }}</li>
            <li>Alamat: {{ $contact->address }}</li>
        </ul>
    @empty
        <p>Tidak ada data kontak.</p>
    @endforelse

    <h2>Kontak Darurat</h2>
    @forelse($user->emergencyDetails as $emergency)
        <ul>
            <li>Nama: {{ $emergency->name }}</li>
            <li>Hubungan: {{ $emergency->relation }}</li>
            <li>No. Telepon: {{ $emergency->phone }}</li>
        </ul>
    @empty
        <p>Tidak ada data kontak darurat.</p>
    @endforelse

    <h2>Data Pribadi</h2>
    @forelse($user->personalDetails as $personal)
        <ul>
            <li>Alamat: {{ $personal->address }}</li>
            <li>Kota: {{ $personal->city }}</li>
            <li>Provinsi: {{ $personal->state }}</li>
            <li>Kode Pos: {{ $personal->postal_code }}</li>
            <li>Negara: {{ $personal->country }}</li>
        </ul>
    @empty
        <p>Tidak ada data pribadi.</p>
    @endforelse

    <h2>Pendidikan</h2>
    @forelse($user->educationBackgrounds as $edu)
        <ul>
            <li>Gelar: {{ $edu->degree }}</li>
            <li>Bidang Studi: {{ $edu->field_of_study }}</li>
            <li>Institusi: {{ $edu->institution }}</li>
            <li>Tahun: {{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}</li>
            <li>GPA: {{ $edu->gpa }}</li>
        </ul>
    @empty
        <p>Tidak ada data pendidikan.</p>
    @endforelse

    <h2>Pengalaman Kerja</h2>
    @forelse($user->careerExperiences as $exp)
        <ul>
            <li>Posisi: {{ $exp->position }}</li>
            <li>Perusahaan: {{ $exp->company }}</li>
            <li>Deskripsi: {{ $exp->description }}</li>
            <li>Tahun: {{ $exp->start_date }} - {{ $exp->end_date ?? 'Sekarang' }}</li>
        </ul>
    @empty
        <p>Tidak ada data pengalaman kerja.</p>
    @endforelse

    <h2>Kompetensi</h2>
    @forelse($user->competencySpecifications as $skill)
        <ul>
            <li>Kompetensi: {{ $skill->competency }}</li>
            <li>Tingkat: {{ $skill->level }}</li>
        </ul>
    @empty
        <p>Tidak ada data kompetensi.</p>
    @endforelse

    <h2>Sertifikasi</h2>
    @forelse($user->certifications as $cert)
        <ul>
            <li>Nama: {{ $cert->name }}</li>
            <li>Dikeluarkan Oleh: {{ $cert->issued_by }}</li>
            <li>Tanggal Terbit: {{ $cert->issue_date }}</li>
        </ul>
    @empty
        <p>Tidak ada data sertifikasi.</p>
    @endforelse

    <hr>
    <p><a href="{{ url('/hcpm-users') }}">← Kembali ke daftar pengguna</a></p>
</body>

</html>
