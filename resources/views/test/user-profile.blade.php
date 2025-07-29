<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail | Smartnakama HR System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Employee Profile</h1>
                <p class="text-gray-600">Comprehensive employee information system</p>
            </div>
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
                <span class="font-semibold">ID: </span>{{ $user->username }}
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                <div class="flex items-center">
                    <div class="mr-6">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-blue-800 text-4xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-blue-100">{{ $user->email }}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="bg-blue-500 bg-opacity-30 px-3 py-1 rounded-full text-sm">{{ $user->role }}</span>
                            <span class="bg-blue-500 bg-opacity-30 px-3 py-1 rounded-full text-sm">{{ $user->jobDetail->position ?? 'N/A' }}</span>
                            <span class="bg-blue-500 bg-opacity-30 px-3 py-1 rounded-full text-sm">{{ $user->jobDetail->department ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto">
                    <button class="tab-button active px-6 py-4 font-medium text-sm border-b-2 border-blue-600 text-blue-600" data-tab="basic">
                        <i class="fas fa-user mr-2"></i>Basic Info
                    </button>
                    <button class="tab-button px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="employment">
                        <i class="fas fa-briefcase mr-2"></i>Employment
                    </button>
                    <button class="tab-button px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="contact">
                        <i class="fas fa-address-book mr-2"></i>Contact
                    </button>
                    <button class="tab-button px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="education">
                        <i class="fas fa-graduation-cap mr-2"></i>Education
                    </button>
                    <button class="tab-button px-6 py-4 font-medium text-sm text-gray-500 hover:text-blue-600" data-tab="skills">
                        <i class="fas fa-tools mr-2"></i>Skills
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Basic Info Tab -->
                <div class="tab-content active" id="basic-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Smartnakama Profile -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-id-card mr-2 text-blue-600"></i> Smartnakama Profile
                            </h3>
                            <div class="space-y-2">
                                @if($user->smartnakamaProfile)
                                    @foreach($user->smartnakamaProfile as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No profile data available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-circle mr-2 text-blue-600"></i> Personal Details
                            </h3>
                            <div class="space-y-2">
                                @if($user->personalDetail)
                                    @foreach($user->personalDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No personal details available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-blue-600"></i> Emergency Contact
                            </h3>
                            <div class="space-y-2">
                                @if($user->emergencyDetail)
                                    @foreach($user->emergencyDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No emergency contact available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment Tab -->
                <div class="tab-content hidden" id="employment-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Job Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-briefcase mr-2 text-blue-600"></i> Job Details
                            </h3>
                            <div class="space-y-2">
                                @if($user->jobDetail)
                                    @foreach($user->jobDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No job details available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Salary Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-blue-600"></i> Salary Details
                            </h3>
                            <div class="space-y-2">
                                @if($user->salaryDetail)
                                    @foreach($user->salaryDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">
                                                @if(str_contains($key, 'salary') || str_contains($key, 'amount'))
                                                    {{ 'Rp ' . number_format($value, 0, ',', '.') }}
                                                @else
                                                    {{ $value ?? 'N/A' }}
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No salary details available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Termination Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 col-span-1 md:col-span-2">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2 text-blue-600"></i> Termination Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($user->terminationDetail)
                                    @foreach($user->terminationDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 col-span-3">No termination details available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Tab -->
                <div class="tab-content hidden" id="contact-tab">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contact Details -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-phone-alt mr-2 text-blue-600"></i> Contact Details
                            </h3>
                            <div class="space-y-2">
                                @if($user->contactDetail)
                                    @foreach($user->contactDetail as $key => $value)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="font-medium text-gray-800">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No contact details available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-home mr-2 text-blue-600"></i> Address Information
                            </h3>
                            <div class="space-y-2">
                                @if($user->personalDetail)
                                    @php
                                        $addressFields = ['address', 'city', 'state', 'postal_code', 'country'];
                                    @endphp
                                    @foreach($addressFields as $field)
                                        <div class="flex justify-between border-b border-gray-100 pb-2">
                                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $field) }}</span>
                                            <span class="font-medium text-gray-800">{{ $user->personalDetail->$field ?? 'N/A' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No address information available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education Tab -->
                <div class="tab-content hidden" id="education-tab">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Education Background -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-graduation-cap mr-2 text-blue-600"></i> Education Background
                            </h3>
                            <div class="space-y-4">
                                @if($user->educationBackground && count($user->educationBackground) > 0)
                                    @foreach($user->educationBackground as $education)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2 bg-white rounded-r">
                                            <h4 class="font-medium text-gray-800">{{ $education->degree ?? 'N/A' }} in {{ $education->field_of_study ?? 'N/A' }}</h4>
                                            <p class="text-sm text-gray-600">{{ $education->institution ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $education->start_year ?? 'N/A' }} - {{ $education->end_year ?? 'Present' }}
                                                @if($education->gpa) | GPA: {{ $education->gpa }} @endif
                                            </p>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No education background available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Career Experience -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-building mr-2 text-blue-600"></i> Career Experience
                            </h3>
                            <div class="space-y-4">
                                @if($user->careerExperience && count($user->careerExperience) > 0)
                                    @foreach($user->careerExperience as $experience)
                                        <div class="border-l-4 border-blue-500 pl-4 py-2 bg-white rounded-r">
                                            <h4 class="font-medium text-gray-800">{{ $experience->position ?? 'N/A' }} at {{ $experience->company ?? 'N/A' }}</h4>
                                            <p class="text-sm text-gray-600">{{ $experience->description ?? 'No description' }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $experience->start_date ?? 'N/A' }} - {{ $experience->end_date ?? 'Present' }}
                                                @if($experience->duration) | {{ $experience->duration }} @endif
                                            </p>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No career experience available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Tab -->
                <div class="tab-content hidden" id="skills-tab">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Competency Specification -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-tools mr-2 text-blue-600"></i> Competencies & Skills
                            </h3>
                            <div class="space-y-4">
                                @if($user->competencySpecification)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($user->competencySpecification as $skill => $level)
                                            <div class="bg-white p-3 rounded-lg shadow-xs border border-gray-200">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-medium text-gray-800 capitalize">{{ $skill }}</span>
                                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $level }}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" 
                                                         style="width: {{ 
                                                             $level == 'Beginner' ? '25%' : 
                                                             ($level == 'Intermediate' ? '50%' : 
                                                             ($level == 'Advanced' ? '75%' : '100%')) 
                                                         }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No competency data available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center text-sm text-gray-500 mt-8">
            <p>Smartnakama HR System - Comprehensive Employee Management Solution</p>
            <p class="mt-1">Data as of {{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and content
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500');
                });
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });
                
                // Add active class to clicked button
                button.classList.add('active', 'text-blue-600', 'border-blue-600');
                button.classList.remove('text-gray-500');
                
                // Show corresponding content
                const tabId = button.getAttribute('data-tab') + '-tab';
                document.getElementById(tabId).classList.remove('hidden');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>