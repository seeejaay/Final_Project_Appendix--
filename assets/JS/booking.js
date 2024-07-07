document.addEventListener('DOMContentLoaded', function() {
    var checkin = document.getElementById('checkin');
    var checkout = document.getElementById('checkout');
    var numDays = document.getElementById('numDays');

    checkin.addEventListener('change', computeNumDays);
    checkout.addEventListener('change', computeNumDays);

    function computeNumDays() {
        var startDate = new Date(checkin.value);
        var endDate = new Date(checkout.value);
        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
        var numDaysValue = Math.ceil(timeDiff / (1000 * 3600 * 24));
        numDays.value = numDaysValue;
    }

    // Set default check-in and check-out times
    var today = new Date();
    var defaultCheckinTime = new Date(today.getFullYear(), today.getMonth(), today.getDate(), 10, 0, 0);
    var defaultCheckoutTime = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1, 10, 0, 0);
    checkin.valueAsDate = defaultCheckinTime;
    checkout.valueAsDate = defaultCheckoutTime;

    var payment = document.getElementById('payment');
    var cardFields = document.getElementById('cardFields');
    var paypalFields = document.getElementById('paypalFields');

    if (payment.value === 'credit' || payment.value === 'debit') {
        cardFields.style.display = 'block';
        paypalFields.style.display = 'none';
    } else if (payment.value === 'paypal') {
        cardFields.style.display = 'none';
        paypalFields.style.display = 'block';
    } else {
        cardFields.style.display = 'none';
        paypalFields.style.display = 'none';
    }

    payment.addEventListener('change', function() {
        if (this.value === 'credit' || this.value === 'debit') {
            cardFields.style.display = 'block';
            paypalFields.style.display = 'none';
        } else if (this.value === 'paypal') {
            cardFields.style.display = 'none';
            paypalFields.style.display = 'block';
        } else {
            cardFields.style.display = 'none';
            paypalFields.style.display = 'none';
        }
    });
});


    