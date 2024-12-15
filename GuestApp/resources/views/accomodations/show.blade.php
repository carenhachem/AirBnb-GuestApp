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
    </style>
@endpush

@section('content')
    <div class="container">
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
                    <form id="reservationForm" action="{{ route('payment.show') }}" method="GET">
                        @csrf
                        <div class="mb-3">
                            <label for="reservationDates" class="form-label">Select Dates</label>
                            <input type="text" id="reservationDates" class="form-control" placeholder="Check-in - Check-out" readonly required>
                            <input type="hidden" name="checkin" id="checkin">
                            <input type="hidden" name="checkout" id="checkout">
                            <input type="hidden" name="accomodation_id" id ="accomodation_id" value="{{ $accomodation->accomodationid }}">
                            <input type="hidden" name="accomodation_name" id="accomodation_name" value="{{ $accomodation->description }}">
                            <input type="hidden" name="accommodation_locationid" id="accommodation_locationid" value="{{ $accomodation->locationid }}">
                            <input type="hidden" name="pricepernight" id ="pricepernight" value="{{ $accomodation->pricepernight }}">
                            <input type="hidden" name="totalPrice" id="totalPrice">
                        </div>
                        <div class="mb-3">
                            <p><strong>Total Price:</strong> <span id="totalPriceCalculated">$0</span></p>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('accomodations.index') }}" class="btn btn-outline-secondary">Back to List</a>
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
                            document.getElementById('totalPriceCalculated').innerText = '$' + totalPrice;
                            document.getElementById('totalPrice').value = totalPrice;
                                  


                        }
                    });
                }
            });
        });
    </script>
@endpush
