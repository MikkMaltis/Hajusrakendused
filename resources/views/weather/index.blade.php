<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#BBE1C3] min-h-screen flex items-center justify-center">
    <div class="bg-[#1c1a1a] shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-[#f5f5f5]">Weather Forecast</h1>
        <form method="POST" action="{{ route('weather.fetchWeather') }}" class="space-y-4">
            @csrf
            <div>
                <label for="city" class="block text-sm font-medium text-[#f5f5f5]">City</label>
                <input type="text" id="city" name="city" placeholder="Enter city" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex justify-center">
                <button type="submit"
                    class="flex place-items-center bg-[#368f22] text-white py-[10px] px-4 rounded-md hover:bg-[#2eb80f] focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2">
                    Fetch Weather
                </button>
            </div>
        </form>

        @if (isset($weather))
        <div class="mt-6 p-4 bg-[#BBE1C3] rounded-md">
            <h2 class="text-lg font-semibold text-gray-800">Weather in {{ $weather['name'] }}</h2>
            <p class="text-[#1c1c1c] flex items-center">
                <i class="fas fa-thermometer-half mr-2"></i> Temperature: {{ $weather['main']['temp'] }}°C
            </p>
            <p class="text-[#1c1c1c] flex items-center">
                <i class="fas fa-cloud mr-2"></i> Condition: {{ $weather['weather'][0]['description'] }}
            </p>
            <p class="text-[#1c1c1c] mt-2 flex items-center">
                <i class="fas fa-temperature-low mr-2"></i> Feels Like: {{ $additionalInfo['feels_like'] }}°C
            </p>
            <p class="text-[#1c1c1c] mt-2 flex items-center">
                <i class="fas fa-tint mr-2"></i> Humidity: {{ $additionalInfo['humidity'] }}%
            </p>
            <p class="text-[#1c1c1c] mt-2 flex items-center">
                <i class="fas fa-wind mr-2"></i> Wind Speed: {{ $additionalInfo['wind_speed'] }} m/s
            </p>
            <p class="text-[#1c1c1c] mt-2 flex items-center">
                <i class="fas fa-compass mr-2"></i> Wind Direction: {{ $additionalInfo['wind_direction'] }}°
            </p>
        </div>
    @endif

        @if ($errors->any())
            <div class="mt-6 p-4 bg-red-100 rounded-md">
                <ul class="text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
