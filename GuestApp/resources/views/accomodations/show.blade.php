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
        .litepicker .day-item.disabled {
            color: #ccc;
            cursor: not-allowed;
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
                    <form id="reservationForm">
                        <div class="mb-3">
                            <label for="reservationDates" class="form-label">Select Dates</label>
                            <input type="text" id="reservationDates" class="form-control" placeholder="Check-in - Check-out" readonly>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary">Book Now</button>
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
            const picker = new Litepicker({
                element: document.getElementById('reservationDates'),
                singleMode: false,
                numberOfMonths: 2,
                numberOfColumns: 2,
                format: 'YYYY-MM-DD',
                minDate: new Date(),
                autoApply: true,
                tooltipText: {
                    one: 'night',
                    other: 'nights'
                },
                tooltipNumber: (totalDays) => {
                    return totalDays - 1;
                },
                setup: (picker) => {
                    picker.on('selected', (date1, date2) => {
                       
                    });
                }
            });
        });
    </script>
@endpush
