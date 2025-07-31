<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Karyawan - {{ $user->name }}</title>
</head>
<body>
    <h1>Profil Karyawan: {{ $user->name }}</h1>

    <h2>Informasi Utama</h2>
    <ul>
        <li>ID: {{ $user->id }}</li>
        <li>Username: {{ $user->username }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Role: {{ $user->role }}</li>
        <li>Departemen ID: {{ $user->department_id }}</li>
        <li>Departemen: {{ $user->department->name ?? 'N/A' }}</li>
    </ul>

    <h2>Job Detail</h2>
    @if($user->jobDetail)
        <ul>
            <li>Position: {{ $user->jobDetail->position }}</li>
            <li>Department: {{ $user->jobDetail->department }}</li>
            <li>Status Karyawan: {{ $user->jobDetail->employee_status }}</li>
        </ul>
    @else
        <p>Tidak ada data job detail</p>
    @endif

    <h2>Job Titles</h2>
    <ul>
        @foreach($user->jobTitles as $title)
            <li>{{ $title->nama_jabatan }} ({{ $title->jenis_jabatan }})</li>
        @endforeach
    </ul>

    <h2>Smartnakama Profile</h2>
    @if($user->smartnakamaProfile)
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
        <p>Tidak ada profil Smartnakama</p>
    @endif

    <h2>Personal Details</h2>
    @foreach($user->personalDetails as $p)
        <ul>
            <li>Alamat: {{ $p->address }}</li>
            <li>Kota: {{ $p->city }}</li>
            <li>Provinsi: {{ $p->state }}</li>
            <li>Kode Pos: {{ $p->postal_code }}</li>
            <li>Negara: {{ $p->country }}</li>
        </ul>
    @endforeach

    <h2>Contact Details</h2>
    @foreach($user->contactDetails as $c)
        <ul>
            <li>No. Telepon: {{ $c->phone }}</li>
            <li>Email Alternatif: {{ $c->email }}</li>
            <li>Alamat: {{ $c->address }}</li>
        </ul>
    @endforeach

    <h2>Emergency Contacts</h2>
    @foreach($user->emergencyDetails as $e)
        <ul>
            <li>Nama: {{ $e->name }}</li>
            <li>Hubungan: {{ $e->relation }}</li>
            <li>Telepon: {{ $e->phone }}</li>
        </ul>
    @endforeach

    <h2>Pendidikan</h2>
    @foreach($user->educationBackgrounds as $edu)
        <ul>
            <li>Gelar: {{ $edu->degree }}</li>
            <li>Jurusan: {{ $edu->field_of_study }}</li>
            <li>Institusi: {{ $edu->institution }}</li>
            <li>Tahun: {{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}</li>
            <li>GPA: {{ $edu->gpa }}</li>
        </ul>
    @endforeach

    <h2>Pengalaman Kerja</h2>
    @foreach($user->careerExperiences as $exp)
        <ul>
            <li>Posisi: {{ $exp->position }}</li>
            <li>Perusahaan: {{ $exp->company }}</li>
            <li>Deskripsi: {{ $exp->description }}</li>
            <li>Tanggal: {{ $exp->start_date }} - {{ $exp->end_date ?? 'Sekarang' }}</li>
        </ul>
    @endforeach

    <h2>Kompetensi</h2>
    @foreach($user->competencySpecifications as $comp)
        <ul>
            <li>Kompetensi: {{ $comp->competency }}</li>
            <li>Tingkat: {{ $comp->level }}</li>
        </ul>
    @endforeach

    <h2>Sertifikasi</h2>
    @foreach($user->certifications as $cert)
        <ul>
            <li>Nama: {{ $cert->name }}</li>
            <li>Dikeluarkan oleh: {{ $cert->issued_by }}</li>
            <li>Tanggal Terbit: {{ $cert->issue_date }}</li>
        </ul>
    @endforeach

    <h2>Termination Details</h2>
    @foreach($user->terminationDetails as $term)
        <ul>
            <li>Alasan: {{ $term->reason }}</li>
            <li>Tanggal: {{ $term->date }}</li>
            <li>Status: {{ $term->status }}</li>
        </ul>
    @endforeach
</body>
</html>
