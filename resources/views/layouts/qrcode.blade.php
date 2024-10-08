<!DOCTYPE html>
<html>
<head>
    <style>
        /* Container for all QR cards */
        .card-container {
            display: flex;
            flex-wrap: wrap; /* Allows cards to wrap onto the next row */
            gap: 30px; /* Increased space between cards */
            justify-content: space-between; /* Aligns cards evenly across the row */
        }

        /* Individual QR card styling */
        .qr-card {
            flex: 0 0 calc(33.333% - 30px); /* 1/3 width minus the increased gap */
            box-sizing: border-box; /* Includes padding and border in width */
            border: 2px solid #000;
            padding: 20px; /* Increased padding for larger cards */
            text-align: center; /* Centers content inside the card */
            page-break-inside: avoid; /* Avoids breaking cards across pages */
        }

        /* Title styling */
        .card-title {
            font-size: 1.8em; /* Larger font size for the title */
            margin-bottom: 15px; /* Space below the title */
            text-align: center; /* Center the title text */
        }

        /* QR code section styling */
        .qr-code {
            margin-bottom: 15px; /* Space below the QR code */
        }

        /* Information section styling */
        .info {
            text-align: left; /* Aligns the info text to the left */
        }

        /* Print-specific styling */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt; /* Adjust font size for printing */
            }
            .card-container {
                display: block; /* Ensure each card takes full width in print */
            }
            .qr-card {
                border: 2px solid #000; /* Border for print */
                width: 100%; /* Full width of container */
                max-width: 80%; /* Limit the width for centering */
                margin: 0 auto; /* Center the card horizontally */
                box-sizing: border-box; /* Includes padding and border in width */
                padding: 20px; /* Consistent padding for print */
                page-break-before: always; /* Start a new page for each card */
                page-break-inside: avoid; /* Avoid breaking cards across pages */
            }
            @page {
                size: A4; /* Define page size */
                margin: 20mm; /* Set page margins */
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
