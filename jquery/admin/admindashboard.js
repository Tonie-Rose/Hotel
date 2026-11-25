$(document).ready(function () {
    // Highlight active nav item
    $('nav a').on('click', function () {
        $('nav a').removeClass('active');
        $(this).addClass('active');
    });

    // Logout logic
    $('#logout-btn').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'logout.php',
            method: 'POST',
            success: function () {
                window.location.href = 'index.php';
            },
            error: function () {
                alert('Error logging out. Please try again.');
            }
        });
    });

    // Fetch dashboard statistics
    $.ajax({
        url: 'php/get_dashboard_stat.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const data = response.data;
                $('#totalUsers').text("Total Users: " + data.total_users);
                $('#totalReservations').text("Total Reservations: " + data.total_reservations);
                $('#totalRooms').text("Total Rooms: " + data.total_rooms);
                $('#availableRooms').text("Available Rooms: " + data.available_rooms);
                $('#totalPayments').text("Total Payments: $" + parseFloat(data.total_payments).toFixed(2));
            } else {
                $('.stat-box').text("Error loading data: " + response.message);
            }
        },
        error: function () {
            $('.stat-box').text("Error loading stats.");
        }
    });
});
