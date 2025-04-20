// Alert message
alert("Welcome to the JS program!");

// Calculate average number of weeks in human lifetime (assuming 80 years)
const years = 80;
const weeksPerYear = 52;
const averageWeeks = years * weeksPerYear;

// Create variables to store strings
const greeting = "Hello, world!";
const farewell = "Goodbye!";

// Program that tells time of the day (morning, afternoon, night)
const now = new Date();
const hour = now.getHours();
let timeOfDay;

if (hour >= 5 && hour < 12) {
    timeOfDay = "morning";
} else if (hour >= 12 && hour < 18) {
    timeOfDay = "afternoon";
} else {
    timeOfDay = "night";
}

// Display results on the webpage instead of console
const outputDiv = document.createElement('div');
outputDiv.innerHTML = `
    <p>Average number of weeks in a human lifetime: <strong>${averageWeeks}</strong></p>
    <p>Greeting message: <strong>${greeting}</strong></p>
    <p>Farewell message: <strong>${farewell}</strong></p>
    <p>Good <strong>${timeOfDay}</strong>!</p>
`;
document.body.appendChild(outputDiv);
