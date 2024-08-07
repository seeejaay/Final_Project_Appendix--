<?php include '../assets/resources/addBooking.php' ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking | Timless Elegance</title>

    <link rel="stylesheet" href="../assets/CSS/header.css">
    <link rel="stylesheet" href="../assets/CSS/booking.css">
    <link rel="stylesheet" href="../assets/CSS/footer.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar FOR ALL-->
    <?php include '../assets/resources/header2.php'; ?>

    <main class="container-wrapper">
        <div class="top">
            <div class="title">
                <h1>Booking</h1>
            </div>
        </div>
        <section class="booking">
            <div class="booking-info">
                <h2>Book Your Stay</h2>
                <p>Fill in the form and we'll get back to you shortly.</p>
                <div class="booking-form">
                    <form action="booking.php" method="POST" id="bookingForm">
                        <div class="date-fields row mb-3">
                            <div class="form-group col-md-6">
                                <label for="checkin">Check-in Date</label>
                                <input type="date" class="form-control" id="checkin" name="checkin" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="checkout">Check-out Date</label>
                                <input type="date" class="form-control" id="checkout" name="checkout" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="numDays">Number of Days</label>
                            <input type="text" class="form-control" id="numDays" name="numDays" readonly>
                        </div>
                        <div class="date-fields row mb-2">
                            <div class="form-group col-md-6">
                                <label for="checkInTime">Check In Time</label>
                                <input type="text" class="form-control small" id="checkInTime" name="checkInTime" value="10:00 A.M." readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="checkOutTime">Check Out Time</label>
                                <input type="text" class="form-control small" id="checkOutTime" name="checkOutTime" value="10:00 A.M." readonly>
                            </div>
                        </div>
                        <div class="date-fields row mb-2">
                            <div class="form-group col-md-5"> <!-- Adjusted from col-md-5 to col-md-6 -->
                                <label for="room">Room Type</label>
                                <select class="form-control" id="room" name="room" required>
                                    <option value="standard">Standard</option>
                                    <option value="deluxe">Deluxe</option>
                                    <option value="premium">Premium</option>
                                    <option value="executive">Executive</option>
                                </select>
                            </div>
                            <div class="form-group col-md-7"> <!-- Adjusted from col-md-8 to col-md-6 -->
                                <label for="payment">Mode of Payment</label>
                                <select class="form-control" id="payment" name="payment" required>
                                    <option value="paypal">PayPal</option>
                                    <option value="credit">Credit Card</option>
                                    <option value="debit">Debit Card</option>
                                </select>
                            </div>
                        </div>

                        <div id="cardFields" style="display: none;">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <input type="number" class="form-control" id="cardNumber" name="cardNumber" required minlength="16" maxlength="16">
                            </div>
                            <div class="form-group">
                                <label for="expiry">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry" name="expiry" required>
                            </div>
                            <div class="form-group">
                                <label for="securityCode">Security Code</label>
                                <input type="number" class="form-control" id="securityCode" name="securityCode" required min="100" max="999">
                            </div>
                        </div>

                        <div id="paypalFields" style="display: none;">
                            <div class="form-group mt-5">
                                <label for="paypalEmail">PayPal Email</label>
                                <input type="email" class="form-control" id="paypalEmail" name="paypalEmail">
                            </div>
                        </div>

                        <button class="btn-custom" id="btn-submit" data-bs-toggle="modal" data-bs-target="#confirmationModal">Submit</button>


                        <!-- Confirmation Modal -->

                        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Booking Details:</h5>
                                        <p>Check-in Date: <span id="checkInDay"></span></p>
                                        <p>Check-out Date: <span id="checkoutDay"></span></p>
                                        <p>Number of Days: <span id="numOfDays"></span></p>
                                        <p>Room Type: <span id="roomType"></span></p>
                                        <p>Mode of Payment: <span id="paymentMethod"></span></p>
                                        <p>Total Price: <span id="totalPrice"></span></p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-custom" id="closeModal" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn-custom" id="btn-confirm">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Booking Success</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Your booking has been successfully completed!</p>
                                        <p>Transaction ID: <span id="transactionID"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="successOkButton">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation Modal -->
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="footer-logo" src="../assets/images/logo_bg.png" alt="Logo">
                    <ul>
                        <li style="list-style:none; text-decoration:none;"><a href="../admin/admin.php">ADMIN</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Contact Us</h3>
                    <p>123 Main Street, City, Country</p>
                    <p>Email: info@example.com</p>
                    <p>Phone: +1 123 456 7890</p>
                </div>
                <div class="col-md-4">
                    <h3>Follow Us</h3>
                    <ul class="social-media">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb5g6bRVt/vp5oVhBfiIsZnFjzSKX8vNbw5P1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../assets/JS/booking.js"></script>

</body>

</html>