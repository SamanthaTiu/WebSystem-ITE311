<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($role) ?> Dashboard</title>
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
            background: #6c757d;
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
        <div class="circle"><?= strtoupper(substr($name, 0, 1)) ?></div>
        <h4><?= esc($name) ?></h4>
        <p><?= esc($email) ?></p>
    </div>

    <?php if ($role === 'admin'): ?>
        <a href="<?= base_url('dashboard') ?>">📊 Admin Dashboard</a>
        <a href="#">👥 Manage Users</a>
        <a href="#">📚 Manage Courses</a>
        <a href="#">⚙️ System Settings</a>
    <?php elseif ($role === 'instructor'): ?>
        <a href="<?= base_url('dashboard') ?>">📘 Instructor Dashboard</a>
        <a href="#">🧑 My Students</a>
        <a href="#">📝 Gradebook</a>
        <a href="#">📅 Class Schedule</a>
    <?php else: ?>
        <a href="<?= base_url('dashboard') ?>">🎓 Student Dashboard</a>
        <a href="#">📖 My Courses</a>
        <a href="#">🧾 My Grades</a>
        <a href="#">💬 Announcements</a>
    <?php endif; ?>

    <a href="<?= base_url('logout') ?>">🚪 Logout</a>
</div>

<div class="main-content">
    <h2><?= ucfirst($role) ?> Dashboard</h2>

    <div class="card text-center">
        <h4>Welcome, <strong><?= esc($name) ?></strong>!</h4>
        <p>You are logged in as <strong><?= esc($role) ?></strong>.</p>

        <?php if ($role === 'admin'): ?>
            <p>Here you can manage users, courses, and system settings.</p>
        <?php elseif ($role === 'instructor'): ?>
            <p>Here you can manage your students, lessons, and grades.</p>
        <?php else: ?>
            <p>Here you can view your lessons, submit assignments, and check grades.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
