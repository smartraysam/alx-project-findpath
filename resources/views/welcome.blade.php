<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FindPath</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/tailwindcssv3.css') }}">

    <style>
        /* Customize the splash screen styles here */
        .splash-screen {
            background-color: #3490dc; /* Change the background color */
            color: #fff; /* Change the text color */
            font-size: 24px;
        }
        @keyframes dot-animation {
            0% {
                opacity: 0;
            }
            25% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
            75% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        .dot {
            display: inline-block;
            animation: dot-animation 1.5s infinite;
        }
        /* Customize any other styles as needed */
    </style>
</head>

<body class="antialiased">
    <div class="flex items-center justify-center min-h-screen splash-screen">
        <!-- Your splash screen content goes here -->
        <div class="text-center">
            <img src="{{ asset('/assets/img/path.jpg') }}" alt="App Logo" style="margin: auto" class="mb-6 h-16 w-16">
            <h1 class="text-4xl font-bold">FindPath</h1>
            <p style="font-style: italic; font-size: 16px">
                Loading<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
            </p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.min.js" integrity="sha512-sNylduh9fqpYUK5OYXWcBleGzbZInWj8yCJAU57r1dpSK9tP2ghf/SRYCMj+KsslFkCOt3TvJrX2AV/Gc3wOqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Redirect to a new route after 4 seconds
        setTimeout(function () {
            window.location.href = `{{route("start")}}`; // Replace '/new-route' with your actual route
        }, 4000);
    </script>
</body>
</html>
