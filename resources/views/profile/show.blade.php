<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->username }}'s Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">{{ $user->username }}'s Profile</h1>

    <div class="profile-card">
        <img src="{{ $user->image }}" alt="Profile Photo" class="profile-photo">
        <div class="profile-info">
            <h2>{{ $user->username }}, {{ $user->age }}</h2>
            <p>Location: {{ $user->location }}</p>
            <p>Bio: {{ $user->bio }}</p>
        </div>
    </div>

    <a href="/users" class="btn back-btn">Back to Users</a>
</div>
</body>
</html>

<style>
    /* Стили для профиля */
    .container {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        text-align: center;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .profile-photo {
        width: 100%;
        height: auto;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .back-btn {
        background-color: #4d79ff;
        color: white;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .back-btn:hover {
        background-color: #668cff;
    }
</style>
1
