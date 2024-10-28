<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roulette Mode</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Подключаем jQuery -->
</head>
<body>
<div class="roulette-container">
    @if ($user->id !== auth()->id()) <!-- Сравниваем ID пользователя и текущего авторизованного -->
    <div id="profile-card" class="user-card" data-user-id="{{ $user->id }}">
        <img id="profile-photo" src="{{ $user->image }}" alt="Profile Photo" class="user-photo">
        <div class="user-info">
            <h2 id="profile-name">{{ $user->username }}, {{ $user->age }}</h2>
            <p id="profile-location">{{ $user->location }}</p>
            <p id="profile-bio">{{ $user->bio }}</p>
        </div>
        <div class="actions">
            <button id="dislike-btn" class="btn dislike-btn">Dislike</button>
            <button id="like-btn" class="btn like-btn">Like</button>
        </div>
    </div>
    @else
        <!-- Можно вывести сообщение или просто скрыть блок -->
        <p id="no-self-card">No self-profile displayed.</p>
    @endif
</div>

<script>
    $(document).ready(function() {
        // Загружаем первый профиль при загрузке страницы
        loadNextProfile();

        // Обработка клика по кнопке Like
        $('#like-btn').on('click', function() {
            handleAction('like');
        });

        // Обработка клика по кнопке Dislike
        $('#dislike-btn').on('click', function() {
            handleAction('dislike');
        });

        // Функция для загрузки следующего профиля
        function loadNextProfile() {
            $.ajax({
                url: '{{ route("roulette.next") }}',
                method: 'GET',
                success: function(data) {
                    if (data.noMoreUsers) {
                        $('#profile-card').hide();
                        $('.roulette-container').append('<p>No more profiles available.</p>');
                    } else {
                        $('#profile-photo').attr('src', data.image);
                        $('#profile-name').text(data.username + ', ' + data.age);
                        $('#profile-location').text(data.location);
                        $('#profile-bio').text(data.bio);
                        $('#profile-card').attr('data-user-id', data.id);
                        $('#profile-card').show(); // Показываем карту, если она скрыта
                    }
                }
            });
        }

        // Функция для обработки лайка/дизлайка
        function handleAction(action) {
            var userId = $('#profile-card').attr('data-user-id');

            $.ajax({
                url: '{{ route("roulette.action") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    action: action
                },
                success: function(response) {
                    loadNextProfile(); // Загружаем следующий профиль после действия
                }
            });
        }
    });
</script>
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
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .roulette-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .user-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 320px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin: 0 auto;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .user-photo {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .user-info h2 {
        font-size: 22px;
        margin-bottom: 8px;
        color: #333;
    }

    .user-info p {
        font-size: 16px;
        color: #666;
        margin-bottom: 10px;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .dislike-btn, .like-btn {
        width: 45%; /* Задаём кнопкам одинаковую ширину */
        padding: 12px 0;
        border-radius: 8px;
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dislike-btn {
        background-color: #ff4d4d;
    }

    .like-btn {
        background-color: #4d79ff;
    }

    .like-btn:hover, .dislike-btn:hover {
        opacity: 0.9;
        transform: scale(1.05); /* Лёгкий эффект увеличения при наведении */
    }

    @media (max-width: 400px) {
        .user-card {
            width: 280px; /* Уменьшаем карточку на маленьких экранах */
        }

        .user-photo {
            height: 200px; /* Соответственно уменьшаем фото */
        }
    }
</style>
