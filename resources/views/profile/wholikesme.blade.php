<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Likes Me</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">Who Likes Me</h1>

    <div class="likes-list">
        @forelse ($likes as $like)
            <div class="like-card">
                <img src="{{ $like->user->image }}" alt="{{ $like->user->username }}'s Photo" class="like-photo">
                <h2 class="like-username">{{ $like->user->username }}</h2>
                <p class="like-bio">{{ $like->user->bio }}</p>
            </div>
        @empty
            <p>No one likes you yet.</p>
        @endforelse
    </div>

    <a href="/edit-profile" class="btn back-btn">Back to Profile</a>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        padding: 20px;
    }

    .container {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .likes-list {
        margin-top: 20px;
    }

    .like-card {
        display: flex;
        align-items: center;
        padding: 10px;
        margin: 10px 0;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .like-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .like-username {
        font-size: 20px;
        margin: 0;
    }

    .like-bio {
        color: #777;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #4d79ff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .back-btn:hover {
        background-color: #668cff;
    }
</style>
