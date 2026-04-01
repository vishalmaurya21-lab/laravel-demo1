<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    {{-- ✅ Show validation errors --}}
    {{-- @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif --}}

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        Name: <input type="text" name="name" id="name">
        @error('name')
            <small style="color: brown">name is required</small>
        @enderror
        <br><br>
        
        Email: <input type="email" name="email" id="email">
        @error('email')
            <small style="color: brown">email is required</small>
        @enderror<br><br>

        Password: <input type="password" name="password" id="password">
        @error('password')
            <small style="color: brown">password is required</small>
        @enderror
        <br><br> {{-- ✅ Fixed label + input type --}}
        
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="{{ route('users.login') }}">Login</a></p>
</body>
</html>