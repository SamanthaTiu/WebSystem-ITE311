<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Materials - <?= esc($course['course_name'] ?? 'Course') ?></title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fb;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: #343a40;
            color: #fff;
            padding-top: 30px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }
        .sidebar .profile {
            text-align: center;
            padding: 20px;
        }
        .sidebar .profile .circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #5865daff;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
        }
        .sidebar .profile h4 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .sidebar .profile p {
            font-size: 14px;
            color: #bbb;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #ddd;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #5865daff;
            color: #fff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .main-content h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #5865daff;
            font-weight: bold;
            font-size: 42px;
        }
        .upload-form {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
        .upload-form label {
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
        .upload-form input[type="file"] {
            margin-bottom: 20px;
        }
        .upload-form button {
            background: #5865daff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .upload-form button:hover {
            background: #4a5ac7;
        }
        .message {
            margin: 15px 0;
            padding: 12px;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            text-align: center;
        }
        .message.success {
            background-color: #28a745;
        }
        .message.error {
            background-color: #dc3545;
        }
        .materials-list {
            margin-top: 40px;
        }
        .materials-list h3 {
            color: #5865daff;
            margin-bottom: 15px;
        }
        .materials-list ul {
            list-style-type: none;
            padding-left: 0;
        }
        .materials-list li {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .materials-list li a {
            color: #5865daff;
            text-decoration: none;
            font-weight: 600;
        }
        .materials-list li .actions {
            display: flex;
            gap: 10px;
        }
        .materials-list li .delete-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .materials-list li .delete-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="profile">
        <div class="circle"><?= strtoupper(substr(session()->get('name'), 0, 1)) ?></div>
        <h4><?= esc(session()->get('name')) ?></h4>
        <p><?= esc(session()->get('email')) ?></p>
    </div>
    <a href="<?= base_url('instructor/dashboard') ?>">📘 Dashboard</a>
    <a href="<?= base_url('instructor/courses') ?>">📚 My Courses</a>
    <a href="<?= base_url('instructor/my_students') ?>">🧑 My Students</a>
    <a href="<?= base_url('logout') ?>">🚪 Logout</a>
</div>

<div class="main-content">
    <h2>Upload Materials for <?= esc($course['course_name'] ?? '') ?></h2>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="message success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="message error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/instructor/course/upload') ?>" method="post" enctype="multipart/form-data" class="upload-form">
        <input type="hidden" name="course_id" value="<?= esc($course['course_id'] ?? '') ?>" />
        <label for="material_file">Choose file to upload (PDF, PPT, DOC, JPG, PNG):</label>
        <input type="file" name="material_file" id="material_file" required>
        <button type="submit">Upload Material</button>
    </form>

    <div class="materials-list">
        <h3>Uploaded Materials</h3>
        <?php if (!empty($materials) && is_array($materials)): ?>
            <ul>
                <?php foreach ($materials as $material): ?>
                    <li>
                        <a href="<?= base_url('materials/download/' . esc($material['id'])) ?>" target="_blank"><?= esc($material['file_name']) ?></a>
                        <div class="actions">
                            <form action="<?= base_url('materials/delete/' . esc($material['id'])) ?>" method="post" style="display: inline;">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this material?')">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No materials uploaded yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
