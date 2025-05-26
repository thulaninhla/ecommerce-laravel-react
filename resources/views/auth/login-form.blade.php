<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
        @error('email')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" name="password" required
               class="w-full px-3 py-2 mt-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
        @error('password')
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center mb-4">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-sm text-gray-700">Remember me</label>
    </div>

    <div class="flex items-center justify-between">
        <button type="submit"
                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            Login
        </button>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
        @endif
    </div>
</form>
