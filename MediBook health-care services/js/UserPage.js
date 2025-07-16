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
const clinicSelect = document.getElementById("clinic");
const timeSlotSelect = document.getElementById("timeSlot");
const serviceTypeSelect = document.getElementById("serviceType");

function updateTimeSlots() {
    const clinic = clinicSelect.value;
    const date = dateInput.value;
    timeSlotSelect.innerHTML =
        '<option value="" disabled selected>Select a time slot</option>';
    if (!clinic || !date) return;

    fetch(`../patient/get_available_slots.php?clinic=${encodeURIComponent(clinic)}&date=${encodeURIComponent(date)}`)
        .then(response => response.json())
        .then(slots => {
            if (slots.length === 0) {
                const option = document.createElement("option");
                option.value = "";
                option.textContent = "No available slots";
                option.disabled = true;
                timeSlotSelect.appendChild(option);
            } else {
                slots.forEach(slot => {
                    const option = document.createElement("option");
                    option.value = slot;
                    option.textContent = slot;
                    timeSlotSelect.appendChild(option);
                });
            }
        });
}

function updateServiceTypes() {
    const clinic = clinicSelect.value;
    serviceTypeSelect.innerHTML = '<option value="" disabled selected>Select a service</option>';
    if (!clinic) return;
    fetch(`../patient/get_clinic_services.php?clinic=${encodeURIComponent(clinic)}`)
        .then(response => response.json())
        .then(services => {
            if (services.length === 0) {
                const option = document.createElement("option");
                option.value = "";
                option.textContent = "No services available";
                option.disabled = true;
                serviceTypeSelect.appendChild(option);
            } else {
                services.forEach(service => {
                    const option = document.createElement("option");
                    option.value = service;
                    option.textContent = service;
                    serviceTypeSelect.appendChild(option);
                });
            }
        });
}

clinicSelect.addEventListener("change", () => {
    updateTimeSlots();
    updateServiceTypes();
});
dateInput.addEventListener("change", updateTimeSlots);

// Form validation
const form = document.getElementById("appointmentForm");
const idNumberInput = document.getElementById("idNumber");
const idNumberError = document.getElementById("idNumberError");
const dateError = document.getElementById("dateError");
