function tab(t) {
    var contents = document.querySelectorAll('.content'); // get all content elements
    for (var i = 0; i < contents.length; i++) {
        contents[i].style.display = 'none'; // hide all contents
    }

    var selectedContent = document.getElementById('content' + t); // get the selected content element
    selectedContent.style.display = 'block'; // show the selected content
    selectedContent.style.opacity = '0'; // set the initial opacity to 0
    setTimeout(function () {
        selectedContent.style.transition = 'opacity 1s'; // add a transition effect
        selectedContent.style.opacity = '1'; // set the final opacity to 1 after a delay
    }, 10);
}

