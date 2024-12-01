<?php
// app/views/event_mgmt.php
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Event Management</h1>
    
    <!-- Add New Event Button -->
    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">Create New Event</button>
    </div>

    <!-- Event Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Banner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="event-list">
                <!-- Events will be populated dynamically -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="addEventForm">
                    <div id="formMessage" class="mb-3"></div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" name="banner" accept="image/*" class="form-control shadow-sm">
                        <small class="form-text text-muted">Choose a banner for event.</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <select class="form-select" id="location" name="location" required>
                            <option value="Vietnam">Vietnam</option>
                            <option value="USA">USA</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="editEventForm">
                    <input type="hidden" id="eventId" name="id">
                    <div id="editMessage" class="mb-3"></div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editStartTime" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="editStartTime" name="start_time">
                    </div>
                    <div class="mb-3">
                        <label for="editEndTime" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="editEndTime" name="end_time">
                    </div>
                    <div class="mb-3">
                        <label for="editLocation" class="form-label">Location</label>
                        <select class="form-select" id="editLocation" name="location">
                            <option value="Vietnam">Vietnam</option>
                            <option value="USA">USA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" id="oldBanner" name="oldBanner">
                        <label>Current Banner</label>
                        <img id="currentBanner" src="#" alt="Event Banner" class="img-fluid mb-2">
                        <input type="file" name="banner" accept="image/*" class="form-control shadow-sm">
                        <small class="form-text text-muted">Choose another banner for event.</small>
                    </div>
                    <button id="confirmUpdateButton" type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Event Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
                <p><strong>ID:</strong> <span id="deleteEventId"></span></p>
                <p><strong>Title:</strong> <span id="deleteEventTitle"></span></p>
                <img id="deleteBanner" src="#" alt="Event Banner" class="img-fluid mb-2">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const now = new Date();
        const formattedStartDate = now.toISOString().slice(0, 16); // Current date and time
        const formattedEndDate = new Date(now.getTime() + 24 * 60 * 60 * 1000).toISOString().slice(0, 16); // One day later

        // Set start_time to current date and time
        document.getElementById('start_time').value = formattedStartDate;
        
        // Set end_time to one day later
        document.getElementById('end_time').value = formattedEndDate;

        fetch
    });


    document.getElementById('addEventForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formMessage = document.getElementById('formMessage');
        formMessage.innerHTML = '';

        const formData = new FormData(event.target);

        fetch('index.php?ajax=createEvent', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                formMessage.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Event created successfully!
                    </div>
                `;
                const reloadMessage = document.createElement('div');
                reloadMessage.classList.add('alert', 'alert-info');
                reloadMessage.textContent = 'Trang sẽ tự động tải lại trong 3 giây...';
                formMessage.appendChild(reloadMessage);
                setTimeout(() => window.location.reload(), 3000);
            } else {
                formMessage.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        Error: ${data.message}
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            formMessage.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    An unexpected error occurred. Please try again.
                </div>
            `;
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let eventData = []; // Variable to store the fetched events

    // Fetch and store events
    fetch('index.php?ajax=getEvents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            eventData = data.data; // Store the events in the variable
            const eventTableBody = document.getElementById('event-list');
            eventTableBody.innerHTML = '';

            // Populate events
            if (eventData.length > 0) {
                eventData.forEach(event => {
                    eventTableBody.innerHTML += `
                        <tr>
                            <td>${event.id}</td>
                            <td>${event.title}</td>
                            <td>${event.description.substring(0, 50)}...</td>
                            <td>${event.start_time}</td>
                            <td>${event.end_time}</td>
                            <td>${event.location}</td>
                            <td><img src="public/img/event/${event.image}" alt="Event Banner" style="max-width: 100px;"></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="openEditModal(${event.id})">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="openDeleteModal(${event.id})">Delete</button>
                            </td>
                        </tr>`;
                });
            } else {
                eventTableBody.innerHTML = '<tr><td colspan="8" class="text-center">No events found</td></tr>';
            }
        } else {
            console.error('Error:', data.message);
            alert('Unable to load events list.');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while loading the events list.');
    });

    // Function to open the edit modal
    window.openEditModal = function (id) {
        const event = eventData.find(e => e.id === id); // Find the event by ID
        if (!event) return alert('Event not found.');

        // Populate the modal fields
        const editModal = document.getElementById('editEventModal');
        editModal.querySelector('#editTitle').value = event.title;
        editModal.querySelector('#editDescription').value = event.description;
        editModal.querySelector('#editStartTime').value = event.start_time;
        editModal.querySelector('#editEndTime').value = event.end_time;
        editModal.querySelector('#editLocation').value = event.location;
        editModal.querySelector('#currentBanner').src = `public/img/event/${event.image}`;
        editModal.querySelector('#eventId').value = event.id;
        editModal.querySelector('#oldBanner').value = `${event.image}`;

        const bsEditModal = new bootstrap.Modal(editModal);
        bsEditModal.show();
    };

    // Function to open the delete modal
    window.openDeleteModal = function (id) {
        const event = eventData.find(e => e.id === id); // Find the event by ID
        if (!event) return alert('Event not found.');

        // Populate the modal fields
        const deleteModal = document.getElementById('deleteEventModal');
        deleteModal.querySelector('#deleteEventId').textContent = event.id;
        deleteModal.querySelector('#deleteEventTitle').textContent = event.title;
        deleteModal.querySelector('#deleteBanner').src = `public/img/event/${event.image}`;
        deleteModal.querySelector('#confirmDeleteButton').onclick = () => deleteEvent(event.id);

        const bsDeleteModal = new bootstrap.Modal(deleteModal);
        bsDeleteModal.show();
    };

    // Function to update an event
    document.getElementById('editEventForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const editMessage = document.getElementById('editMessage');
        editMessage.innerHTML = '';

        const formData = new FormData(event.target);

        fetch('index.php?ajax=updateEvent', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                editMessage.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        Event updated successfully!
                    </div>
                `;
                const reloadMessage = document.createElement('div');
                reloadMessage.classList.add('alert', 'alert-info');
                reloadMessage.textContent = 'Trang sẽ tự động tải lại trong 3 giây...';
                editMessage.appendChild(reloadMessage);
                setTimeout(() => window.location.reload(), 3000);
            } else {
                editMessage.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        Error: ${data.message}
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            editMessage.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    An unexpected error occurred. Please try again.
                </div>
            `;
        });
    });

    // Function to delete an event
    function deleteEvent(id) {
        fetch('index.php?ajax=deleteEvent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Event deleted successfully.');
                window.location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('An error occurred while deleting the event.');
        });
    }
});

</script>
