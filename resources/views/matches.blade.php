<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>My Matches</h1>

    <div class="matches-grid">
        @forelse ($matches as $match)
            <div class="match-card">
                <img src="{{ $match->image }}" alt="Profile Photo" class="match-photo">
                <div class="match-info">
                    <h2>{{ $match->username }}, {{ $match->age }}</h2>
                    <p>{{ $match->location }}</p>
                    <p class="match-bio">{{ $match->bio }}</p>
                </div>
                <a href="{{ route('chat', ['user' => $match->id]) }}" class="btn message-btn">Message</a>

            </div>
        @empty
            <p>You have no matches yet. Start liking profiles to find matches!</p>
        @endforelse
    </div>
</div>
</body>
</html>

<style>

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .matches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .match-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        padding: 15px;
        transition: transform 0.3s ease;
    }

    .match-photo {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .match-info h2 {
        font-size: 18px;
        margin-bottom: 5px;
        color: #333;
    }

    .match-info p {
        font-size: 14px;
        color: #666;
    }

    .message-btn {
        display: inline-block;
        margin-top: 15px;
        background-color: #4d79ff;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .message-btn:hover {
        background-color: #668cff;
    }
</style>

