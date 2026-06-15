<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คู่มือการใช้งาน — MEDFIX+</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; background: #f6f8fa; }
        .mf-tutorial-header {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #e6ebf1;
            padding: .8rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: .55rem;
        }
        .mf-tutorial-header .brand-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, #14b8a6, #0c7187); color: #fff; font-size: .9rem;
        }
        .mf-tutorial-header b { color: #0f172a; }
        .mf-tutorial-header span.subtitle { color: #64748b; font-size: .9rem; }
        .mf-tutorial-img {
            border: 1px solid #e6ebf1;
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 4px 14px rgba(15, 23, 42, .05);
        }
    </style>
</head>
<body>
    <header class="mf-tutorial-header">
        <span class="brand-icon">&#43;</span>
        <b>MEDFIX+</b>
        <span class="subtitle">คู่มือการใช้งาน</span>
    </header>
    <div class="container text-center py-4">
        <!-- Responsive Images with Margin and Smaller Size -->
        <img src="{{ asset('img/p1_0.jpg') }}" alt="คู่มือการใช้งาน หน้า 1" class="img-fluid w-75 mf-tutorial-img mb-3" loading="lazy"><br>
        <img src="{{ asset('img/p2_0.jpg') }}" alt="คู่มือการใช้งาน หน้า 2" class="img-fluid w-75 mf-tutorial-img mb-3" loading="lazy"><br>
        <img src="{{ asset('img/p3_0.jpg') }}" alt="คู่มือการใช้งาน หน้า 3" class="img-fluid w-75 mf-tutorial-img mb-3" loading="lazy"><br>
        <img src="{{ asset('img/p4_0.jpg') }}" alt="คู่มือการใช้งาน หน้า 4" class="img-fluid w-75 mf-tutorial-img mb-3" loading="lazy"><br>
        <img src="{{ asset('img/p5_0.jpg') }}" alt="คู่มือการใช้งาน หน้า 5" class="img-fluid w-75 mf-tutorial-img mb-3" loading="lazy"><br>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
