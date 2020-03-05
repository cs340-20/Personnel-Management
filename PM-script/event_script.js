//opens and closes the add event box
function openAddEvent() {
    var addBox = document.getElementById('add_event_container');

    if (addBox.classList.contains('add_event_closed')) {
        addBox.style.height = '150px';
        addBox.classList.remove('add_event_closed');
        addBox.classList.add('add_event_opened');
    } else if (addBox.classList.contains('add_event_opened')) {
        addBox.style.height = '0px';
        addBox.classList.remove('add_event_opened');
        addBox.classList.add('add_event_closed');
    }
}