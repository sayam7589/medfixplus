<!DOCTYPE html>
<html>
<head>
    <style>
        /* Individual QR card styling */
        <style>
    /* Center the content */
    .row {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .card-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-card {
        width: 100%;
        height: 100%;
        border: 1px solid #ddd;
        padding: 1rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    /* Header styling */
    .card-title h4 {
        font-size: 2.5em; /* Adjust for H3 equivalent */
        margin: 0.2em 0;
    }

    /* QR code size */
    .qr-code {
        width: 70%;
        margin: 1em auto;
    }

    /* Info section styling */
    .info {
        font-size: 32px;
        line-height: 1.4;
    }

    /* Additional print-specific settings */
    @media print {
        body {
            margin: 0;
            padding: 0;
        }
        .qr-card {
            border: none;
            box-shadow: none;
        }
    }
</style>

    </style>
</head>
<body>

    @yield('content')

    <script>
        // Automatically trigger the print dialog when the page loads
        window.onload = function() {
            window.print();
        };
    </script>

    @yield('scripts')
</body>
</html>
