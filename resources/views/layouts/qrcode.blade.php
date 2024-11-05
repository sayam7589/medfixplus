<!DOCTYPE html>
<html>
<head>
    <style>
        /* Container for all QR cards */
        .card-container {
            display: flex;
            flex-wrap: wrap; /* Allows cards to wrap onto the next row */
            gap: 15px; /* Adjusted space between cards */
            justify-content: space-between; /* Aligns cards evenly across the row */
        }

        /* Individual QR card styling for sticker size */
        .qr-card {
            flex: 0 0 100px; /* Width set to 100px */
            height: 150px; /* Height set to 150px */
            box-sizing: border-box;
            border: 2px solid #000;
            padding: 10px; /* Reduced padding for smaller sticker size */
            text-align: center;
            page-break-inside: avoid;
            overflow: hidden; /* Ensures content fits within the sticker size */
        }

        /* Title styling */
        .card-title {
            font-size: 20px; /* Font size set to 20px */
            margin-bottom: 8px; /* Space below the title */
            text-align: center;
        }

        /* QR code section styling */
        .qr-code {
            margin-bottom: 8px; /* Space below the QR code */
        }

        /* Information section styling */
        .info {
            text-align: left;
            font-size: 12px; /* Smaller font size for additional info */
        }

        /* Print-specific styling */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt;
            }
            .card-container {
                display: block;
            }
            .qr-card {
                border: 2px solid #000;
                width: 100px;
                height: 150px;
                margin: 5px auto; /* Center the card with a small margin */
                padding: 5px;
                box-sizing: border-box;
                page-break-before: always;
                page-break-inside: avoid;
            }
            @page {
                size: A4;
                margin: 10mm;
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
