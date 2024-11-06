<!DOCTYPE html>
<html>
<head>
    <style>
        /* Container for all QR cards */
        .card-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Individual QR card styling */
        .qr-card {
            width: 90%;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            page-break-after: always; /* Page break after each card */
        }

        /* Title styling */
        .card-title h4 {
            font-size: 2em;
        }

        /* QR code section styling */
        .qr-code {
            width: 80%;
            height: auto;
            margin: 20px 0;
        }

        /* Information section styling */
        .info {
            font-size: 24px;
            text-align: left; 
        }

        /* Print-specific styling */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                display: block;
                justify-content: center;
                align-items: flex-start;
                box-sizing: border-box;
            }

            .info {
                font-size: 24px;
                text-align: left;
                margin-left: 80px;
                width: 100%;
                padding: 0;
            }

            .qr-card {
                width: 90%;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                text-align: center;
            }

        }
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
