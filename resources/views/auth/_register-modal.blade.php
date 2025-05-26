<form method="POST" action="{{ route('custom.register') }}">
    @csrf
    <h2 class="mb-4 text-xl font-bold">Register</h2>

    @if($errors->any())
        <div class="mb-2 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded" required value="{{ old('email') }}">
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="w-full p-2 border rounded" required>
    </div>

    <div class="mb-4">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
    </div>

    <button type="submit" class="w-full py-2 text-white bg-green-600 rounded hover:bg-green-700">Register</button>
</form>
