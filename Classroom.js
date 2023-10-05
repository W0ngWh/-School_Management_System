function searchAvailability() {
    var startHour = document.getElementById('search-start-hour').value;
    var startMinute = document.getElementById('search-start-minute').value;
    var endHour = document.getElementById('search-end-hour').value;
    var endMinute = document.getElementById('search-end-minute').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var availabilityData = JSON.parse(xhr.responseText);
                displayAvailability(availabilityData);
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.open('GET', 'get_availability.php' +
        '?start_hour=' + encodeURIComponent(startHour) +
        '&start_minute=' + encodeURIComponent(startMinute) +
        '&end_hour=' + encodeURIComponent(endHour) +
        '&end_minute=' + encodeURIComponent(endMinute), true);
    xhr.send();
}

function displayAvailability(data) {
    var availabilityContainer = document.getElementById('availability');
    availabilityContainer.innerHTML = '';

    data.forEach(function (classroom) {
        var classroomDiv = document.createElement('div');
        classroomDiv.className = classroom.available ? 'unavailable' : 'available';

        var availabilityText = document.createElement('p');
        availabilityText.textContent = classroom.name + ' is ' + (classroom.available ? 'not available' : 'available');

        if (classroom.available) {
            var startTime = document.createElement('span');
            startTime.textContent = ' (Start: ' + classroom.start_hour + ':' + classroom.start_minute + ')';
            var endTime = document.createElement('span');
            endTime.textContent = ' (End: ' + classroom.end_hour + ':' + classroom.end_minute + ')';

            availabilityText.appendChild(startTime);
            availabilityText.appendChild(endTime);
        }

        classroomDiv.appendChild(availabilityText);
        availabilityContainer.appendChild(classroomDiv);
    });
}