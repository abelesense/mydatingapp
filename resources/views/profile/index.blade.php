<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="profile-page">
        <h1 class="page-title">My Profile</h1>

        <div class="profile-card">
            <div class="profile-header">
                <img src="{{ $user->image }}" alt="My Photo" class="profile-photo">
                <button class="btn edit-photo-btn">Change Photo</button>
            </div>
            <div class="profile-body">
                <h2 class="user-name">{{ $user->username }}, {{ $user->age }}</h2>
                <p class="user-bio">{{ $user->bio }}</p>
                <a href="/edit-profile" class="btn edit-profile-btn" style="margin-top: 20px;">Edit Profile</a>
                <a href="/add-interests" class="btn add-interests-btn" style="margin-top: 10px;">Add Interests</a>
            </div>
        </div>

        <div class="interests-section">
            <h3>My Interests</h3>
            <ul class="interests-list">
                @forelse ($interests as $interest)
                    <li>{{ $interest->interest_name }}</li>
                @empty
                    <li>You haven't added any interests yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="settings-section">
            <h3>Settings</h3>
            <a href="/logout" class="btn logout-btn">Log Out</a>
        </div>
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
        justify-content: flex-start;
        align-items: flex-start;
        height: 100vh;
        padding: 20px;
    }

    .container {
        width: 50%; /* Устанавливаем ширину в 50%, чтобы разместить верстку в левой половине экрана */
        max-width: 400px;
    }

    .profile-page {
        text-align: left; /* Текст выравнивается по левому краю */
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateX(10px); /* Легкий эффект сдвига при наведении */
    }

    .profile-header {
        position: relative;
    }

    .profile-photo {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .edit-photo-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .profile-body {
        padding: 15px;
    }

    .user-name {
        font-size: 22px;
        margin-bottom: 10px;
        color: #333;
    }

    .user-bio {
        font-size: 16px;
        color: #777;
    }

    .edit-profile-btn {
        background-color: #4d79ff;
        color: white;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: inline-block; /* Чтобы отобразить margin */
    }

    .edit-profile-btn:hover {
        background-color: #668cff;
    }

    .settings-section {
        margin-top: 20px;
        padding: 15px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .settings-section h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .logout-btn {
        background-color: #ff4d4d;
        color: white;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #ff6666;
    }

    .add-interests-btn {
        background-color: #66b3ff; /* Цвет фона для кнопки */
        color: white; /* Цвет текста */
        padding: 10px 15px; /* Отступы */
        font-size: 16px; /* Размер шрифта */
        border: none; /* Убираем рамку */
        border-radius: 5px; /* Закругленные углы */
        cursor: pointer; /* Указатель при наведении */
        transition: background-color 0.3s ease; /* Плавный переход при наведении */
        margin-top: 10px; /* Отступ сверху для кнопки */
    }

    .add-interests-btn:hover {
        background-color: #80bfff; /* Цвет при наведении */
    }
</style>
