function closeEditForm() {
    document.getElementById('edit-form').style.display = 'none';
}

function fetchClassrooms() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var classroomsData = JSON.parse(xhr.responseText);
                displayClassrooms(classroomsData);
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.open('GET', 'get_classroom.php', true);
    xhr.send();
}

function displayClassrooms(classroomsData) {
    var classroomsList = document.getElementById('classrooms-list');
    classroomsList.innerHTML = '';

    classroomsData.forEach(function (classroom) {
        var classroomDiv = document.createElement('div');
        classroomDiv.className = 'classroom-item';

        var classroomName = document.createElement('h3');
        classroomName.textContent = classroom.name;
        classroomDiv.appendChild(classroomName);

        var startTime = document.createElement('p');
        startTime.textContent = 'Start Time: ' + classroom.start_hour + ':' + classroom.start_minute;
        classroomDiv.appendChild(startTime);

        var endTime = document.createElement('p');
        endTime.textContent = 'End Time: ' + classroom.end_hour + ':' + classroom.end_minute;
        classroomDiv.appendChild(endTime);

        var editButton = document.createElement('button');
        editButton.textContent = 'Edit';
        editButton.onclick = function () {
            showEditForm(classroom);
        };
        classroomDiv.appendChild(editButton);

        classroomsList.appendChild(classroomDiv);
    });
}

function showEditForm(classroom) {
    var editForm = document.getElementById('edit-form');
    editForm.style.display = 'block';

    document.getElementById('edit-classroom-id').value = classroom.id;
    document.getElementById('edit-classroom-name').value = classroom.name;
    document.getElementById('edit-start-hour').value = classroom.start_hour;
    document.getElementById('edit-start-minute').value = classroom.start_minute;
    document.getElementById('edit-end-hour').value = classroom.end_hour;
    document.getElementById('edit-end-minute').value = classroom.end_minute;
}

function updateClassroom() {
    var id = document.getElementById('edit-classroom-id').value;
    var name = document.getElementById('edit-classroom-name').value;
    var startHour = document.getElementById('edit-start-hour').value;
    var startMinute = document.getElementById('edit-start-minute').value;
    var endHour = document.getElementById('edit-end-hour').value;
    var endMinute = document.getElementById('edit-end-minute').value;

    if (validateTime(startHour, startMinute) && validateTime(endHour, endMinute)) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Classroom updated successfully!');
                    fetchClassrooms(); // Refresh the classrooms list
                    hideEditForm();
                } else {
                    alert('Error updating classroom.');
                }
            }
        };

        xhr.open('POST', 'update_classroom.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(
            'id=' + encodeURIComponent(id) +
            '&name=' + encodeURIComponent(name) +
            '&start_hour=' + encodeURIComponent(startHour) +
            '&start_minute=' + encodeURIComponent(startMinute) +
            '&end_hour=' + encodeURIComponent(endHour) +
            '&end_minute=' + encodeURIComponent(endMinute)
        );
    } else {
        alert('Invalid time values. Please enter valid start and end times.');
    }
}


function hideEditForm() {
    var editForm = document.getElementById('edit-form');
    editForm.style.display = 'none';
}

function addClassroom() {
    var classroomName = document.getElementById('classroom-name').value;
    var startHour = document.getElementById('start-hour').value;
    var startMinute = document.getElementById('start-minute').value;
    var endHour = document.getElementById('end-hour').value;
    var endMinute = document.getElementById('end-minute').value;

    if (validateTime(startHour, startMinute) && validateTime(endHour, endMinute)) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Classroom added successfully!');
                    fetchClassrooms(); // Refresh the classrooms list
                    document.getElementById('admin-form').reset();
                } else {
                    alert('Error adding classroom.');
                }
            }
        };

        xhr.open('POST', 'add_classroom.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(
            'name=' + encodeURIComponent(classroomName) +
            '&start_hour=' + encodeURIComponent(startHour) +
            '&start_minute=' + encodeURIComponent(startMinute) +
            '&end_hour=' + encodeURIComponent(endHour) +
            '&end_minute=' + encodeURIComponent(endMinute)
        );
    } else {
        alert('Invalid time values. Please enter valid start and end times.');
    }
}

function validateTime(hour, minute) {
    var valid = true;

    if (hour < 0 || hour > 23 || minute < 0 || minute > 59) {
        valid = false;
    }

    return valid;
}

fetchClassrooms();