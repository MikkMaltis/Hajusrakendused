@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1>My Favorite Music</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('music.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <div class="row">
        @forelse($music as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($item->image)
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title }}">
                    @else
                        <div class="bg-light text-center p-5">No Image</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $item->artist }}</h6>
                        <p class="card-text"><small class="text-muted">Genre: {{ $item->genre }}</small></p>
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                        <a href="{{ route('music.show', $item) }}" class="btn btn-info">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No music entries found. <a href="{{ route('music.create') }}">Add one!</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- External API Section -->
    <div class="mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="m-0">External API Data</h2>
            <span class="badge bg-secondary">Live Data</span>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-cloud-download me-2"></i>
                    Data from <code class="bg-primary bg-opacity-75 text-light">hajusrakendus.tak22jasin.itmajakas.ee/api/subjects</code>
                </span>
                <button id="refreshApiData" class="btn btn-sm btn-light">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
            <div class="card-body">
                <!-- Loading indicator -->
                <div id="loading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Fetching data from external API...</p>
                </div>

                <!-- Error message -->
                <div id="apiError" class="alert alert-danger d-flex align-items-center" style="display: none;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        Unable to load data from external API. Please try again later.
                    </div>
                </div>

                <!-- API data container -->
                <div id="apiData" class="table-responsive" style="display: none;">
                    <!-- API data will be displayed here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiUrl = 'https://hajusrakendus.tak22jasin.itmajakas.ee/api/subjects';
            const apiDataContainer = document.getElementById('apiData');
            const loadingIndicator = document.getElementById('loading');
            const errorMessage = document.getElementById('apiError');
            const refreshButton = document.getElementById('refreshApiData');

            function fetchApiData() {
                loadingIndicator.style.display = 'block';
                apiDataContainer.style.display = 'none';
                errorMessage.style.display = 'none';

                fetch(apiUrl, {
                    method: 'GET',
                    mode: 'cors',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    loadingIndicator.style.display = 'none';
                    apiDataContainer.style.display = 'block';

                    // Clear previous data
                    apiDataContainer.innerHTML = '';

                    if (data && data.length > 0) {
                        // Create cards view for the data
                        const cardContainer = document.createElement('div');
                        cardContainer.className = 'row';

                        // Add data cards
                        data.forEach(item => {
                            const col = document.createElement('div');
                            col.className = 'col-lg-4 col-md-6 mb-4';

                            const card = document.createElement('div');
                            card.className = 'card h-100 border-0 shadow-sm';

                            // Card header with ID badge
                            const cardHeader = document.createElement('div');
                            cardHeader.className = 'card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center';

                            // Add the ID badge
                            const idBadge = document.createElement('span');
                            idBadge.className = 'badge bg-secondary';
                            idBadge.textContent = `ID: ${item.id || 'N/A'}`;
                            cardHeader.appendChild(idBadge);

                            // Add the title if available
                            if (item.title) {
                                const titleElement = document.createElement('h5');
                                titleElement.className = 'card-title mb-0 text-primary';
                                titleElement.textContent = item.title;
                                cardHeader.appendChild(titleElement);
                            }

                            card.appendChild(cardHeader);

                            // Card body with image and content
                            const cardBody = document.createElement('div');
                            cardBody.className = 'card-body';

                            // Handle image if available
                            if (item.image) {
                                const imageContainer = document.createElement('div');
                                imageContainer.className = 'text-center mb-3';

                                const img = document.createElement('img');
                                img.src = item.image;
                                img.alt = item.title || 'Subject image';
                                img.className = 'img-fluid rounded';
                                img.style.maxHeight = '150px';

                                imageContainer.appendChild(img);
                                cardBody.appendChild(imageContainer);
                            }

                            // Create a details list for other properties
                            const detailsList = document.createElement('ul');
                            detailsList.className = 'list-group list-group-flush';

                            Object.keys(item).forEach(key => {
                                // Skip id, title and image as they're handled separately
                                if (key !== 'id' && key !== 'title' && key !== 'image') {
                                    const listItem = document.createElement('li');
                                    listItem.className = 'list-group-item border-0 px-0';

                                    const keyElement = document.createElement('strong');
                                    keyElement.textContent = key.charAt(0).toUpperCase() + key.slice(1) + ': ';

                                    listItem.appendChild(keyElement);
                                    listItem.appendChild(document.createTextNode(item[key] || 'N/A'));

                                    detailsList.appendChild(listItem);
                                }
                            });

                            cardBody.appendChild(detailsList);
                            card.appendChild(cardBody);
                            col.appendChild(card);
                            cardContainer.appendChild(col);
                        });

                        apiDataContainer.appendChild(cardContainer);

                        const infoText = document.createElement('p');
                        infoText.className = 'text-muted mt-3 small text-center';
                        infoText.textContent = `Showing ${data.length} items from external API`;
                        apiDataContainer.appendChild(infoText);
                    } else {
                        apiDataContainer.innerHTML = '<div class="alert alert-info">No data available from external API.</div>';
                    }
                })
                .catch(error => {
                    loadingIndicator.style.display = 'none';
                    errorMessage.style.display = 'block';

                    const errorDiv = errorMessage.querySelector('div');
                    errorDiv.innerHTML = `Unable to load data from external API: ${error.message}. <br>
                                         This could be due to CORS restrictions or the API being unavailable.`;

                    console.error('Error fetching API data:', error);
                });
            }

            fetchApiData();

            refreshButton.addEventListener('click', fetchApiData);
        });
    </script>
@endsection
