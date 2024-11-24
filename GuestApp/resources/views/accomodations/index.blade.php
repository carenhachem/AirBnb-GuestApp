@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="container-fluid bg-light py-5 mb-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Find Your Perfect Stay</h1>
            <p class="lead">Discover amazing accommodations across Lebanon</p>
        </div>
    </div>

    <!-- Types Section -->
    <div class="container mb-5">
        <div class="d-flex justify-content-center flex-wrap gap-2">
            @foreach ($types as $type)
                <button 
                    class="btn btn-outline-secondary filter-type-button"
                    data-type="{{ $type->accomodationdesc }}">
                    {{ $type->accomodationdesc }}
                </button>
            @endforeach
            <button class="btn btn-outline-danger" id="clearFilters">Clear All Filters</button>
        </div>
    </div>

    <!-- Sorting and Filter Button -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <!-- Sorting Form -->
            <form method="GET" action="{{ route('accomodations.index') }}" id="sortingForm" class="d-flex gap-2">
                <!-- Hidden Inputs for Bounds -->
                <input type="hidden" name="bounds" id="boundsInput" value="{{ request('bounds') }}">

                <!-- Sorting Dropdown -->
                <select name="sort_by" class="form-select" onchange="document.getElementById('sortingForm').submit()">
                    <option value="">Sort By</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating_asc" {{ request('sort_by') == 'rating_asc' ? 'selected' : '' }}>Rating: Low to High</option>
                    <option value="rating_desc" {{ request('sort_by') == 'rating_desc' ? 'selected' : '' }}>Rating: High to Low</option>
                </select>
            </form>

            <!-- Filter Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill"></i> Advanced Filter
            </button>
        </div>
    </div>

    <!-- Map and Accommodations Section -->
    <div class="container-fluid">
        <div class="row">
            <!-- Accommodation Cards -->
            <div class="col-lg-8 mb-5">
                <div class="row" id="accomodation-list">
                    @forelse ($accomodations as $accomodation)
                        <div class="col-md-6 mb-4 accomodation-item" 
                             data-type="{{ $accomodation->type->accomodationdesc ?? 'Unknown' }}" 
                             data-price="{{ $accomodation->pricepernight }}" 
                             data-amenities="{{ implode(',', $accomodation->amenities->pluck('amenitydesc')->toArray()) }}"
                             data-lat="{{ $accomodation->location->latitude ?? '0' }}"
                             data-lng="{{ $accomodation->location->longitude ?? '0' }}">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $accomodation->image ? json_decode($accomodation->image)->url : 'default.jpg' }}" class="card-img-top" alt="{{ $accomodation->description }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $accomodation->description }}</h5>
                                    <p class="card-text text-muted">
                                        <i class="bi bi-house-door-fill me-1"></i>{{ $accomodation->type->accomodationdesc ?? 'N/A' }}
                                        <br>
                                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $accomodation->location->city ?? 'N/A' }}
                                        <br>
                                        <i class="bi bi-people-fill me-1"></i>{{ $accomodation->guestcapacity }} guests
                                        <br>
                                        <i class="bi bi-star-fill text-warning me-1"></i>{{ $accomodation->rating }} stars
                                    </p>
                                    <div class="mt-auto">
                                        <h5 class="text-primary mb-3">${{ $accomodation->pricepernight }} <small class="text-muted">/ night</small></h5>
                                        <a href="{{ route('accomodations.show', $accomodation->accomodationid) }}" class="btn btn-outline-primary w-100">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">No accommodations found. Try changing the filters.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-lg-4">
                <div id="map" style="width: 100%; height: 600px; border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Advanced Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Filter Form -->
                    <form id="advancedFilterForm">
                        <div class="mb-4">
                            <label for="filterType" class="form-label">Type of Place</label>
                            <select id="filterType" class="form-select">
                                <option value="">Any Type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->accomodationdesc }}">{{ $type->accomodationdesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="priceRange" class="form-label">Price Range</label>
                            <input type="text" id="priceRange" readonly class="form-control bg-white">
                            <div id="priceRangeSlider" class="mt-3"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Amenities</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($amenities as $amenity)
                                    <div class="form-check">
                                        <input class="form-check-input filter-amenity" type="checkbox" value="{{ $amenity->amenitydesc }}" id="amenity-{{ $amenity->amenitydesc }}">
                                        <label class="form-check-label" for="amenity-{{ $amenity->amenitydesc }}">
                                            {{ $amenity->amenitydesc }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="guestCapacity" class="form-label">Guest Capacity</label>
                            <input type="number" id="guestCapacity" class="form-control" placeholder="Number of guests">
                        </div>
                        <div class="mb-4">
                            <label for="rating" class="form-label">Minimum Rating</label>
                            <select id="rating" class="form-select">
                                <option value="">Any Rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Stars</option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applyFilters">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Mapbox GL JS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">

    <!-- noUiSlider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .price-marker {
            background: rgba(0, 123, 255, 0.9);
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            white-space: nowrap;
        }

        /* Custom scrollbar for map */
        #map .mapboxgl-canvas {
            border-radius: 10px;
        }

        /* Accommodation card hover effect */
        .accomodation-item:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .col-lg-8, .col-lg-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            #map {
                height: 400px;
                margin-bottom: 30px;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- Mapbox GL JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

    <!-- jQuery and noUiSlider -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mapbox Access Token
            mapboxgl.accessToken = 'pk.eyJ1Ijoiam9lLWhhZGNoaXR5IiwiYSI6ImNtM2tnMnlkNTBnZHAybHFvaWc1azlndGkifQ.AVgrQqh2ce6MvMzUv4r6yQ';

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v11',
                center: [35.5, 33.9], // Center of Lebanon
                zoom: 8
            });

            map.addControl(new mapboxgl.NavigationControl());
            const accommodations = @json($accomodations);
            const markers = [];

            // Create markers with clustering
            const geojson = {
                type: 'FeatureCollection',
                features: accommodations.map(accommodation => ({
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [
                            parseFloat(accommodation.location.longitude),
                            parseFloat(accommodation.location.latitude)
                        ]
                    },
                    properties: {
                        id: accommodation.accomodationid,
                        description: accommodation.description,
                        city: accommodation.location.city,
                        price: accommodation.pricepernight,
                        type: accommodation.type.accomodationdesc,
                        amenities: accommodation.amenities ? accommodation.amenities.map(a => a.amenitydesc) : [],
                        rating: accommodation.rating,
                        guestcapacity: accommodation.guestcapacity,
                        image: accommodation.image ? JSON.parse(accommodation.image).url : 'default.jpg'
                    }
                }))
            };

            map.on('load', () => {
                map.addSource('accommodations', {
                    type: 'geojson',
                    data: geojson,
                    cluster: true,
                    clusterMaxZoom: 14,
                    clusterRadius: 50
                });

                // Cluster layers
                map.addLayer({
                    id: 'clusters',
                    type: 'circle',
                    source: 'accommodations',
                    filter: ['has', 'point_count'],
                    paint: {
                        'circle-color': [
                            'step',
                            ['get', 'point_count'],
                            '#00BCD4',
                            10,
                            '#2196F3',
                            30,
                            '#3F51B5'
                        ],
                        'circle-radius': [
                            'step',
                            ['get', 'point_count'],
                            15,
                            10,
                            20,
                            30,
                            25
                        ]
                    }
                });

                // Cluster count labels
                map.addLayer({
                    id: 'cluster-count',
                    type: 'symbol',
                    source: 'accommodations',
                    filter: ['has', 'point_count'],
                    layout: {
                        'text-field': '{point_count_abbreviated}',
                        'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                        'text-size': 14
                    },
                    paint: {
                        'text-color': '#FFFFFF'
                    }
                });

                // Unclustered points
                map.addLayer({
                    id: 'unclustered-point',
                    type: 'symbol',
                    source: 'accommodations',
                    filter: ['!', ['has', 'point_count']],
                    layout: {
                        'icon-image': 'lodging-15',
                        'icon-size': 1.5,
                        'text-field': '${price}',
                        'text-offset': [0, 1.5],
                        'text-anchor': 'top',
                        'text-size': 12
                    },
                    paint: {
                        'text-color': '#000000'
                    }
                });

                // Popup on click
                map.on('click', 'unclustered-point', (e) => {
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const properties = e.features[0].properties;
                    const popupContent = `
                        <div style="width: 200px;">
                            <img src="${properties.image}" alt="${properties.description}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 5px;">
                            <h6 class="mt-2">${properties.description}</h6>
                            <p class="mb-1"><i class="bi bi-geo-alt-fill me-1"></i>${properties.city}</p>
                            <p class="mb-1"><i class="bi bi-currency-dollar me-1"></i>${properties.price} per night</p>
                            <a href="/accomodations/${properties.id}" class="btn btn-sm btn-primary mt-2">View Details</a>
                        </div>
                    `;

                    new mapboxgl.Popup()
                        .setLngLat(coordinates)
                        .setHTML(popupContent)
                        .addTo(map);
                });

                // Zoom into cluster on click
                map.on('click', 'clusters', (e) => {
                    const features = map.queryRenderedFeatures(e.point, {
                        layers: ['clusters']
                    });
                    const clusterId = features[0].properties.cluster_id;
                    map.getSource('accommodations').getClusterExpansionZoom(clusterId, (err, zoom) => {
                        if (err) return;

                        map.easeTo({
                            center: features[0].geometry.coordinates,
                            zoom: zoom
                        });
                    });
                });

                // Change cursor to pointer on hover
                map.on('mouseenter', 'clusters', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });
                map.on('mouseleave', 'clusters', () => {
                    map.getCanvas().style.cursor = '';
                });
                map.on('mouseenter', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });
                map.on('mouseleave', 'unclustered-point', () => {
                    map.getCanvas().style.cursor = '';
                });
            });

            // Initialize price slider
            const slider = document.getElementById('priceRangeSlider');
            noUiSlider.create(slider, {
                start: [50, 500],
                connect: true,
                range: { 'min': 0, 'max': 1000 },
                tooltips: [true, true],
                format: {
                    to: value => `$${Math.round(value)}`,
                    from: value => Number(value.replace('$', ''))
                }
            });

            slider.noUiSlider.on('update', function (values) {
                $('#priceRange').val(`${values[0]} - ${values[1]}`);
            });

            // Function to filter accommodations
            function filterAccommodations() {
                const selectedType = $('#filterType').val();
                const priceRange = slider.noUiSlider.get().map(value => Number(value.replace('$', '')));
                const selectedAmenities = $('.filter-amenity:checked').map(function () {
                    return $(this).val();
                }).get();
                const guestCapacity = $('#guestCapacity').val();
                const rating = $('#rating').val();
                const bounds = map.getBounds();

                $('.accomodation-item').each(function () {
                    const item = $(this);
                    const typeMatch = selectedType ? item.data('type') === selectedType : true;
                    const priceMatch =
                        parseInt(item.data('price')) >= priceRange[0] &&
                        parseInt(item.data('price')) <= priceRange[1];
                    const itemAmenities = item.data('amenities') ? item.data('amenities').split(',') : [];
                    const amenitiesMatch = selectedAmenities.every(amenity => itemAmenities.includes(amenity));
                    const capacityMatch = guestCapacity ? item.data('capacity') >= guestCapacity : true;
                    const ratingMatch = rating ? item.data('rating') >= rating : true;
                    const lat = parseFloat(item.data('lat'));
                    const lng = parseFloat(item.data('lng'));
                    const isInBounds = bounds.contains([lng, lat]);

                    if (typeMatch && priceMatch && amenitiesMatch && capacityMatch && ratingMatch && isInBounds) {
                        item.show();
                    } else {
                        item.hide();
                    }
                });
            }

            // Apply filters when "Apply Filters" button is clicked
            $('#applyFilters').click(() => {
                filterAccommodations();
                $('#filterModal').modal('hide');
            });

            // Re-filter when the map is moved
            map.on('moveend', () => {
                // Update bounds input for sorting form
                const bounds = map.getBounds();
                const boundsData = JSON.stringify({
                    north: bounds.getNorthEast().lat,
                    south: bounds.getSouthWest().lat,
                    east: bounds.getNorthEast().lng,
                    west: bounds.getSouthWest().lng
                });
                document.getElementById('boundsInput').value = boundsData;

                // Filter accommodations client-side
                filterAccommodations();
            });

            // Filter when type buttons are clicked
            $('.filter-type-button').click(function () {
                const selectedType = $(this).data('type');
                $('#filterType').val(selectedType);
                filterAccommodations();
            });

            // Clear filters
            $('#clearFilters').click(() => {
                // Reset filters
                $('#filterType').val('');
                slider.noUiSlider.set([50, 500]);
                $('.filter-amenity').prop('checked', false);
                $('#guestCapacity').val('');
                $('#rating').val('');
                filterAccommodations();
            });

            // Initialize filtering on page load
            filterAccommodations();
        });
    </script>
@endpush
