<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Wishlist</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/wishlisthistory.css') }}">
</head>
<body>

<div class="container">
  <!-- Breadcrumb -->
  {{-- <div class="breadcrumb">
    Home / Wishlist
  </div> --}}

  <!-- Wishlist Header -->
  <div class="wishlist-header">
    <div class="icon">❤️</div>
    <h1>My Wishlist</h1>
  </div>

  <!-- Wishlist Table -->
  <table>
    <thead>
      <tr>
        <th>Accommodation</th>
        <th class="text-center">Price per night </th>
        <th class="text-center">Location</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- Loop through Wishlist Items -->
      @foreach ($bookings as $booking)
      <tr>
        <!-- Product Image & Name -->
        <td >
          {{-- <a href="{{ route('accomodations.show', ['id' => $booking->accomodationid]) }}"><img src="{{ $booking->accomodation->image ?: 'https://via.placeholder.com/60' }}" alt="Product Image" class="product-image"></a> --}}
          <a href="{{ route('accomodations.show', ['id' => $booking->accomodationid]) }}">
            @php
              // Decode the image JSON field to get the URL of the image
              $imageData = json_decode($booking->accomodation->image, true);
              // Get the image URL (use placeholder if not set)
              $imageUrl = $imageData['url'] ?? 'https://via.placeholder.com/60';
            @endphp
            <img src="{{ asset('images/' . $imageUrl) }}" alt="Accommodation Image" class="product-image">
          </a>
          <a href="{{ route('accomodations.show', ['id' => $booking->accomodationid]) }}"><span class="product-name" class="text-center">{{ $booking->accomodation->description ?: 'Product Name' }}</span></a>
        </td>
        
        <!-- Price/night -->
        <td class="text-center">
            ${{ $booking->accomodation->pricepernight }} 
        </td>
          
        
        <!-- Location -->
        <td class="text-center">
            <span class="location">{{ $booking->accomodation->location->city }}</span>
            {{-- <br> --}}
            {{-- <span class="added-date">Added on: {{ $booking->created_at->format('F d, Y') }}</span> --}}
        </td>
  
        
        <!-- Action -->
        <td class="text-center">
          <form action="#" method="POST">
            @csrf
            <button type="submit" class="action-btn">Add to Cart</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
