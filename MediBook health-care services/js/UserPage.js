// Toggle side navigation
function toggleNav() {
    const sideNav = document.getElementById("sideNav");
    const isExpanded = sideNav.getAttribute("aria-expanded") === "true";
    sideNav.style.width = isExpanded ? "0" : "250px";
    sideNav.setAttribute("aria-expanded", !isExpanded);
    document
        .querySelector(".user-icon-btn")
        .setAttribute("aria-expanded", !isExpanded);
}

// Show appointment form
function showAppointmentForm() {
    document.getElementById("defaultContent").style.display = "none";
    document.getElementById("appointmentFormContainer").style.display =
        "block";
    const sideNav = document.getElementById("sideNav");
    if (sideNav.getAttribute("aria-expanded") === "true") {
        toggleNav(); // Close side nav if open
    }
}

// Hide appointment form
function hideAppointmentForm() {
    document.getElementById("appointmentFormContainer").style.display =
        "none";
    document.getElementById("defaultContent").style.display = "block";
    document.getElementById("appointmentForm").reset();
    document.getElementById("timeSlot").innerHTML =
        '<option value="" disabled selected>Select a time slot</option>';
}

// Set minimum date to tomorrow
const dateInput = document.getElementById("appointmentDate");
const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
dateInput.min = tomorrow.toISOString().split("T")[0];

// Populate time slots based on date
const timeSlotSelect = document.getElementById("timeSlot");
function updateTimeSlots() {
    const selectedDate = new Date(dateInput.value);
    timeSlotSelect.innerHTML =
        '<option value="" disabled selected>Select a time slot</option>';
    if (!dateInput.value) return;

    const isWeekend =
        selectedDate.getDay() === 0 || selectedDate.getDay() === 6;
    const slots = isWeekend
        ? ["10:00", "12:00", "14:00"]
        : [
            "08:00",
            "09:00",
            "10:00",
            "11:00",
            "12:00",
            "13:00",
            "14:00",
            "15:00",
            "16:00",
        ];

    slots.forEach((slot) => {
        const option = document.createElement("option");
        option.value = slot;
        option.textContent = slot;
        timeSlotSelect.appendChild(option);
    });
}

dateInput.addEventListener("change", updateTimeSlots);

// Form validation
const form = document.getElementById("appointmentForm");
const idNumberInput = document.getElementById("idNumber");
const idNumberError = document.getElementById("idNumberError");
const dateError = document.getElementById("dateError");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let isValid = true;

    // Validate ID Number
    if (!/^\d{13}$/.test(idNumberInput.value)) {
        idNumberError.style.display = "block";
        isValid = false;
    } else {
        idNumberError.style.display = "none";
    }

    // Validate Date
    const selectedDate = new Date(dateInput.value);
    if (selectedDate <= new Date()) {
        dateError.style.display = "block";
        isValid = false;
    } else {
        dateError.style.display = "none";
    }

    if (isValid) {
        console.log("Form Data:", new FormData(form));
        alert("Appointment booked successfully!");
        hideAppointmentForm();
    }
});