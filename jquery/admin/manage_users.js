$(document).ready(function() {
    // Delete user
    $('.delete-btn').click(function() {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.post('php/delete_user.php', { user_id: userId }, function(response) {
                alert(response);
                location.reload();
            });
        }
    });

    // Show booking history modal
    $('.view-history-btn').click(function() {
        const userId = $(this).data('id');
        $('#bookingHistoryTable tbody').empty();

        $.post('php/users/get_bookings_history.php', { user_id: userId }, function(data) {
            if (!data || data.length === 0) {
                $('#bookingHistoryTable tbody').append('<tr><td colspan="6">No bookings found.</td></tr>');
            } else {
                data.forEach(function(reservation) {
                    $('#bookingHistoryTable tbody').append(`
                        <tr>
                            <td>${reservation.reservation_id}</td>
                            <td>${reservation.room_number}</td>
                            <td>${reservation.room_type}</td>
                            <td>${reservation.check_in}</td>
                            <td>${reservation.check_out}</td>
                            <td>${reservation.status}</td>
                        </tr>
                    `);
                });
            }
            $('#bookingHistoryModal').fadeIn();
        }, 'json');
    });

    // Close modal
    $('.close-btn').click(function() {
        $('#bookingHistoryModal').fadeOut();
    });

    // Close modal when clicking outside content
    $(window).click(function(event) {
        if ($(event.target).is('#bookingHistoryModal')) {
            $('#bookingHistoryModal').fadeOut();
        }
    });
});
