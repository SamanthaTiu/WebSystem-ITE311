<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Course</title>
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
        .card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: auto;
            text-align: center;
        }
        .sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .section {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .section:hover {
            transform: translateY(-5px);
        }
        .section h3 {
            color: #5865daff;
            margin-bottom: 15px;
        }
        .section a {
            display: inline-block;
            padding: 10px 20px;
            background: #5865daff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .section a:hover {
            background: #4a5ac7;
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
    <a href="<?= base_url('instructor/course/courses') ?>">📚 My Courses</a>
    <a href="<?= base_url('instructor/my_students') ?>">🧑 My Students</a>
    <a href="#">📅 Class Schedule</a>
    <a href="<?= base_url('logout') ?>">🚪 Logout</a>
</div>

<div class="main-content">
    <h2>Manage Course: <?= esc($course['course_name']) ?></h2>

    <div class="sections">
        <div class="section">
            <h3>📢 Announcements</h3>
            <p>Post and manage course announcements.</p>
            <a href="<?= base_url('instructor/course/' . $course['course_id'] . '/announcements') ?>">Manage Announcements</a>
        </div>
        <div class="section">
            <h3>📝 Assignments</h3>
            <p>Create and manage assignments.</p>
            <a href="<?= base_url('instructor/course/' . $course['course_id'] . '/assignments') ?>">Manage Assignments</a>
        </div>
        <div class="section">
            <h3>📊 Grades</h3>
            <p>View and manage student grades.</p>
            <a href="<?= base_url('instructor/course/' . $course['course_id'] . '/grades') ?>">Manage Grades</a>
        </div>
        <div class="section">
            <h3>📁 Files</h3>
            <p>Upload and manage course materials.</p>
            <a href="<?= base_url('instructor/course/upload?course_id=' . $course['course_id']) ?>">Manage Files</a>
        </div>
    </div>
</div>

</body>
</html>
