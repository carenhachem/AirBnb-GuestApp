<div class="row" id="accomodation-list">
    @forelse ($accomodations as $accomodation)
        @php
            $isInWishlist = Auth::check() && in_array($accomodation->accomodationid, $wishlistItems ?? []);
        @endphp

        <div class="col-md-6 mb-4 accomodation-item"
             data-type="{{ $accomodation->type->accomodationdesc ?? 'Unknown' }}"
             data-price="{{ $accomodation->pricepernight }}"
             data-amenities="{{ implode(',', $accomodation->amenities->pluck('amenitydesc')->toArray()) }}"
             data-lat="{{ $accomodation->location->latitude ?? '0' }}"
             data-lng="{{ $accomodation->location->longitude ?? '0' }}"
             data-rating="{{ $accomodation->rating }}"
             data-capacity="{{ $accomodation->guestcapacity }}"
             data-accomodationid="{{ $accomodation->accomodationid }}">
            <div class="card h-100 shadow-sm position-relative">
                <!-- Heart Button -->
                <button type="button" class="wishlist-btn btn btn-link p-0 position-absolute top-0 end-0 m-2">
                    @if($isInWishlist)
                        <i class="bi bi-heart-fill text-danger fs-4"></i>
                    @else
                        <i class="bi bi-heart text-danger fs-4"></i>
                    @endif
                </button>
                
                <img src="{{ $accomodation->image ? json_decode($accomodation->image)->url : 'default.jpg' }}"
                     class="card-img-top" 
                     alt="{{ $accomodation->description }}" 
                     style="height: 200px; object-fit: cover;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $accomodation->description }}</h5>
                    <p class="card-text text-muted">
                        <i class="bi bi-house-door-fill me-1"></i>{{ $accomodation->type->accomodationdesc ?? 'N/A' }}<br>
                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $accomodation->location->city ?? 'N/A' }}<br>
                        <i class="bi bi-people-fill me-1"></i>{{ $accomodation->guestcapacity }} guests<br>
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

@if($accomodations->hasPages())
    <nav class="d-flex justify-content-center mt-4" aria-label="Accommodations pagination">
        {{ $accomodations->appends(request()->all())->links('pagination::bootstrap-5') }}
    </nav>
@endif

@push('scripts')
<script>
$(document).ready(function() {
    // Event delegation for AJAX-updated content
    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();

        let button = $(this);
        let parentCard = button.closest('.accomodation-item');
        let accomodationId = parentCard.data('accomodationid');

        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ accomodationid: accomodationId })
        })
        .then(response => {
            if (response.status === 401) {
                // Not logged in, redirect to login
                window.location.href = '{{ route('login') }}';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && (data.status === 'added' || data.status === 'removed')) {
                let icon = button.find('i');
                if (data.status === 'added') {
                    icon.removeClass('bi-heart').addClass('bi-heart-fill');
                } else {
                    icon.removeClass('bi-heart-fill').addClass('bi-heart');
                }
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>
@endpush
