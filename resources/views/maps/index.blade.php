<!-- filepath: /home/mikk/Ralf/hajusrakendused/ralf-hajus/resources/views/maps/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding: 0;
            margin: 0;
        }
        #map {
            height: 70vh;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .marker-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .marker-list {
            max-height: 600px;
            overflow-y: auto;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .marker-item {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 10px;
        }
        .marker-item:hover {
            background-color: #e9ecef;
        }
        .btn-marker {
            margin-right: 5px;
        }
        .coordinates {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .instructions {
            margin-bottom: 15px;
            color: #6c757d;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #368f22;">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-map-marker-alt me-2"></i>Map</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('weather.index') }}">Weather</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('maps.index') }}">Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1>Interactive Map</h1>
                <div class="instructions">
                    <p><i class="fas fa-info-circle me-2"></i>Click on the map to add a new marker. View all markers in the list on the right.</p>
                </div>
                <div id="map"></div>

                <div class="marker-form mt-4" id="markerForm" style="display: none;">
                    <h3 id="formTitle">Add New Marker</h3>
                    <form id="addMarkerForm" method="POST" action="{{ route('maps.store') }}">
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="markerId" name="marker_id">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save Marker</button>
                            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <h2>Markers List</h2>
                <div class="marker-list">
                    @if(isset($markers) && count($markers) > 0)
                        @foreach($markers as $marker)
                            <div class="marker-item" data-id="{{ $marker->id }}">
                                <h5>{{ $marker->name }}</h5>
                                <p>{{ $marker->description }}</p>
                                <p class="coordinates">
                                    <i class="fas fa-map-pin me-1"></i>
                                    {{ number_format($marker->latitude, 6) }}, {{ number_format($marker->longitude, 6) }}
                                </p>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-info btn-marker view-marker"
                                            data-id="{{ $marker->id }}"
                                            data-lat="{{ $marker->latitude }}"
                                            data-lng="{{ $marker->longitude }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning btn-marker edit-marker"
                                            data-id="{{ $marker->id }}"
                                            data-name="{{ $marker->name }}"
                                            data-lat="{{ $marker->latitude }}"
                                            data-lng="{{ $marker->longitude }}"
                                            data-description="{{ $marker->description }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('maps.destroy', $marker->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-marker delete-marker"
                                                onclick="return confirm('Are you sure you want to delete this marker?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-map-marked-alt fa-3x mb-3 text-muted"></i>
                            <p>No markers added yet. Click on the map to add your first marker!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const map = L.map('map').setView([58.3563022, 25.482113], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const markers = {};


            @if(isset($markers))
                @foreach($markers as $marker)
                    var marker = L.marker([{{ $marker->latitude }}, {{ $marker->longitude }}])
                        .addTo(map)
                        .bindPopup("<b>{{ $marker->name }}</b><br>{{ $marker->description }}");
                    markers[{{ $marker->id }}] = marker;
                @endforeach
            @endif


            function refreshMarkers() {

                Object.values(markers).forEach(marker => {
                    map.removeLayer(marker);
                });


                Object.keys(markers).forEach(key => {
                    delete markers[key];
                });


                @if(isset($markers))
                    @foreach($markers as $marker)
                        markers[{{ $marker->id }}] = L.marker([{{ $marker->latitude }}, {{ $marker->longitude }}])
                            .addTo(map)
                            .bindPopup("<b>{{ $marker->name }}</b><br>{{ $marker->description }}");
                    @endforeach
                @endif
            }


            refreshMarkers();


            @if(session('success'))
                refreshMarkers();
            @endif


            map.on('click', function(e) {
                showForm('add', e.latlng.lat, e.latlng.lng);
            });


            const markerForm = document.getElementById('markerForm');
            const formTitle = document.getElementById('formTitle');
            const addMarkerForm = document.getElementById('addMarkerForm');
            const cancelBtn = document.getElementById('cancelBtn');
            const submitBtn = document.getElementById('submitBtn');
            const formMethod = document.getElementById('formMethod');
            const markerId = document.getElementById('markerId');


            function showForm(mode, lat, lng, id = null, name = '', description = '') {
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                const nameInput = document.getElementById('name');
                const descInput = document.getElementById('description');

                latInput.value = lat;
                lngInput.value = lng;

                if (mode === 'edit') {
                    formTitle.textContent = 'Edit Marker';

                    addMarkerForm.action = "{{ url('maps') }}/" + id;

                    addMarkerForm.innerHTML = `
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="formMethod" name="_method" value="PUT">
                        <input type="hidden" id="markerId" name="marker_id" value="${id}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="${name}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="${lat}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="${lng}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">${description}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary " id="submitBtn" style="background-color: #368f22">Update Marker</button>
                            <button type="button" class="btn btn-secondary" id="cancelBtn" >Cancel</button>
                        </div>
                    `;
                } else {
                    formTitle.textContent = 'Add New Marker';
                    addMarkerForm.action = "{{ route('maps.store') }}";
                    addMarkerForm.innerHTML = `
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <input type="hidden" id="markerId" name="marker_id">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="${lat}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="${lng}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button style="background-color: #368f22" type="submit" class="btn btn-primary" id="submitBtn">Save Marker</button>
                            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        </div>
                    `;
                }


                document.getElementById('cancelBtn').addEventListener('click', function() {
                    markerForm.style.display = 'none';
                });

                markerForm.style.display = 'block';
            }


            cancelBtn.addEventListener('click', function() {
                markerForm.style.display = 'none';
            });


            document.querySelectorAll('.edit-marker').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const lat = this.getAttribute('data-lat');
                    const lng = this.getAttribute('data-lng');
                    const description = this.getAttribute('data-description');

                    showForm('edit', lat, lng, id, name, description);
                });
            });


            document.querySelectorAll('.view-marker').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));

                    map.setView([lat, lng], 14);
                    if (markers[id]) {
                        markers[id].openPopup();
                    }
                });
            });


            @if(session('success'))
                const successMessage = "{{ session('success') }}";


                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                    ${successMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;


                document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild);


                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            @endif


            @if(session('deleted_marker_id'))

                const deletedId = {{ session('deleted_marker_id') }};
                    if (markers[deletedId]) {

                        markers[deletedId].remove();
                        map.removeLayer(markers[deletedId]);
                        delete markers[deletedId];

                        console.log('Deleted marker with ID:', deletedId);
    }
@endif
        });
    </script>
</body>
</html>
