<!DOCTYPE html>
<html>
<head>
    <title>index</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content-box {
            margin-top: 100px;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        nav a {
            margin: 0 10px;
            text-decoration: none;
        }
        footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="content-box">
        <h1 class="mb-4">Welcome to the Homepage</h1>
        <nav class="mb-3">
            <a href="<?= base_url('/') ?>" class="btn btn-primary btn-sm">Home</a>
            <a href="<?= base_url('about') ?>" class="btn btn-secondary btn-sm">About</a>
            <a href="<?= base_url('contact') ?>" class="btn btn-success btn-sm">Contact</a>
        </nav>
    </div>
</div>

</body>
</html>
