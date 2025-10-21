<!DOCTYPE html>
<html>
<head>
    <title>Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-center">University Announcements</h2>

    <?php if (empty($announcements)): ?>
        <div class="alert alert-info text-center">No announcements yet.</div>
    <?php else: ?>
        <?php foreach ($announcements as $a): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($a['title']) ?></h5>
                    <p class="card-text"><?= esc($a['content']) ?></p>
                    <p class="text-muted small">Posted on <?= date('F d, Y h:i A', strtotime($a['created_at'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
