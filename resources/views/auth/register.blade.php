<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<h1>Регистрация</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/register" method="POST">
    @csrf
    <div>
        <label for="username">Name and Surname:</label>
        <input type="text" name="username"  required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirmation password:</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <div>
        <label for="age">Age:</label>
        <input type="text" name="age" required>
    </div>
    <div>
        <label for="gender">Gender:</label>
        <input type="text" name="gender" required>
    </div>
    <div>
        <label for="location">Location:</label>
        <input type="text" name="location" required>
    </div>
    <div>
        <label for="bio">Bio:</label>
        <input type="text" name="bio" required>
    </div>
    <div>
        <label for="image">Url your photo profile:</label>
        <input type="text" name="image" required>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>
</body>
</html>

