<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-green-200">
        @error('name')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-green-200">
        @error('email')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" name="password" required
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-green-200">
        @error('password')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-green-200">
    </div>

    <button type="submit"
            class="w-full px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
        Register
    </button>
</form>
