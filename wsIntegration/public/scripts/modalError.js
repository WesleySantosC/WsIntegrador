window.addEventListener('DOMContentLoaded', function () {
    var errorModal = document.getElementById('errorModal');
    if (errorModal) {
      var modal = new bootstrap.Modal(errorModal);
      modal.show();
    }
  });
  