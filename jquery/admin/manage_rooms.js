document.addEventListener('DOMContentLoaded', function () {
  const addRoomModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
  const editRoomModal = new bootstrap.Modal(document.getElementById('editRoomModal'));

  // Open Add Modal
  document.getElementById('btnAddRoom').addEventListener('click', () => {
    document.getElementById('addRoomForm').reset();
    addRoomModal.show();
  });

  // Add Room Form submit
  document.getElementById('addRoomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('php/rooms/add_room.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        addRoomModal.hide();
        refreshRoomTable();
      }
    })
    .catch(err => alert('Error: ' + err));
  });

  // Edit button click - fetch room data and open modal
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function () {
      const roomId = this.getAttribute('data-id');
      fetch(`php/rooms/get_room.php?id=${roomId}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const r = data.room;
            document.getElementById('edit_room_id').value = r.room_id;
            document.getElementById('edit_room_number').value = r.room_number;
            document.getElementById('edit_room_type').value = r.room_type;
            document.getElementById('edit_bed_type').value = r.bed_type;
            document.getElementById('edit_capacity').value = r.capacity;
            document.getElementById('edit_floor').value = r.floor;
            document.getElementById('edit_price').value = r.price;
            document.getElementById('edit_status').value = r.status;
            document.getElementById('edit_description').value = r.description;
            editRoomModal.show();
          } else {
            alert('Room not found.');
          }
        })
        .catch(() => alert('Error fetching room data.'));
    });
  });

  // Edit Room Form submit
  document.getElementById('editRoomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('php/rooms/update_room.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        editRoomModal.hide();
        refreshRoomTable();
      }
    })
    .catch(err => alert('Error: ' + err));
  });

  // Delete button click
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
      if (!confirm('Are you sure you want to delete this room?')) return;
      const roomId = this.getAttribute('data-id');
      fetch('delete_room.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'room_id=' + encodeURIComponent(roomId)
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) refreshRoomTable();
      })
      .catch(() => alert('Error deleting room.'));
    });
  });

  // Refresh table rows after add/update/delete
  function refreshRoomTable() {
    fetch('php/rooms/fetch_rooms.php')
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const tbody = document.getElementById('roomTableBody');
          tbody.innerHTML = '';
          data.rooms.forEach(r => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-id', r.room_id);
            tr.innerHTML = `
              <td>${escapeHtml(r.room_number)}</td>
              <td>${escapeHtml(r.room_type)}</td>
              <td>${escapeHtml(r.bed_type)}</td>
              <td>${r.capacity}</td>
              <td>${r.floor}</td>
              <td>${r.price}</td>
              <td>${escapeHtml(r.status)}</td>
              <td>${escapeHtml(r.description)}</td>
              <td>
                <button class="btn btn-sm btn-info btn-edit" data-id="${r.room_id}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${r.room_id}">Delete</button>
              </td>
            `;
            tbody.appendChild(tr);
          });
          // Rebind event listeners on new buttons
          rebindButtons();
        } else {
          alert('Failed to refresh rooms.');
        }
      })
      .catch(() => alert('Error refreshing rooms.'));
  }

  function rebindButtons() {
    document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.onclick = function () {
        const roomId = this.getAttribute('data-id');
        fetch(`php/rooms/get_room.php?id=${roomId}`)
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              const r = data.room;
              document.getElementById('edit_room_id').value = r.room_id;
              document.getElementById('edit_room_number').value = r.room_number;
              document.getElementById('edit_room_type').value = r.room_type;
              document.getElementById('edit_bed_type').value = r.bed_type;
              document.getElementById('edit_capacity').value = r.capacity;
              document.getElementById('edit_floor').value = r.floor;
              document.getElementById('edit_price').value = r.price;
              document.getElementById('edit_status').value = r.status;
              document.getElementById('edit_description').value = r.description;
              editRoomModal.show();
            } else {
              alert('Room not found.');
            }
          })
          .catch(() => alert('Error fetching room data.'));
      };
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.onclick = function () {
        if (!confirm('Are you sure you want to delete this room?')) return;
        const roomId = this.getAttribute('data-id');
        fetch('php/rooms/delete_room.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: 'room_id=' + encodeURIComponent(roomId)
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          if (data.success) refreshRoomTable();
        })
        .catch(() => alert('Error deleting room.'));
      };
    });
  }

  // Helper to escape HTML (to prevent XSS)
  function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>"']/g, m => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    })[m]);
  }
});