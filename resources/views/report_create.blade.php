<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Submit a Report</h1>

    <form action="{{ route('report.store') }}" method="POST" class="report-form">
        @csrf
        <div class="form-group">
            <label for="reported_user_id">Reported User ID</label>
            <input type="number" name="reported_user_id" id="reported_user_id" required>
        </div>

        <div class="form-group">
            <label for="reason">Reason</label>
            <select name="reason" id="reason" required>
                <option value="">Select a reason</option>
                <option value="Spam">Spam</option>
                <option value="Harassment">Harassment</option>
                <option value="Inappropriate Content">Inappropriate Content</option>
                <!-- Добавьте другие причины по необходимости -->
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Provide additional details"></textarea>
        </div>

        <button type="submit" class="btn submit-btn">Submit Report</button>
    </form>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 80%;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
    }

    .submit-btn {
        background-color: #4d79ff;
        color: white;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #668cff;
    }
</style>
