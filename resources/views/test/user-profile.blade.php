<!DOCTYPE html>
<html>
<head>
    <title>Detail User</title>
    <style>
        body { font-family: sans-serif; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        h2 { margin-top: 20px; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

    <h1>User Detail</h1>

    <div class="section">
        <h2>Basic Info</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
    </div>

    <div class="section">
        <h2>Smartnakama Profile</h2>
        <pre>{{ json_encode($user->smartnakamaProfile, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Job Detail</h2>
        <pre>{{ json_encode($user->jobDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Salary Detail</h2>
        <pre>{{ json_encode($user->salaryDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Termination Detail</h2>
        <pre>{{ json_encode($user->terminationDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Contact Detail</h2>
        <pre>{{ json_encode($user->contactDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Emergency Detail</h2>
        <pre>{{ json_encode($user->emergencyDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Personal Detail</h2>
        <pre>{{ json_encode($user->personalDetail, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Education Background</h2>
        <pre>{{ json_encode($user->educationBackground, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Career Experience</h2>
        <pre>{{ json_encode($user->careerExperience, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section">
        <h2>Competency Specification</h2>
        <pre>{{ json_encode($user->competencySpecification, JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="section"
