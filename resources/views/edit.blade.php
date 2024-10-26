<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="profile-page">
        <h1 class="page-title">My Profile</h1>

        <?php if (session('success')): ?>
        <div class="alert alert-success">
                <?php echo session('success'); ?>
        </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-header">
                <img src="<?php echo $user->image ?>" alt="My Photo" class="profile-photo">
                <button class="btn edit-photo-btn">Change Photo</button>
            </div>
            <div class="profile-body">
                <form action="<?php echo route('profile.update'); ?>" method="POST" id="edit-profile-form">
                    <?php echo csrf_field(); ?>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo $user->username ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" value="<?php echo $user->age ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio:</label>
                        <textarea id="bio" name="bio" rows="4" required><?php echo $user->bio ?></textarea>
                    </div>
                    <button type="submit" class="btn save-profile-btn">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="settings-section">
            <h3>Settings</h3>
            <button class="btn logout-btn">Log Out</button>
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
        width: 50%;
        max-width: 400px;
    }

    .profile-page {
        text-align: left;
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
        transform: translateX(10px);
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

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="number"], textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .save-profile-btn {
        background-color: #4d79ff;
        color: white;
        padding: 10px 15px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: inline-block;
    }

    .save-profile-btn:hover {
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
</style>
