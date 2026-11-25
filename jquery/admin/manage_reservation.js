$(document).ready(function () {
  $('.edit-btn').on('click', function () {
    const row = $(this).closest('tr');
    const id = $(this).data('id');

    $('#reservation_id').val(id);
    $('#check_in').val(row.find('td').eq(5).text());
    $('#check_out').val(row.find('td').eq(6).text());
    $('#status').val(row.find('td').eq(7).text());

    $('#editModal').show();
  });

  $('.close-btn').on('click', function () {
    $('#editModal').hide();
  });

  $('#editForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: 'php/reservation/edit_reservation.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (response) {
        alert(response.message);
        if (response.success) location.reload();
      },
      error: function () {
        alert('An error occurred.');
      }
    });
  });

  $('.delete-btn').on('click', function () {
    const id = $(this).data('id');
    if (confirm('Cancel this reservation?')) {
      $.ajax({
        url: 'php/reservation/delete_reservation.php',
        method: 'POST',
        data: { reservation_id: id },
        dataType: 'json',
        success: function (response) {
          alert(response.message);
          if (response.success) location.reload();
        },
        error: function () {
          alert('An error occurred.');
        }
      });
    }
  });
});
