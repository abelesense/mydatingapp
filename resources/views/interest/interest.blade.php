<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Interests</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="page-title">Add Your Interests</h1>
    <form id="interests-form">
        <div class="form-group">
            <label for="interest">Select an Interest:</label>
            <select id="interest" name="interest" required>
                <option value="">--Select Interest--</option>
                <!-- Этот блок будет генерироваться автоматически с сервера на Laravel -->
                @foreach ($interests as $interest)
                    <option value="{{ $interest->id }}">{{ $interest->interest_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn add-btn">Add Interest</button>
    </form>

    <div class="interests-list">
        <h2>Your Selected Interests:</h2>
        <ul id="selected-interests"></ul>
    </div>
</div>

<script>
    document.getElementById('interests-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        const interestSelect = document.getElementById('interest');
        const selectedInterestText = interestSelect.options[interestSelect.selectedIndex].text;

        if (interestSelect.value) {
            const selectedInterestsList = document.getElementById('selected-interests');
            const li = document.createElement('li');
            li.textContent = selectedInterestText;
            selectedInterestsList.appendChild(li);

            interestSelect.value = ''; // Сбрасываем выбор
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
        align-items: flex-start;
        height: 100vh;
        padding: 20px;
    }

    .container {
        width: 100%;
        max-width: 400px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .page-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .add-btn {
        width: 100%;
        padding: 10px;
        background-color: #4d79ff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-btn:hover {
        background-color: #668cff;
    }

    .interests-list {
        margin-top: 20px;
    }

    .interests-list h2 {
        margin-bottom: 10px;
    }

    ul {
        list-style: none;
    }

    li {
        background-color: #e7f3fe;
        padding: 8px;
        margin: 5px 0;
        border-radius: 5px;
    }

</style>
