<!DOCTYPE html>
<html>
<head>
    <style>
        /* Container for all QR cards */
        .card-container {
            display: flex;
            flex-direction: column; /* Ensure QR cards are stacked vertically */
            align-items: center;
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Individual QR card styling */
        .qr-card {
            width: 90%; /* Adjust width for better fit */
            height: auto; /* Added padding for spacing */
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 10mm; /* Space between cards */
            margin-top: 5mm; /* Reduce space from the top of the page */
        }

        /* Title styling */
        .card-title h4 {
            font-size: 2.5em;
            margin: 5px 0;
        }

        /* QR code section styling */
        .qr-code {
            width: 100%;
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
                size: A4; /* Set to A5 size */
                margin: 0; /* Remove all margins */
            }

            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                display:block;
                justify-content: center;
                align-items: flex-start;
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            .card-container {
                width: 100%;
                height: 100%;
                justify-content: flex-start; /* Align cards to the top */
                padding: 0;
            }

            .info {
                font-size: 30px;
                text-align: left; /* Align text to the left */
                width: 100%; /* Ensure the section takes up full width */
                padding: 0; /* Optional: Remove padding if it's pushing the content */
            }

            .qr-card {
                width: 90%; /* Adjust the width */
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                text-align: center;
                page-break-before: always; /* Force a page break before each QR card */
              /* Adjust the top margin for a moderate space from the top of the page */
            }

            .qr-card:first-child {
                page-break-before: auto; /* Don't break before the first card */
                Add space for the first card */
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
