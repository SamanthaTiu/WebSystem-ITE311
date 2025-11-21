<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Announcements</title>
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
            background: #007bff;
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
            background: #007bff;
            color: #fff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .main-content h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-weight: bold;
            font-size: 42px;
        }
        .card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="profile">
        <div class="circle"><?= strtoupper(substr($name ?? 'S', 0, 1)) ?></div>
        <h4><?= esc($name ?? 'Student') ?></h4>
        <p><?= esc($email ?? 'student@example.com') ?></p>
    </div>
    <a href="<?= base_url('dashboard') ?>">🎓 Student Dashboard</a>
    <a href="<?= base_url('my-courses') ?>">📖 My Subjects</a>
    <a href="<?= base_url('my-grades') ?>">🧾 My Grades</a>
    <a href="<?= base_url('announcements') ?>">📢 Announcements</a>
    <a href="<?= base_url('logout') ?>">🚪 Logout</a>
</div>

<div class="main-content">
    <h2>Student Announcements</h2>

    <div class="card">
        <h4>Welcome, <?= esc(session()->get('name')) ?>!</h4>
        <p>Check back here for important announcements.</p>
    </div>
</div>

</body>
</html>