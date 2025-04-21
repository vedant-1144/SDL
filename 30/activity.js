class Activity {
  constructor(logElementId) {
    this.logElement = document.getElementById(logElementId);
  }

  logEvent(message) {
    const p = document.createElement("p");
    p.textContent = message;
    this.logElement.appendChild(p);
  }

  attachEvents(form) {
    form.addEventListener("focusin", (e) => {
      this.logEvent(`Focus on ${e.target.name}`);
    });

    form.addEventListener("focusout", (e) => {
      this.logEvent(`Blur from ${e.target.name}`);
    });

    form.addEventListener("input", (e) => {
      this.logEvent(`Input in ${e.target.name}: ${e.target.value}`);
    });

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      this.logEvent("Form submitted");
      alert("Form submitted!");
      form.reset();
    });

    form.addEventListener("reset", () => {
      this.logEvent("Form reset");
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const activity = new Activity("eventLog");
  const form = document.getElementById("restaurantForm");
  activity.attachEvents(form);
});
