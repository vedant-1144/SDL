// Click event handler
function handleClick(event) {
    alert('Element clicked: ' + event.target.id);
}

// Mouseover event handler
function handleMouseOver(event) {
    event.target.style.backgroundColor = 'yellow';
}

// Mouseout event handler
function handleMouseOut(event) {
    event.target.style.backgroundColor = '';
}

// Keypress event handler
function handleKeyPress(event) {
    console.log('Key pressed: ' + event.key);
}

// Form submit event handler
function handleFormSubmit(event) {
    event.preventDefault(); // Prevent form submission
    alert('Form submitted with input: ' + event.target.elements["nameInput"].value);
}

// Add event listeners to elements after DOM content is loaded
document.addEventListener('DOMContentLoaded', function() {
    const clickBtn = document.getElementById('clickBtn');
    if (clickBtn) {
        clickBtn.addEventListener('click', handleClick);
    }

    const hoverDiv = document.getElementById('hoverDiv');
    if (hoverDiv) {
        hoverDiv.addEventListener('mouseover', handleMouseOver);
        hoverDiv.addEventListener('mouseout', handleMouseOut);
    }

    const inputField = document.getElementById('inputField');
    if (inputField) {
        inputField.addEventListener('keypress', handleKeyPress);
    }

    const form = document.getElementById('sampleForm');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
});
