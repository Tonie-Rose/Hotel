$(document).ready(function() {
  var modal = $('#viewModal');
  var modalContent = $('#paymentDetails');

  $('.close-btn').on('click', function() {
    modal.hide();
    modalContent.html('');
  });

  $('.view-btn').on('click', function() {
    var paymentId = $(this).data('id');
    $.ajax({
      url: 'php/payment/get_payment_details.php',
      method: 'POST',
      data: { payment_id: paymentId },
      success: function(response) {
        modalContent.html(response);
        modal.show();
      },
      error: function() {
        modalContent.html('<p>Error loading payment details.</p>');
        modal.show();
      }
    });
  });

  $('.refund-btn').on('click', function() {
    var paymentId = $(this).data('id');
    if (confirm('Are you sure you want to refund this payment?')) {
      $.ajax({
        url: 'php/payment/refund_payment.php',
        method: 'POST',
        data: { payment_id: paymentId },
        success: function(res) {
          alert(res);
          location.reload();
        },
        error: function() {
          alert('Failed to refund payment.');
        }
      });
    }
  });

  $('.delete-btn').on('click', function() {
    var paymentId = $(this).data('id');
    if (confirm('Are you sure you want to delete this payment record?')) {
      $.ajax({
        url: 'php/payment/delete_payment.php',
        method: 'POST',
        data: { payment_id: paymentId },
        success: function(res) {
          alert(res);
          location.reload();
        },
        error: function() {
          alert('Failed to delete payment.');
        }
      });
    }
  });
});
