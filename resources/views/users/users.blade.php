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
        max-width: 220px; /* Увеличена ширина карточки */
        text-decoration: none; /* Убираем подчеркивание для ссылок */
        color: inherit; /* Устанавливаем цвет текста на наследуемый */
    }

    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15); /* Добавляем эффект тени при наведении */
    }

    .user-photo {
        width: 100%;
        height: 120px; /* Увеличена высота фото */
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .user-info {
        text-align: center;
    }

    .user-info h2 {
        font-size: 18px; /* Увеличен размер шрифта для имени */
        margin-bottom: 5px;
        color: #333;
    }

    .user-info p {
        font-size: 15px; /* Увеличен размер шрифта для местоположения */
        color: #666;
    }

    .user-bio {
        font-size: 14px; /* Размер шрифта для био */
        color: #555; /* Цвет текста для био */
        margin-bottom: 10px; /* Отступ снизу */
        max-height: 40px; /* Ограничение по высоте */
        overflow: hidden; /* Скрытие переполнения */
        text-overflow: ellipsis; /* Эффект многоточия */
    }

    .like-btn {
        background-color: #4d79ff;
        color: white;
        padding: 8px 12px; /* Увеличены отступы кнопки */
        font-size: 15px; /* Увеличен размер шрифта */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        margin-top: 15px; /* Увеличен отступ сверху для кнопки */
    }

    .like-btn:hover {
        background-color: #668cff;
    }
</style>

