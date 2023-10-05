document.addEventListener("click", function(event) {
    var dropdownContents = document.getElementsByClassName("dropdown-content");
    var dropdownArrows = document.getElementsByClassName("dropdown-arrow");
    
    for (var i = 0; i < dropdownContents.length; i++) {
        var dropdownContent = dropdownContents[i];
        
        if (!event.target.matches('.dropdown-arrow') && !event.target.matches('.dropdown-content')) {
            dropdownContent.style.display = 'none';
        }
    }
    
    for (var i = 0; i < dropdownArrows.length; i++) {
        var dropdownArrow = dropdownArrows[i];
        var dropdownContent = dropdownArrow.nextElementSibling;
        
        if (dropdownArrow !== event.target) {
            dropdownContent.style.display = 'none';
        }
    }
});

function toggleDropdown(dropdownArrow) {
    var dropdownContent = dropdownArrow.nextElementSibling;
    dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
}

document.querySelectorAll('.dropdown-arrow').forEach(function(dropdownArrow) {
    dropdownArrow.addEventListener('click', function() {
        toggleDropdown(this);
    });
});