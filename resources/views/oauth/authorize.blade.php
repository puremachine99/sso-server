<!DOCTYPE html>
<html>
<head>
    <title>Authorize Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Authorize {{ $client->name }}</h2>
            <p class="text-gray-600 mt-2">{{ $client->name }} is requesting access to your account.</p>
        </div>

        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Requested Permissions:</h3>
            <div class="space-y-2">
                @foreach ($scopes as $scope)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-check-circle text-indigo-500 mr-3"></i>
                    <span class="text-gray-700">{{ $scope->description }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <form method="post" action="/oauth/authorize" class="mb-4">
            @csrf
            <input type="hidden" name="state" value="{{ request()->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">

            <button type="submit" 
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white py-3 px-4 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fas fa-check-circle mr-2"></i> Authorize Access
            </button>
        </form>

        <form method="post" action="/oauth/authorize">
            @csrf
            @method('DELETE')
            <input type="hidden" name="state" value="{{ request()->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            
            <button type="submit" 
                class="w-full bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white py-3 px-4 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fas fa-times-circle mr-2"></i> Deny Access
            </button>
        </form>
    </div>
</body>
</html>