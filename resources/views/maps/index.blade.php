<!DOCTYPE html>
<html>
  <head>
    <link href="https://js.radar.com/v4.5.1/radar.css" rel="stylesheet"></link>
    <script src="https://js.radar.com/v4.5.1/radar.min.js"></script>
    <style>
        /* Ensure the body and html take up the full height */
        html, body {
          margin: 0;
          padding: 0;
          height: 100%;
        }

        /* Make the map container fullscreen */
        #map {
          width: 100%;
          height: 100%;
        }
      </style>
  </head>

  <body>
    <div id="map"></div>

    <script type="text/javascript">
      Radar.initialize('{{ config('services.radar.key') }}');

        const centerCoordinates = [25.518852, 58.531499]; // Center of Estonia
        console.log('Center coordinates:', centerCoordinates);

      const map = Radar.ui.map({
        container: 'map',
        style: 'radar-default-v1',
        center: centerCoordinates,
        zoom: 7,
      });
    </script>
  </body>
</html>
