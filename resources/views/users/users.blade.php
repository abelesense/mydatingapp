<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">Browse Users</h1>

    <!-- Добавляем кнопку для перехода в режим рулетки -->
    <div class="roulette-container">
        <a href="/roulette" class="btn roulette-btn">Go to Roulette Mode</a>
    </div>

    <div class="users-grid">
        @foreach ($users as $user)
            <a href="/profile/{{ $user->id }}" class="user-card"> <!-- Ссылка на профиль пользователя -->
                <img src="{{ $user->image }}" alt="Profile Photo" class="user-photo">
                <div class="user-info">
                    <h2>{{ $user->username }}, {{ $user->age }}</h2>
                    <p>{{ $user->location }}</p>
                    <p class="user-bio">{{ $user->bio }}</p>
                    <a href="#" class="btn like-btn">Like</a>
                </div>
            </a>
        @endforeach
    </div>
</div>
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        width: 100%;
        max-width: 1000px;
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    /* Стиль для контейнера с кнопкой рулетки */
    .roulette-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .user-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
        max-width: 220px;
        text-decoration: none;
        color: inherit;
    }

    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
    }

    .user-photo {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .user-info {
        text-align: center;
    }

    .user-info h2 {
        font-size: 18px;
        margin-bottom: 5px;
        color: #333;
    }

    .user-info p {
        font-size: 15px;
        color: #666;
    }

    .user-bio {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
        max-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .like-btn {
        background-color: #4d79ff;
        color: white;
        padding: 8px 12px;
        font-size: 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        margin-top: 15px;
    }

    .like-btn:hover {
        background-color: #668cff;
    }

    /* Стиль для кнопки рулетки */
    .roulette-btn {
        background-color: #ff6347;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .roulette-btn:hover {
        background-color: #ff8367;
    }
</style>


