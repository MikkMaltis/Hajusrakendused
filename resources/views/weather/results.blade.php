<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#BBE1C3] flex items-center justify-center">
    <div class="bg-black shadow-2xl rounded-lg p-8 w-full max-w-4xl">
        <h1 class="text-4xl font-extrabold text-center text-[#f5f5f5] mb-6">Weather in {{ $weather['name'] }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Temperature -->
            <div class="bg-[#368f22] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Temperature</h2>
                <p class="text-xl text-[#f5f5f5] mt-2">{{ $weather['main']['temp'] }}°C</p>
            </div>

            <!-- Condition -->
            <div class="bg-[#2eb80f] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Condition</h2>
                <p class="text-xl text-[#f5f5f5] mt-2 capitalize">{{ $weather['weather'][0]['description'] }}</p>
            </div>

            <!-- Feels Like -->
            <div class="bg-[#368f22] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Feels Like</h2>
                <p class="text-xl text-[#f5f5f5] mt-2">{{ $additionalInfo['feels_like'] }}°C</p>
            </div>

            <!-- Humidity -->
            <div class="bg-[#2eb80f] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Humidity</h2>
                <p class="text-xl text-[#f5f5f5] mt-2">{{ $additionalInfo['humidity'] }}%</p>
            </div>

            <!-- Wind Speed -->
            <div class="bg-[#368f22] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Wind Speed</h2>
                <p class="text-xl text-[#f5f5f5] mt-2">{{ $additionalInfo['wind_speed'] }} m/s</p>
            </div>

            <!-- Wind Direction -->
            <div class="bg-[#2eb80f] p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl font-bold text-[#f5f5f5]">Wind Direction</h2>
                <p class="text-xl text-[#f5f5f5] mt-2">{{ $additionalInfo['wind_direction'] }}°</p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('weather.index') }}" class="text-white bg-[#368f22] hover:bg-[#2eb80f] px-6 py-3 rounded-lg shadow-md font-semibold">
                Back to Search
            </a>
        </div>
    </div>
</body>
</html>
