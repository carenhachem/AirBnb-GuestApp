<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Payment Method</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS (place this in resources/css/styles.css) -->
    <link href="{{ asset('../public/css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Choose a Payment Method</h2>

        <!-- Pay Now Button -->
        <button type="button" class="btn btn-primary launch" data-toggle="modal" data-target="#staticBackdrop">
            <i class="fa fa-rocket"></i> Pay Now
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-right">
                            <i class="fa fa-close close" data-dismiss="modal"></i>
                        </div>
                        <div class="tabs mt-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="visa-tab" data-toggle="tab" href="#visa" role="tab" aria-controls="visa" aria-selected="true">
                                        <img src="{{ asset('images/visa.png') }}" width="80">
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">
                                        <img src="{{ asset('images/paypal.png') }}" width="80">
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                                    <div class="mt-4 mx-4">
                                        <div class="text-center">
                                            <h5>Credit card</h5>
                                        </div>
                                        <div class="form mt-3">
                                            <div class="inputbox">
                                                <input type="text" name="name" class="form-control" required="required">
                                                <span>Cardholder Name</span>
                                            </div>
                                            <div class="inputbox">
                                                <input type="text" name="name" min="1" max="999" class="form-control" required="required">
                                                <span>Card Number</span>
                                                <i class="fa fa-eye"></i>
                                            </div>
                                            <div class="d-flex flex-row">
                                                <div class="inputbox">
                                                    <input type="text" name="name" min="1" max="999" class="form-control" required="required">
                                                    <span>Expiration Date</span>
                                                </div>
                                                <div class="inputbox">
                                                    <input type="text" name="name" min="1" max="999" class="form-control" required="required">
                                                    <span>CVV</span>
                                                </div>
                                            </div>
                                            <div class="px-5 pay">
                                                <button class="btn btn-success btn-block">Add card</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                                    <div class="px-5 mt-5">
                                        <div class="inputbox">
                                            <input type="text" name="name" class="form-control" required="required">
                                            <span>Paypal Email Address</span>
                                        </div>
                                        <div class="pay px-5">
                                            <button class="btn btn-primary btn-block">Add paypal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
