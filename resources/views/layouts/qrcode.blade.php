<!DOCTYPE html>
<html>
<head>
    <style>
        /* Container for all QR cards */
        .card-container {
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            height: 100%; /* Full height to fill the page */
            margin: 0; /* No extra margin */
            padding: 0; /* No padding */
            box-sizing: border-box; /* Ensure it takes up the full width and height */
        }

        /* Individual QR card styling */
        .qr-card {
            width: 100%; /* Take full width of the page */
            height: auto;
            box-sizing: border-box;
            border: 1px solid #000;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally inside the card */
            text-align: center;
        }

        /* Title styling */
        .card-title h4 {
            font-size: 1.2em;
            margin: 5px 0;
        }

        /* QR code section styling */
        .qr-code {
            width: 50%; /* Adjust QR code width */
            height: auto;
            margin: 20px 0;
        }

        /* Information section styling */
        .info {
            font-size: 16px;
            text-align: left;
        }

        /* Print-specific styling */
        @media print {
            @page {
                size: A5; /* Set to A5 size */
                margin: 0; /* Remove all margins */
            }

            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                box-sizing: border-box;
            }

            /* Remove any default padding or margins for the body and container */
            body {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            .card-container {
                height: 100%; /* Full height of the page */
                width: 100%; /* Full width of the page */
                justify-content: center;
                align-items: center;
            }

            .qr-card {
                width: 90%; /* Full width for the QR card */
                padding: 80px;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                align-items: center;
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
