<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FindPath</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/tailwindcssv3.css') }}"> --}}
    @vite('resources/css/app.css')
    <style>
        /* Customize the splash screen styles here */
        .splash-screen {
            background-color: #ffffff;
            font-size: 24px;
        }

        .animate-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
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

        @keyframes loading {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }

        .loading-container {
            display: flex;
            flex-direction: column; 
            justify-content: center;
            align-items: center;
            margin: 20px;
        }

        .loading-text {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .loading-bar {
            width: 100%;
            height: 10px;
            background-color: #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .loading-bar-inner {
            width: 0%;
            height: 100%;
            background-color: rgb(59 130 246);
            animation: loading 3s linear infinite;
        }

        /* Customize any other styles as needed */
    </style>
</head>

<body class="antialiased">
    <div class="flex items-top justify-center min-h-screen splash-screen" style="padding-top: 30px">
        <!-- Your splash screen content goes here -->
        <div class="text-center">
            <div class="mb-8">
                {{-- <span>From</span> --}}
                <input type="text" placeholder="Where are you? ie toll gate"
                    class="w-72 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                    style="font-size: 1.1rem; padding-left: 30px; margin-right:-30px">
                <i class="fa fa-search" style="position:relative; left:-260px"></i>
            </div>
            <div class="mb-8">
                {{-- <span>To</span> --}}
                <input type="text" placeholder="Where are you going?"
                    class="w-72 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                    style="font-size: 1.1rem;  padding-left: 30px; margin-right:-30px">
                <i class="fa fa-search" style="position:relative; left:-260px"></i>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" style="font-size: 1.1rem; width:250px">Route Me</button>

            <div class="loading-container" style="margin-top:150px">
                <span class="loading-text">Loading...</span>
                <div class="loading-bar">
                    <div class="loading-bar-inner"></div>
                </div>
            </div>

        </div>
    </div>
</body>
</body>

</html>
