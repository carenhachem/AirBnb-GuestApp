@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="container-fluid bg-light py-5 mb-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Find Your Perfect Stay</h1>
            <p class="lead">Discover amazing accommodations across Lebanon</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container mb-4">
        <form method="GET" action="{{ route('accomodations.index') }}" class="row g-2" id="searchForm">
            <!-- Preserve existing filters as hidden fields -->
            <input type="hidden" name="bounds" id="boundsInput" value="{{ request('bounds') }}">
            <input type="hidden" name="checkin" value="{{ request('checkin') }}">
            <input type="hidden" name="checkout" value="{{ request('checkout') }}">
            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <input type="hidden" name="guestCapacity" value="{{ request('guestCapacity') }}">
            <input type="hidden" name="rating" value="{{ request('rating') }}">

            @if(is_array(request('amenities')))
                @foreach(request('amenities') as $amenity)
                    <input type="hidden" name="amenities[]" value="{{ $amenity }}">
                @endforeach
            @endif

            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Search by keyword..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="city" class="form-control" placeholder="Search by city..." value="{{ request('city') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary w-100" id="clearMainSearch">Clear</button>
            </div>
        </form>
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

    <!-- Sorting and Filter Form -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <form method="GET" action="{{ route('accomodations.index') }}" id="filterForm" class="d-flex gap-2">
                <!-- Hidden Inputs for Filters -->
                <input type="hidden" name="bounds" id="boundsInput" value="{{ request('bounds') }}">
                <input type="hidden" name="checkin" id="checkinInput" value="{{ request('checkin') }}">
                <input type="hidden" name="checkout" id="checkoutInput" value="{{ request('checkout') }}">
                <input type="hidden" name="min_price" id="minPriceInput" value="{{ request('min_price') }}">
                <input type="hidden" name="max_price" id="maxPriceInput" value="{{ request('max_price') }}">
                <input type="hidden" name="type" id="typeInput" value="{{ request('type') }}">
                <input type="hidden" name="guestCapacity" id="guestCapacityInput" value="{{ request('guestCapacity') }}">
                <input type="hidden" name="rating" id="ratingInput" value="{{ request('rating') }}">
                <input type="hidden" name="keyword" id="keywordInput" value="{{ request('keyword') }}">
                <input type="hidden" name="city" id="cityInput" value="{{ request('city') }}">

                @php
                    $currentAmenities = request('amenities', []);
                    if(!is_array($currentAmenities)) {
                        $currentAmenities = [$currentAmenities];
                    }
                @endphp
                <div id="amenitiesContainer" style="display:none;">
                    @foreach($currentAmenities as $amenity)
                        <input type="hidden" name="amenities[]" value="{{ $amenity }}">
                    @endforeach
                </div>

                <!-- Sorting Dropdown -->
                <select name="sort_by" class="form-select">
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
            <!-- Accommodation Cards Container -->
            <div class="col-lg-8 mb-5" id="listing-container" style="position: relative;">
                <!-- Loader specifically for listing -->
                <div id="listing-loader" style="display:none; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.7); z-index:999; display:flex; align-items:center; justify-content:center;">
                    <div class="loader-spinner"></div>
                </div>

                @include('accomodations.partials._list', ['accomodations' => $accomodations, 'wishlistItems' => $wishlistItems])
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
                            <label for="keyword" class="form-label">Keyword</label>
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="e.g. Beirut, Cozy, Apartment" value="{{ request('keyword') }}">
                        </div>
                        <div class="mb-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="e.g. Beirut" value="{{ request('city') }}">
                        </div>

                        <div class="mb-4">
                            <label for="checkin" class="form-label">Check-in Date</label>
                            <input type="date" id="checkin" name="checkin" class="form-control" value="{{ request('checkin') }}">
                        </div>
                        <div class="mb-4">
                            <label for="checkout" class="form-label">Check-out Date</label>
                            <input type="date" id="checkout" name="checkout" class="form-control" value="{{ request('checkout') }}">
                        </div>

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
                                        <input class="form-check-input filter-amenity" type="checkbox" value="{{ $amenity->amenitydesc }}" id="amenity-{{ $amenity->amenitydesc }}" {{ in_array($amenity->amenitydesc, $currentAmenities) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity-{{ $amenity->amenitydesc }}">
                                            {{ $amenity->amenitydesc }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="guestCapacity" class="form-label">Guest Capacity</label>
                            <input type="number" id="guestCapacity" class="form-control" placeholder="Number of guests" value="{{ request('guestCapacity') }}">
                        </div>
                        <div class="mb-4">
                            <label for="rating" class="form-label">Minimum Rating</label>
                            <select id="rating" class="form-select">
                                <option value="">Any Rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
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

    <style>
        .loader-spinner {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 80px; height: 80px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

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

        #map .mapboxgl-canvas {
            border-radius: 10px;
        }

        .accomodation-item:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

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

    <!-- noUiSlider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>

    <script>
        let map;

        $(document).ready(function() {
            // Mapbox Access Token
            mapboxgl.accessToken = 'pk.eyJ1Ijoiam9lLWhhZGNoaXR5IiwiYSI6ImNtM2tnMnlkNTBnZHAybHFvaWc1azlndGkifQ.AVgrQqh2ce6MvMzUv4r6yQ';

            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/light-v11',
                center: [35.5, 33.9],
                zoom: 8
            });

            map.addControl(new mapboxgl.NavigationControl());

            const filterForm = document.getElementById('filterForm');

            function showListingLoader() {
                $('#listing-loader').show();
            }

            function hideListingLoader() {
                $('#listing-loader').hide();
            }

            function rebuildMapData() {
                const features = [];
                $('#listing-container .accomodation-item').each(function() {
                    const lat = parseFloat($(this).data('lat'));
                    const lng = parseFloat($(this).data('lng'));
                    const price = $(this).data('price');
                    const description = $(this).find('.card-title').text().trim();
                    const city = $(this).find('.bi-geo-alt-fill').parent().text().trim();
                    const detailLink = $(this).find('a.btn-outline-primary').attr('href');
                    const id = detailLink ? detailLink.split('/').pop() : null;
                    const image = $(this).find('img.card-img-top').attr('src');

                    if (!isNaN(lat) && !isNaN(lng)) {
                        features.push({
                            type: 'Feature',
                            geometry: {
                                type: 'Point',
                                coordinates: [lng, lat]
                            },
                            properties: {
                                id: id,
                                description: description,
                                city: city,
                                price: price,
                                image: image
                            }
                        });
                    }
                });

                const geojson = {
                    type: 'FeatureCollection',
                    features: features
                };

                if (map.getSource('accommodations')) {
                    map.getSource('accommodations').setData(geojson);
                } else {
                    map.addSource('accommodations', {
                        type: 'geojson',
                        data: geojson,
                        cluster: true,
                        clusterMaxZoom: 14,
                        clusterRadius: 50
                    });

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

                    map.on('click', 'clusters', (e) => {
                        const features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
                        const clusterId = features[0].properties.cluster_id;
                        map.getSource('accommodations').getClusterExpansionZoom(clusterId, (err, zoom) => {
                            if (err) return;
                            map.easeTo({ center: features[0].geometry.coordinates, zoom: zoom });
                        });
                    });

                    map.on('mouseenter', 'clusters', () => { map.getCanvas().style.cursor = 'pointer'; });
                    map.on('mouseleave', 'clusters', () => { map.getCanvas().style.cursor = ''; });
                    map.on('mouseenter', 'unclustered-point', () => { map.getCanvas().style.cursor = 'pointer'; });
                    map.on('mouseleave', 'unclustered-point', () => { map.getCanvas().style.cursor = ''; });
                }
            }

            map.on('load', () => {
                rebuildMapData();
            });

            function loadListings(url) {
                showListingLoader();
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: $(filterForm).serialize(),
                    success: function(data) {
                        $('#listing-container').html(data);

                        // Re-inject the loader after updating the content
                        $('#listing-container').css('position', 'relative').append(`
                            <div id="listing-loader" style="display:none; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.7); z-index:999; display:flex; align-items:center; justify-content:center;">
                                <div class="loader-spinner"></div>
                            </div>
                        `);

                        attachPaginationLinks();
                        rebuildMapData();
                    },
                    complete: function() {
                        hideListingLoader();
                    }
                });
            }

            function attachPaginationLinks() {
                $('#listing-container').find('.pagination a').on('click', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    loadListings(url);
                });
            }

            attachPaginationLinks();

            const slider = document.getElementById('priceRangeSlider');
            noUiSlider.create(slider, {
                start: [
                    {{ request('min_price', 50) }},
                    {{ request('max_price', 500) }}
                ],
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

            $('#applyFilters').on('click', function() {
                const checkin = $('#checkin').val();
                const checkout = $('#checkout').val();
                const selectedType = $('#filterType').val();
                const priceValues = slider.noUiSlider.get().map(value => Number(value.replace('$', '')));
                const selectedAmenities = $('.filter-amenity:checked').map(function () {
                    return $(this).val();
                }).get();
                const guestCapacity = $('#guestCapacity').val();
                const rating = $('#rating').val();
                const keyword = $('#keyword').val();
                const city = $('#city').val();

                $('#checkinInput').val(checkin);
                $('#checkoutInput').val(checkout);
                $('#typeInput').val(selectedType);
                $('#minPriceInput').val(priceValues[0]);
                $('#maxPriceInput').val(priceValues[1]);
                $('#guestCapacityInput').val(guestCapacity);
                $('#ratingInput').val(rating);
                $('#keywordInput').val(keyword);
                $('#cityInput').val(city);

                $('#amenitiesContainer').empty();
                selectedAmenities.forEach(a => {
                    $('#amenitiesContainer').append(`<input type="hidden" name="amenities[]" value="${a}">`);
                });

                $('#filterModal').modal('hide');
                loadListings('{{ route('accomodations.index') }}');
            });

            $('#clearFilters').on('click', function() {
                $('#checkinInput').val('');
                $('#checkoutInput').val('');
                $('#typeInput').val('');
                $('#minPriceInput').val('');
                $('#maxPriceInput').val('');
                $('#guestCapacityInput').val('');
                $('#ratingInput').val('');
                $('#keywordInput').val('');
                $('#cityInput').val('');
                $('#amenitiesContainer').empty();
                slider.noUiSlider.set([50, 500]);
                loadListings('{{ route('accomodations.index') }}');
            });

            $('select[name="sort_by"]').on('change', function() {
                loadListings('{{ route('accomodations.index') }}');
            });

            $('.filter-type-button').on('click', function() {
                const selectedType = $(this).data('type');
                $('#typeInput').val(selectedType);
                loadListings('{{ route('accomodations.index') }}');
            });

            map.on('moveend', function() {
                const bounds = map.getBounds();
                const boundsData = JSON.stringify({
                    north: bounds.getNorthEast().lat,
                    south: bounds.getSouthWest().lat,
                    east: bounds.getNorthEast().lng,
                    west: bounds.getSouthWest().lng
                });
                $('#boundsInput').val(boundsData);
                loadListings('{{ route('accomodations.index') }}');
            });

            // Clear main search bar (keyword and city)
            $('#clearMainSearch').on('click', function() {
                $('input[name="keyword"]').val('');
                $('input[name="city"]').val('');
                $('#searchForm').submit();
            });
        });
    </script>
@endpush
