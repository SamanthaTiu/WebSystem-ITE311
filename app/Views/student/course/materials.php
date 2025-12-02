<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Materials - <?= esc($course['course_name'] ?? 'Course') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
        .course-info {
            background: white;
            max-width: 800px;
            margin: 0 auto 30px;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
        .course-info h3 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .course-info p {
            color: #6c757d;
            margin-bottom: 10px;
        }
        .materials-list {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
        .materials-list h3 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .materials-list ul {
            list-style-type: none;
            padding-left: 0;
        }
        .materials-list li {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .materials-list li a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        .materials-list li a:hover {
            text-decoration: underline;
        }
        .materials-list li .download-btn {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .materials-list li .download-btn:hover {
            background: #218838;
        }
        .empty-state {
            color: #6c757d;
            font-style: italic;
            text-align: center;
            padding: 50px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
            .main-content h2 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="profile">
        <div class="circle"><?= strtoupper(substr(session()->get('name'), 0, 1)) ?></div>
        <h4><?= esc(session()->get('name')) ?></h4>
        <p><?= esc(session()->get('email')) ?></p>
    </div>
    <a href="<?= base_url('dashboard') ?>">🎓 Student Dashboard</a>
    <a href="<?= base_url('my-courses') ?>">📖 My Subjects</a>
    <a href="<?= base_url('my-grades') ?>">🧾 My Grades</a>
    <a href="<?= base_url('announcements') ?>">📢 Announcements</a>
    <a href="<?= base_url('logout') ?>">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2>Course Materials</h2>

    <div class="course-info">
        <h3><?= esc($course['course_name'] ?? 'Course') ?></h3>
        <?php if (!empty($course['description'])): ?>
            <p><strong>Description:</strong> <?= esc($course['description']) ?></p>
        <?php endif; ?>
        <p><strong>Instructor:</strong> <?= esc($course['instructor_name'] ?? 'Unknown') ?></p>
    </div>

    <div class="materials-list">
        <h3>Available Materials</h3>
        <?php if (!empty($materials) && is_array($materials)): ?>
            <ul>
                <?php foreach ($materials as $material): ?>
                    <li>
                        <div>
                            <strong><?= esc($material['file_name']) ?></strong>
                            <br>
                            <small style="color: #6c757d;">Uploaded: <?= date('F j, Y', strtotime($material['created_at'])) ?></small>
                        </div>
                        <a href="<?= base_url('materials/download/' . esc($material['id'])) ?>" class="download-btn" target="_blank">Download</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="empty-state">
                <h4>No materials available yet.</h4>
                <p>The instructor hasn't uploaded any materials for this course yet. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
