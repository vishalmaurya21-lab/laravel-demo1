<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    {{-- ✅ Show error messages --}}
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    {{-- ✅ Fixed: action now points to login route --}}
    <form action="{{ route('users.login.post') }}" method="POST">
        @csrf
        Email: <input type="email" name="email" id="email">
        @error('email')
            <small style="color: brown">email is required</small>
        @enderror
        <br><br>
        Password: <input type="password" name="password" id="password">
        @error('password')
            <small style="color: brown">password is required</small>
        @enderror<br><br> {{-- ✅ Fixed label + input type --}}
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="{{ route('users.create') }}">Register</a></p>
</body>
</html>