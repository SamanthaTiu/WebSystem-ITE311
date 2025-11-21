<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Grades</title>
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
        .grade-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .grade-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .grade-card h4 {
            margin: 0 0 10px 0;
            font-size: 20px;
            color: #0d6efd;
        }
        .grade-card p {
            margin: 0 0 15px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .grade-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #28a745;
        }
        .grade-info .grade {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .grade-info .grade-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .course-meta {
            font-size: 13px;
            color: #888;
            font-style: italic;
            margin-bottom: 10px;
        }
        .instructor-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        .instructor-info strong {
            color: #007bff;
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

<!-- Main Content -->
<div class="main-content">
    <h2>My Grades</h2>

    <div class="container-fluid">
        <?php if (!empty($grades) && is_array($grades)): ?>
            <?php foreach ($grades as $grade): ?>
                <?php
                    $courseTitle = $grade['course_name'] ?? $grade['name'] ?? 'Untitled Course';
                    $courseDesc = $grade['description'] ?? '';
                    $gradeValue = $grade['grade'] ?? $grade['score'] ?? 'N/A';
                    $gradeDate = isset($grade['graded_date']) ? date('F j, Y', strtotime($grade['graded_date'])) : 'Unknown date';
                    $instructorName = $grade['instructor_name'] ?? 'Unknown Instructor';
                    $comments = $grade['comments'] ?? '';
                ?>
                <div class="grade-card">
                    <h4><?= esc($courseTitle) ?></h4>
                    <?php if ($courseDesc): ?>
                        <p><?= esc($courseDesc) ?></p>
                    <?php endif; ?>
                    <div class="course-meta">Graded: <?= $gradeDate ?></div>

                    <div class="grade-info">
                        <div class="grade-label">Grade</div>
                        <div class="grade"><?= esc($gradeValue) ?></div>
                        <?php if ($comments): ?>
                            <div style="margin-top: 10px; font-size: 14px; color: #495057;">
                                <strong>Comments:</strong> <?= esc($comments) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="instructor-info" style="margin-top: 15px;">
                        <strong>Instructor:</strong> <?= esc($instructorName) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <h4>No grades available yet.</h4>
                <p>Your grades will appear here once your assignments and exams have been graded.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
