@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        .litepicker {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }
        .litepicker .container__months {
            display: flex;
            gap: 20px;
        }
        .litepicker .month-item {
            width: 100%;
        }
        .litepicker .month-item .month-item-header {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
        .litepicker .day-item:hover, .litepicker .day-item.selected {
            background-color: #007bff;
            color: #fff;
        }
        .litepicker .day-item.is-disabled {
            color: #ccc;
            cursor: not-allowed;
            background-color: #f8f9fa;
        }
        .review-rating {
            display: inline-block;
            float: right;
            text-align: right;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="mt-4">
            <a href="{{ route('accomodations.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>

        <h1 class="mt-4">{{ $accomodation->description }}</h1>
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <p><strong>Price:</strong> ${{ $accomodation->pricepernight }} per night</p>
                    <p><strong>Location:</strong> {{ $accomodation->location->city }}</p>
                    <p><strong>Type:</strong> {{ $accomodation->type->accomodationdesc }}</p>
                    <p><strong>Capacity:</strong> {{ $accomodation->guestcapacity }} guests</p>
                    <p><strong>Rating:</strong> {{ $accomodation->rating }} stars</p>
                </div>
                <div class="mb-3">
                    <h4>Amenities</h4>
                    <ul class="list-inline">
                        @foreach ($accomodation->amenities as $amenity)
                            <li class="list-inline-item badge bg-secondary me-1">{{ $amenity->amenitydesc }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h4 class="card-title">Reserve Your Stay</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form id="reservationForm" action="{{ route('reservations.store', $accomodation->accomodationid) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reservationDates" class="form-label">Select Dates</label>
                            <input type="text" id="reservationDates" class="form-control" placeholder="Check-in - Check-out" readonly required>
                            <input type="hidden" name="checkin" id="checkin">
                            <input type="hidden" name="checkout" id="checkout">
                        </div>
                        <div class="mb-3">
                            <p><strong>Total Price:</strong> <span id="totalPrice">$0</span></p>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-4">
            <h4>Reviews</h4>
            @if ($accomodation->reviews && $accomodation->reviews->isNotEmpty())
                @foreach ($accomodation->reviews as $review)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <strong>{{ $review->user->username }}</strong>
                            <span class="review-rating float-end">
                                @for ($i = 0; $i < floor($review->rating); $i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor
                                @if ($review->rating - floor($review->rating) > 0)
                                    <i class="fa fa-star-half-alt text-warning"></i>
                                @endif
                                @for ($i = ceil($review->rating); $i < 5; $i++)
                                    <i class="fa fa-star text-muted"></i>
                                @endfor
                            </span>                    
                            <p class="mt-2">{{ $review->review }}</p>
                            <small class="text-muted"> Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No reviews yet. Be the first to leave one!</p>
            @endif
        </div>

        <div class="card shadow-sm p-3 mt-4">
            <h4 class="card-title">Add a Review</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ route('reviews.store', $accomodation->accomodationid) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select id="rating" name="rating" class="form-select" required>
                        <option value="" disabled selected>Select Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} stars</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea id="comment" name="review" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary submit-review-btn" style="background-color: #ccc; width: 150px; margin: 0 auto; display: block;">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unavailableDates = @json($unavailableDates);

            const picker = new Litepicker({
                element: document.getElementById('reservationDates'),
                singleMode: false,
                numberOfMonths: 2,
                numberOfColumns: 2,
                format: 'YYYY-MM-DD',
                minDate: new Date(),
                autoApply: true,
                lockDays: unavailableDates,
                lockDaysFilter: (date) => {
                    return unavailableDates.includes(date.format('YYYY-MM-DD'));
                },
                tooltipText: {
                    one: 'night',
                    other: 'nights'
                },
                tooltipNumber: (totalDays) => {
                    return totalDays - 1;
                },
                setup: (picker) => {
                    picker.on('selected', (date1, date2) => {
                        if (date1 && date2) {
                            document.getElementById('checkin').value = date1.format('YYYY-MM-DD');
                            document.getElementById('checkout').value = date2.format('YYYY-MM-DD');

                            // Calculate total price
                            const oneDay = 24 * 60 * 60 * 1000;
                            const diffDays = Math.round(Math.abs((date2.dateInstance - date1.dateInstance) / oneDay));

                            const totalPrice = diffDays * {{ $accomodation->pricepernight }};
                            document.getElementById('totalPrice').innerText = '$' + totalPrice;
                        }
                    });
                }
            });
        });
    </script>
@endpush
