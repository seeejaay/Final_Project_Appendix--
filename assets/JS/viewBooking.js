document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-booking').forEach(function (element) {
        element.addEventListener('click', function () {
            const row = this.closest('tr');
            const checkInDate = row.dataset.checkInDate;
            const checkOutDate = row.dataset.checkOutDate;
            const numDays = row.dataset.numDays;
            const roomType = row.dataset.roomType;
            const paymentMode = row.dataset.paymentMode;

            document.getElementById('viewCheckInDate').textContent = checkInDate;
            document.getElementById('viewCheckOutDate').textContent = checkOutDate;
            document.getElementById('viewNumDays').textContent = numDays;
            document.getElementById('viewRoomType').textContent = roomType;
            document.getElementById('viewPaymentMode').textContent = paymentMode;

            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        });
    });

    document.querySelectorAll('.edit-booking').forEach(function (element) {
        element.addEventListener('click', function () {
            const row = this.closest('tr');
            const transactId = row.dataset.transactId;
            const checkInDate = row.dataset.checkInDate;
            const checkOutDate = row.dataset.checkOutDate;
            const numDays = row.dataset.numDays;
            const roomType = row.dataset.roomType;
            const paymentMode = row.dataset.paymentMode;

            const editForm = document.getElementById('editForm');
            editForm.action = `editBooking.php?transact_id=${transactId}`;
            document.getElementById('editCheckInDate').value = checkInDate;
            document.getElementById('editCheckOutDate').value = checkOutDate;
            document.getElementById('editNumDays').value = numDays;
            document.getElementById('editRoomType').value = roomType;
            document.getElementById('editPaymentMode').value = paymentMode;

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    document.querySelectorAll('.cancel-booking').forEach(function (element) {
        element.addEventListener('click', function () {
            const row = this.closest('tr');
            const transactId = row.dataset.transactId;

            document.getElementById('cancelTransactId').value = transactId;

            const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
            cancelModal.show();
        });
    });

    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const actionUrl = this.action;

        // Client-side validation: Check if check-in date is valid
        const checkInDate = formData.get('checkin');
        const today = new Date().toISOString().split('T')[0];
        if (checkInDate <= today) {
            alert('Check-in date must be onwards from today.');
            return;
        }

        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.success) {
                window.location.href = 'viewBooking.php';
            } else {
                alert(jsonResponse.message);
            }
        })
        .catch(() => {
            alert('An error occurred. Please try again.');
        });
    });

    // Modify cancel form submission to handle cancellation and update UI
    document.getElementById('cancelForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('cancelBooking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.success) {
                window.location.href = 'viewBooking.php';
            } else {
                alert(jsonResponse.message);
            }
        })
        .catch(() => {
            alert('An error occurred. Please try again.');
        });
    });
});