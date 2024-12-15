<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing and Payment</title>
    
    <!-- Link to the CSS file -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    </head>
<body>

    <div class="container">

       <form method="get" action="{{Route('payment.receipt')}}">    

            <div class="row">

                <div class="col">
                    <h3 class="title">Billing Address</h3>

                      <input type="hidden" name="checkin" value="{{ old('checkin', request('checkin')) }}">
            <input type="hidden" name="checkout" value="{{ old('checkout', request('checkout')) }}">
            <input type="hidden" name="accomodation_id" value="{{ old('accomodation_id', request('accomodation_id')) }}">
            <input type="hidden" name="accomodation_name" value="{{ old('accomodation_name', request('accomodation_name')) }}">
            <input type="hidden" name="pricepernight" value="{{ old('pricepernight', request('pricepernight')) }}">
            <input type="hidden" name="totalPrice" value="{{ old('totalPrice', request('totalPrice')) }}">
            <input type="hidden" name="accommodation_locationid" value="{{ old('accommodation_locationid', request('accommodation_locationid')) }}">


                    <div class="inputBox">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="inputBox">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" placeholder="Enter email address" required>
                    </div>

                    <div class="inputBox">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" placeholder="Enter address" required>
                    </div>

                    <div class="inputBox">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" placeholder="Enter city" required>
                    </div>

                    <div class="flex">

                        <div class="inputBox">
                            <label for="state">State:</label>
                            <input type="text" id="state" name="state" placeholder="Enter state" required>
                        </div>

                        <div class="inputBox">
                            <label for="zip">Zip Code:</label>
                            <input type="number" id="zip" name= "zipcode" placeholder="123 456" required>
                        </div>

                    </div>

                </div>
                <div class="col">
                    <h3 class="title">Payment</h3>

                    <div class="inputBox">
                        <label for="name">Card Accepted:</label>
                        <img src="https://i.ibb.co/X38b5PF/card-img.png" alt="">
                    </div>

                    <div class="inputBox">
                        <label for="cardName">Name On Card:</label>
                        <input type="text" id="cardName" name="nameoncard" placeholder="Enter card name" required>
                    </div>


                    <div class="inputBox">
                    <label for="cardNum">Credit Card Number:</label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="cardNum" 
                            name="creditcardnumber" 
                            placeholder="1111-2222-3333-4444" 
                            maxlength="19" 
                            required
                            style="padding-right: 40px;"
                        >
                        <button 
                            type="button" 
                            id="toggleCardNum" 
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                            👁️
                        </button>
                    </div>
                </div>

                    <div class="inputBox">
                        <label for="">Exp Month:</label>
                        <select name="expmonth" id="">
                            <option value="">Choose month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                    <div class="flex">
                        <div class="inputBox">
                            <label for="">Exp Year:</label>
                            <select name="expyear" id="">
                                <option value="">Choose Year</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <label for="cvv">CVV</label>
                            <input type="number" id="cvv" name="cvv" placeholder="1234" required>
                        </div>
                    </div>

                </div>

            </div>

            <input type="submit" value="Proceed to Checkout" class="submit_btn">
        </form>

    </div>

    <!-- Link to the JS file -->
    <script src="{{ asset('../public/js/payment.js') }}"></script>
</body>
</html>

<script>
    document.getElementById('toggleCardNum').addEventListener('click', function () {
        const cardNumInput = document.getElementById('cardNum');
        if (cardNumInput.type === 'password') {
            cardNumInput.type = 'text';
            this.textContent = '🙈'; // Change to a closed eye icon
        } else {
            cardNumInput.type = 'password';
            this.textContent = '👁️'; // Change back to an open eye icon
        }
    });
</script>
