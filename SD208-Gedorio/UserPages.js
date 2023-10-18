document.addEventListener("DOMContentLoaded", function () { //using DOM function for POST method and the success message
    const form = document.querySelector("form");
    const successMessage = document.getElementById("success-message");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch("Activity_php/add_activity.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    successMessage.textContent = data.message;
                    successMessage.style.display = "block";
                } else {
                    console.error(data.message);
                }
            })
            .catch((error) => {
                console.error("An error occurred:", error);
            });
    });
});
function cancelActivity(activityId) { //activity method for cancel activity using POST method fetch for update_activity.php
    fetch("Activity_php/update_activity.php", {
        method: "POST",
        body: JSON.stringify({ id: activityId, status: "Cancelled" }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())// using json to response the data using success and update act. status
        .then((data) => {
            if (data.status === "success") {
                // Update the activity status in the DOM
                const statusCell = document.querySelector(`#activity-${activityId}-status`);
                if (statusCell) {
                    statusCell.textContent = "Cancelled";
                }
                console.log("Activity cancelled successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
}

function markDone(activityId) {
    fetch("Activity_php/update_activity.php", {
        method: "POST",
        body: JSON.stringify({ id: activityId, status: "Done" }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                // Update activity status in the DOM
                const statusCell = document.querySelector(`#activity-${activityId}-status`);
                if (statusCell) {
                    statusCell.textContent = "Done";
                }
                console.log("Activity marked as done successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
}

function editActivity(activityId) {
    // Fetch the activity details from the server based on the activityId
    fetch("Activity_php/get_activity.php?id=" + activityId)
        .then((response) => response.json())
        .then((data) => {
            console.log("Response from get_activity.php:", data)
            
            if (data.status === "success") {
                const activity = data.activity;

                // Populate the edit form with the fetched data
                const editForm = document.createElement("form");
                editForm.innerHTML = `
                    <div class="form-group">
                        <label for="edit_activity_name">Activity Name:</label>
                        <input type="text" id="edit_activity_name" name="edit_activity_name" required value="${activity.activity_name}">
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_date">Date:</label>
                        <input type="date" id="edit_activity_date" name="edit_activity_date" required value="${activity.activity_date}">
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_time">Time:</label>
                        <input type="time" id="edit_activity_time" name="edit_activity_time" required value="${activity.activity_time}">
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_location">Location:</label>
                        <input type="text" id="edit_activity_location" name="edit_activity_location" value="${activity.activity_location}">
                    </div>
                    <div class="form-group">
                        <label for="edit_activity_ootd">OOTD:</label>
                        <input type="text" id="edit_activity_ootd" name="edit_activity_ootd" value="${activity.activity_ootd}">
                    </div>
                    <div class="form-group text-center">
                        <button type="button" onclick="updateActivity(${activityId})">Save Changes</button>
                    </div>
                `;

                // Display the edit form in the modal
                const editContainer = document.getElementById("edit-container");
                editContainer.innerHTML = "";
                editContainer.appendChild(editForm);

                // Show the modal
                const editModal = document.getElementById("edit-modal");
                editModal.style.display = "block";
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
            console.error("Error details:", error.message);
        });
}


function closeEditModal() {
    const editModal = document.getElementById("edit-modal");
    editModal.style.display = "none";
    console.log("Modal closed"); // Debugging statement
}


function cancelActivity(activityId) { //activity method for cancel activity using POST method fetch for update_activity.php
    fetch("Activity_php/update_activity.php", {
        method: "POST",
        body: JSON.stringify({ id: activityId, status: "Cancelled" }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())// using json to response the data using success and update act. status
        .then((data) => {
            if (data.status === "success") {
                // Update the activity status in the DOM
                const statusCell = document.querySelector(`#activity-${activityId}-status`);
                if (statusCell) {
                    statusCell.textContent = "Cancelled";
                }
                console.log("Activity cancelled successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
}

function markDone(activityId) { //mark done for the act. 
    fetch("Activity_php/update_activity.php", {
        method: "POST",
        body: JSON.stringify({ id: activityId, status: "Done" }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                // Update activity status in the DOM
                const statusCell = document.querySelector(`#activity-${activityId}-status`);
                if (statusCell) {
                    statusCell.textContent = "Done";
                }
                console.log("Activity marked as done successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
}

function updateActivity(activityId) {
    // Fetch the updated data from the edit form
    const updatedName = document.getElementById("edit_activity_name").value;
    const updatedDate = document.getElementById("edit_activity_date").value;
    const updatedTime = document.getElementById("edit_activity_time").value;
    const updatedLocation = document.getElementById("edit_activity_location").value;
    const updatedOOTD = document.getElementById("edit_activity_ootd").value;

    fetch("Activity_php/update_activity.php", {
        method: "POST",
        body: JSON.stringify({
            id: activityId,
            status: "Updated",
            activity_name: updatedName,
            activity_date: updatedDate,
            activity_time: updatedTime,
            activity_location: updatedLocation,
            activity_ootd: updatedOOTD,
        }),
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                // Update the activity details in the DOM
                const nameCell = document.querySelector(`#activity-${activityId}-name`);
                const dateCell = document.querySelector(`#activity-${activityId}-date`);
                const timeCell = document.querySelector(`#activity-${activityId}-time`);
                const locationCell = document.querySelector(`#activity-${activityId}-location`);
                const ootdCell = document.querySelector(`#activity-${activityId}-ootd`);
                const statusCell = document.querySelector(`#activity-${activityId}-status`); // Select the status cell

                if (nameCell && dateCell && timeCell && locationCell && ootdCell && statusCell) {
                    nameCell.textContent = updatedName;
                    dateCell.textContent = updatedDate;
                    timeCell.textContent = updatedTime;
                    locationCell.textContent = updatedLocation;
                    ootdCell.textContent = updatedOOTD;
                    statusCell.textContent = "Updated";
                }

                // Close the edit modal
                closeEditModal();

                console.log("Activity updated successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
}
function deleteActivity(activityId) {
    if (confirm("Are you sure you want to delete this activity?")) {
        fetch("Activity_php/delete_activity.php", {
            method: "POST",
            body: JSON.stringify({ id: activityId }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                // Remove the activity from the DOM
                const activityRow = document.querySelector(`#activity-${activityId}`);
                if (activityRow) {
                    activityRow.remove();
                }
                console.log("Activity deleted successfully.");
            } else {
                console.error(data.message);
            }
        })
        .catch((error) => {
            console.error("An error occurred:", error);
        });
    }
}

function addRemarks(activityId) {
    console.log("Implement the functionality to add remarks for activity with ID: " + activityId);
}


function closeAnnouncementModal() {
    $('#viewAnnouncementsModal').modal('hide');
}

$(document).ready(function () {
    $('#viewAnnouncementButton').click(function () {
        $('#viewAnnouncementsModal').modal('show');
    });
});

$(document).ready(function () {
    $('#showActivitiesButton').click(function () {
        loadAndDisplayActivities();
        $('#showActivitiesModal').modal('show');
    });
});

function loadAndDisplayActivities() {
    // Implement this function
}