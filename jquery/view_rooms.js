// jquery/view_rooms.js
$(document).ready(function () {
    // Open modal
    $('.reserve-btn').on('click', function () {
        const roomCard = $(this).closest('.room-card');
        const roomId = roomCard.data('room-id');
        const roomNumber = roomCard.data('room-number');

        $('#modalRoomId').val(roomId);
        $('#modalRoomNumber').text(roomNumber);
        $('#reservationModal').fadeIn().attr('aria-hidden', 'false');
    });

    // Close modal
    $('.close-btn').on('click', function () {
        $('#reservationModal').fadeOut().attr('aria-hidden', 'true');
        $('#reservationForm')[0].reset();
    });

    // Optional: close modal when clicking outside modal content
    $('#reservationModal').on('click', function (e) {
        if ($(e.target).is('#reservationModal')) {
            $(this).fadeOut().attr('aria-hidden', 'true');
            $('#reservationForm')[0].reset();
        }
    });

    // Submit reservation
    $('#reservationForm').on('submit', function (e) {
        e.preventDefault();

        const checkin = $('#checkin').val();
        const checkout = $('#checkout').val();

        if (!checkin || !checkout) {
            alert("Please select both check-in and check-out dates.");
            return;
        }

        $.ajax({
            url: 'php/reservation/reserve_room.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = 'payment.php?reservation_id=' + response.reservation_id;
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('An error occurred while processing your reservation.');
            }
        });
    });
});
