<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $otherUser->username }}</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="chat-container">
    <h2>Chat with {{ $otherUser->username }}</h2>

    <div class="chat-messages">
        @foreach ($messages as $message)
            <div class="{{ $message->sender_id == auth()->id() ? 'message-sent' : 'message-received' }}">
                <p>{{ $message->message }}</p>
                <span>{{ $message->created_at->format('H:i') }}</span>
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.send', $otherUser->id) }}" method="POST">
        @csrf
        <input name="message" placeholder="Type a message..." required></input> <!-- name="message" -->
        <button type="submit" class="btn send-btn">Send</button>
    </form>
</div>
</body>
</html>
<style>
    /* Стили для страницы чата */
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .chat-container {
        width: 400px;
        max-width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        box-sizing: border-box;
    }

    h2 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }

    .chat-messages {
        height: 300px;
        overflow-y: auto;
        margin-bottom: 15px;
        padding-right: 5px;
        border-bottom: 1px solid #ddd;
    }

    .chat-messages::-webkit-scrollbar {
        width: 5px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 5px;
    }

    .message-sent, .message-received {
        margin: 10px 0;
        padding: 8px 12px;
        border-radius: 10px;
        max-width: 70%;
        font-size: 14px;
        position: relative;
        clear: both;
    }

    .message-sent {
        background-color: #4d79ff;
        color: white;
        align-self: flex-end;
        margin-left: auto;
        text-align: right;
    }

    .message-received {
        background-color: #e5e5ea;
        color: #333;
        align-self: flex-start;
    }

    .message-sent span, .message-received span {
        display: block;
        font-size: 12px;
        color: #777;
        margin-top: 5px;
    }

    form {
        display: flex;
        align-items: center;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 20px;
        resize: none;
        font-size: 14px;
        margin-right: 10px;
    }

    .send-btn {
        background-color: #4d79ff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .send-btn:hover {
        background-color: #668cff;
    }

</style>
