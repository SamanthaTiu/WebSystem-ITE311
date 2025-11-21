<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF token for AJAX (CodeIgniter 4) -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">

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
        .welcome-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: auto;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Course sections styling */
        .courses-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 1200px;
            margin: 20px auto;
        }
        .course-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            padding: 20px;
        }
        .course-section h3 {
            margin-top: 0;
            color: #343a40;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .course-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .course-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .course-card h4 {
            margin: 0 0 8px 0;
            font-size: 18px;
            color: #0d6efd;
        }
        .course-card p {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .course-meta {
            font-size: 12px;
            color: #888;
            font-style: italic;
        }
        .btn-enroll {
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-enroll:hover:not(:disabled) {
            background: #0b5ed7;
            transform: scale(1.05);
        }
        .btn-enrolled {
            background: #198754;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: not-allowed;
        }
        .empty-state {
            color: #6c757d;
            font-style: italic;
            text-align: center;
            padding: 30px;
        }

        /* Alert container */
        #alert-container {
            max-width: 1200px;
            margin: 0 auto 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
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
    <h2>Student Dashboard</h2>

    <!-- Alert Container for Bootstrap Alerts -->
    <div id="alert-container"></div>

    <!-- Welcome Card -->
    <div class="welcome-card">
        <h4>Welcome, <strong><?= esc($name ?? 'Student') ?></strong>!</h4>
        <p>You are logged in as <strong>student</strong>.</p>
        <p>Here you can view your lessons, submit assignments, and check grades.</p>
    </div>

    <!-- STEP 4: Display Enrolled Courses and Available Courses -->
    <div class="courses-grid">
        
        <!-- ENROLLED COURSES SECTION -->
        <div class="course-section">
            <h3>📚 Enrolled Courses</h3>
            <div id="enrolled-courses-list">
                <?php if (!empty($enrollments) && is_array($enrollments)): ?>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <?php
                            $courseId = $enrollment['course_id'] ?? 0;
                            $courseTitle = $enrollment['course_name'] ?? $enrollment['name'] ?? 'Untitled Course';
                            $courseDesc = $enrollment['description'] ?? '';
                            $enrolledAt = isset($enrollment['enrollment_date'])
                                ? date('F j, Y', strtotime($enrollment['enrollment_date']))
                                : 'Unknown date';
                        ?>
                        <div class="course-card" data-course-id="<?= $courseId ?>">
                            <h4><?= esc($courseTitle) ?></h4>
                            <?php if ($courseDesc): ?>
                                <p><?= esc($courseDesc) ?></p>
                            <?php endif; ?>
                            <div class="course-meta">Enrolled: <?= $enrolledAt ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state" id="no-enrollments-message">
                        You are not enrolled in any courses yet.<br>
                        Browse available courses to get started!
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- AVAILABLE COURSES SECTION -->
        <div class="course-section">
            <h3>🌟 Available Courses</h3>
            <div id="available-courses-list">
                <?php if (!empty($courses) && is_array($courses)): ?>
                    <?php 
                        // Get list of enrolled course IDs for comparison
                        $enrolledCourseIds = [];
                        if (!empty($enrollments)) {
                            foreach ($enrollments as $en) {
                                $enrolledCourseIds[] = $en['id'] ?? $en['course_id'] ?? 0;
                            }
                        }
                    ?>
                    <?php foreach ($courses as $course): ?>
                        <?php
                            $courseId = $course['course_id'] ?? 0;
                            $courseTitle = $course['course_name'] ?? $course['name'] ?? 'Untitled Course';
                            $courseDesc = $course['description'] ?? '';
                            $isEnrolled = in_array($courseId, $enrolledCourseIds);
                        ?>
                        <div class="course-card" id="course-<?= $courseId ?>">
                            <h4><?= esc($courseTitle) ?></h4>
                            <?php if ($courseDesc): ?>
                                <p><?= esc($courseDesc) ?></p>
                            <?php endif; ?>
                            
                            <?php if ($isEnrolled): ?>
                                <button class="btn-enrolled" disabled>Enrolled</button>
                            <?php else: ?>
                                <!-- STEP 5: Add data_course_id attribute -->
                                <button class="btn-enroll" data-course-id="<?= $courseId ?>">
                                    Enroll Now
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        No courses available at the moment.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- jQuery Library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- STEP 5: AJAX Enrollment Script -->
<script>
$(document).ready(function() {
    // Get CSRF token from meta tags
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var csrfName = $('meta[name="csrf-name"]').attr('content');

    // Function to display Bootstrap alert
    function showAlert(type, message) {
        var alertId = 'alert-' + Date.now();
        var alertHTML = `
            <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('#alert-container').append(alertHTML);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('#' + alertId).alert('close');
        }, 5000);
    }

    // Listen for click on Enroll buttons
    $(document).on('click', '.btn-enroll', function(e) {
        e.preventDefault(); // Prevent default form submission

        var $button = $(this);
        var courseId = $button.attr('data-course-id');
        
        // Validation
        if (!courseId) {
            showAlert('danger', 'Error: Invalid course ID');
            return;
        }

        // Disable button and show loading state
        $button.prop('disabled', true).text('Enrolling...');

        // Prepare POST data
        var postData = {
            course_id: courseId
        };

        // Add CSRF token if available
        if (csrfName && csrfToken) {
            postData[csrfName] = csrfToken;
        }

        // AJAX POST request using $.post()
        $.post('<?= site_url("course/enroll") ?>', postData, function(response) {
            // Success callback
            if (response.status === 'success') {
                // Display success alert
                showAlert('success', response.message || 'Successfully enrolled in the course!');

                // Get course details
                var $courseCard = $('#course-' + courseId);
                var courseTitle = $courseCard.find('h4').text();
                var courseDesc = $courseCard.find('p').text();

                // Hide/Disable the Enroll button
                $button.removeClass('btn-enroll')
                       .addClass('btn-enrolled')
                       .text('Enrolled')
                       .prop('disabled', true);

                // Update Enrolled Courses list dynamically
                var enrolledDate = new Date().toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });

                var newEnrolledCourse = `
                    <div class="course-card" data-course-id="${courseId}">
                        <h4>${courseTitle}</h4>
                        ${courseDesc ? '<p>' + courseDesc + '</p>' : ''}
                        <div class="course-meta">Enrolled: ${enrolledDate}</div>
                    </div>
                `;

                // Remove "no courses" message if it exists
                $('#no-enrollments-message').remove();

                // Add to enrolled courses list (prepend to show at top)
                $('#enrolled-courses-list').prepend(newEnrolledCourse);

            } else {
                // Handle error response
                showAlert('danger', response.message || 'Failed to enroll in the course');
                
                // Re-enable button if not already enrolled
                if (response.message && response.message.includes('already')) {
                    $button.removeClass('btn-enroll')
                           .addClass('btn-enrolled')
                           .text('Enrolled')
                           .prop('disabled', true);
                } else {
                    $button.prop('disabled', false).text('Enroll Now');
                }
            }
        }, 'json')
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
            console.error('Response:', jqXHR.responseText);
            
            var errorMessage = 'An error occurred. Please try again.';
            
            // Try to parse error response
            try {
                var errorResponse = JSON.parse(jqXHR.responseText);
                errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
                // Use default error message
            }

            showAlert('danger', errorMessage);

            // Handle specific HTTP status codes
            if (jqXHR.status === 409) {
                // Already enrolled
                $button.removeClass('btn-enroll')
                       .addClass('btn-enrolled')
                       .text('Enrolled')
                       .prop('disabled', true);
            } else if (jqXHR.status === 401) {
                // Not logged in
                showAlert('warning', 'Please log in to enroll in courses');
            } else {
                // Other errors - re-enable button
                $button.prop('disabled', false).text('Enroll Now');
            }
        });
    });
});
</script>

</body>
</html>