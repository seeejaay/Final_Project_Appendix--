document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-booking').forEach(function (element) {
        element.addEventListener('click', function () {
            const row = this.closest('tr');
            const checkInDate = row.dataset.checkInDate;
            const checkOutDate = row.dataset.checkOutDate;
            const numDays = row.dataset.numDays;
            const roomType = row.dataset.roomType;
            const paymentMode = row.dataset.paymentMode;
            const roomID = row.dataset.room_id;

            document.getElementById('viewCheckInDate').textContent = checkInDate;
            document.getElementById('viewCheckOutDate').textContent = checkOutDate;
            document.getElementById('viewNumDays').textContent = numDays;
            document.getElementById('viewRoomType').textContent = roomType;
            document.getElementById('viewPaymentMode').textContent = paymentMode;
            document.getElementById('viewRoomID').textContent = roomID;

            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            viewModal.show();
        });
    });

    // Use event delegation for the edit button
    document.querySelectorAll('.edit-booking').forEach(function (element) {
        element.addEventListener('click', function () {
            const row = this.closest('tr');
            const roomId = row.dataset.roomId; // Retrieve room ID from dataset

            // Set room ID in the hidden input field
            document.getElementById('editRoomId').value = roomId;

            // Other code to set values in the edit modal form
            const checkInDate = row.dataset.checkInDate;
            const checkOutDate = row.dataset.checkOutDate;
            const numDays = row.dataset.numDays;

            document.getElementById('editCheckInDate').value = checkInDate;
            document.getElementById('editCheckOutDate').value = checkOutDate;
            document.getElementById('editNumDays').value = numDays;

            // Show the edit modal
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

    
// Select edit and cancel buttons
const editButtons = document.querySelectorAll('.edit-booking');
const cancelButtons = document.querySelectorAll('.cancel-booking');

// Function to handle edit button click
function handleEditClick(event) {
    const room_id = event.target.dataset.room_id;
    sessionStorage.setItem('editRoomId', room_id); // Store// Store transact_id in sessionStorage
}

// Function to handle cancel button click
function handleCancelClick(event) {
    const transactId = event.target.dataset.transactId; // Retrieve transact_id from data attribute
    sessionStorage.setItem('cancelTransactId', transactId); // Store transact_id in sessionStorage

    
}

// Attach click event listeners to edit buttons
editButtons.forEach(button => {
    button.addEventListener('click', handleEditClick);
});

// Attach click event listeners to cancel buttons
cancelButtons.forEach(button => {
    button.addEventListener('click', handleCancelClick);
});

});
