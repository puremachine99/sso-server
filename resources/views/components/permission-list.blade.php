@props(['scopes'])

<div class="mb-6">
    <h3 class="text-sm font-medium text-gray-600 mb-3">Requested Permissions:</h3>
    <div class="space-y-3">
        @foreach ($scopes as $scope)
            <div class="flex items-center p-3 rounded-xl permission-item">
                <i class="fas fa-check-circle text-blue-500 mr-3"></i>
                <span class="text-gray-700 text-sm">{{ $scope->description }}</span>
            </div>
        @endforeach
    </div>
</div>
