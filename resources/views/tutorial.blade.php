<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Image</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center">
    <div class="container text-center ">
        <!-- Responsive Images with Margin and Smaller Size -->
        <img src="{{ asset('img/p1_0.jpg') }}" alt="Responsive Example" class="img-fluid w-75 rounded shadow mb-3"><br>
        <img src="{{ asset('img/p2_0.jpg') }}" alt="Responsive Example" class="img-fluid w-75 rounded shadow mb-3"><br>
        <img src="{{ asset('img/p3_0.jpg') }}" alt="Responsive Example" class="img-fluid w-75 rounded shadow mb-3"><br>
        <img src="{{ asset('img/p4_0.jpg') }}" alt="Responsive Example" class="img-fluid w-75 rounded shadow mb-3"><br>
        <img src="{{ asset('img/p5_0.jpg') }}" alt="Responsive Example" class="img-fluid w-75 rounded shadow mb-3"><br>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
