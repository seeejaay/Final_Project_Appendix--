document.addEventListener('DOMContentLoaded', function() {
    var checkin = document.getElementById('checkin');
    var checkout = document.getElementById('checkout');
    var numDays = document.getElementById('numDays');
    var numDaysValue = 0;

    checkin.addEventListener('change', computeNumDays);
    checkout.addEventListener('change', computeNumDays);

    function computeNumDays() {
        var startDate = new Date(checkin.value);
        var endDate = new Date(checkout.value);
        if (startDate && endDate && startDate < endDate) {
            var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
            numDaysValue = Math.ceil(timeDiff / (1000 * 3600 * 24));
            numDays.value = numDaysValue;
            console.log(numDaysValue);
        } else {
            numDays.value = '';
        }
    }

    var today = new Date();
    var defaultCheckinTime = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
    var defaultCheckoutTime = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 2);

    checkin.value = defaultCheckinTime.toISOString().slice(0, 10);
    checkout.value = defaultCheckoutTime.toISOString().slice(0, 10);
    computeNumDays();

    window.showSuccessModal = function(transactionID) {
        document.getElementById('transactionID').innerText = transactionID;
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    }

    var payment = document.getElementById('payment');
    var cardFields = document.getElementById('cardFields');
    var paypalFields = document.getElementById('paypalFields');
    var paypalEmail = document.getElementById('paypalEmail');

    function togglePaymentFields() {
        if (payment.value === 'credit' || payment.value === 'debit') {
            cardFields.style.display = 'block';
            paypalFields.style.display = 'none';
            setRequiredFields(cardFields, true);
            paypalEmail.required = false;
        } else if (payment.value === 'paypal') {
            cardFields.style.display = 'none';
            paypalFields.style.display = 'block';
            setRequiredFields(cardFields, false);
            paypalEmail.required = true;
        } else {
            cardFields.style.display = 'none';
            paypalFields.style.display = 'none';
            setRequiredFields(cardFields, false);
            paypalEmail.required = false;
        }
    }

    function setRequiredFields(container, required) {
        var fields = container.querySelectorAll('input');
        fields.forEach(function(field) {
            field.required = required;
        });
    }

    togglePaymentFields();
    payment.addEventListener('change', togglePaymentFields);

    const bookingForm = document.getElementById('bookingForm');
    const submitButton = document.querySelector('#btn-submit');
    const confirmButton = document.querySelector('#btn-confirm');
    const closeModal = document.querySelector('#closeModal');
    const successOkButton = document.querySelector('#successOkButton');

    const room = document.querySelector('#room');
    const checkInDay = document.querySelector('#checkInDay');
    const checkoutDay = document.querySelector('#checkoutDay');
    const numOfDays = document.querySelector('#numOfDays');
    const roomType = document.querySelector('#roomType');
    const paymentMethod = document.querySelector("#paymentMethod");
    const totalPrice = document.querySelector("#totalPrice");
    var price = 0;

    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        const room = document.querySelector('#room').value;

        switch (room) {
            case 'standard':
                price = 500;
                break;
            case 'deluxe':
                price = 800;
                break;
            case 'premium':
                price = 1200;
                break;
            case 'executive':
                price = 1900;
                break;
        }

        var product = numDaysValue * price;

        checkInDay.innerHTML = checkin.value;
        checkoutDay.innerHTML = checkout.value;
        numOfDays.innerHTML = numDaysValue.toString();
        roomType.innerHTML = room.toUpperCase();
        paymentMethod.innerHTML = payment.value;
        totalPrice.textContent = product;

        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();
    });

    closeModal.addEventListener('click', function() {
        const confirmationModal = document.getElementById('confirmationModal');
        const modalBackdrop = document.querySelector('.modal-backdrop');
        if (modalBackdrop) {
            modalBackdrop.remove();
        }
        confirmationModal.classList.remove('show');
    });

    confirmButton.addEventListener('click', function() {
        bookingForm.submit();
    });

    successOkButton.addEventListener('click', function() {
        window.location.href = 'booking.php';
    });
});
