let selectedStart = null;
let selectedEnd = null;
let bookedRanges = [];

document
    .getElementById("tanggal_booking")
    .addEventListener("change", function () {
        updateAvailableHours();
    });

function updateAvailableHours() {
    const date = document.getElementById("tanggal_booking").value;
    const hoursContainer = document.getElementById("hoursContainer");
    const bookedSlotsContainer = document.getElementById(
        "bookedSlotsContainer"
    );
    const bookedSlots = document.getElementById("bookedSlots");

    if (!date) {
        hoursContainer.innerHTML =
            '<div class="col-12"><p class="text-muted">Silakan pilih tanggal terlebih dahulu</p></div>';
        bookedSlotsContainer.style.display = "none";
        return;
    }

    selectedStart = null;
    selectedEnd = null;
    updateRangeDisplay();
    updateHiddenInputs();

    fetch(`/booked-ranges/${date}`)
        .then((response) => response.json())
        .then((ranges) => {
            bookedRanges = ranges;
            generateHourButtons();
            updateBookedSlotsDisplay();
        })
        .catch((error) => {
            console.error("Error:", error);
            bookedRanges = [];
            generateHourButtons();
            bookedSlotsContainer.style.display = "none";
        });
}

function generateHourButtons() {
    const hoursContainer = document.getElementById("hoursContainer");
    hoursContainer.innerHTML = "";

    for (let hour = 0; hour < 24; hour++) {
        const hourString = hour.toString().padStart(2, "0");
        const hourDisplay = hourString + ":00";

        const col = document.createElement("div");
        col.className = "col-6 col-md-4 col-lg-3 mb-2";

        const hourButton = document.createElement("div");
        hourButton.className = "hour-option";
        hourButton.textContent = hourDisplay;
        hourButton.dataset.hour = hourString;

        if (isHourBooked(hourString)) {
            hourButton.classList.add("disabled");
            hourButton.title = "Jam sudah dipesan";
        } else {
            hourButton.addEventListener("click", function () {
                selectHour(this);
            });
        }

        col.appendChild(hourButton);
        hoursContainer.appendChild(col);
    }

    updateButtonStates();
}

function isHourBooked(hour) {
    const hourInt = parseInt(hour);
    for (const range of bookedRanges) {
        const startInt = parseInt(range.start);
        const endInt = parseInt(range.end);
        if (hourInt >= startInt && hourInt < endInt) {
            return true;
        }
    }
    return false;
}

function selectHour(element) {
    const hour = element.dataset.hour;
    const hourInt = parseInt(hour);

    if (selectedStart === null) {
        selectedStart = hour;
        selectedEnd = null;
    } else if (selectedEnd === null) {
        if (hourInt <= parseInt(selectedStart)) {
            alert("Jam akhir harus setelah jam mulai");
            return;
        }
        if (isRangeBooked(selectedStart, hour)) {
            alert(
                "Rentang jam ini bertabrakan dengan booking yang sudah ada. Silakan pilih jam lain."
            );
            return;
        }

        selectedEnd = hour;
    } else {
        selectedStart = hour;
        selectedEnd = null;
    }

    updateButtonStates();
    updateRangeDisplay();
    updateHiddenInputs();
}

function isRangeBooked(start, end) {
    const startInt = parseInt(start);
    const endInt = parseInt(end);

    for (const range of bookedRanges) {
        const rangeStart = parseInt(range.start);
        const rangeEnd = parseInt(range.end);
        if (startInt < rangeEnd && endInt > rangeStart) {
            return true;
        }
    }
    return false;
}

function updateButtonStates() {
    const buttons = document.querySelectorAll(".hour-option");

    buttons.forEach((button) => {
        button.classList.remove("selected", "in-range");

        const hour = button.dataset.hour;
        const hourInt = parseInt(hour);

        if (selectedStart === hour) {
            button.classList.add("selected");
        } else if (selectedEnd !== null && selectedStart !== null) {
            const startInt = parseInt(selectedStart);
            const endInt = parseInt(selectedEnd);

            if (hourInt >= startInt && hourInt < endInt) {
                button.classList.add("in-range");
            }
        }
    });
}

function updateRangeDisplay() {
    const rangeDisplay = document.getElementById("rangeDisplay");

    if (selectedStart && selectedEnd) {
        rangeDisplay.innerHTML = `<span class="text-primary">Jam booking: ${selectedStart}:00 - ${selectedEnd}:00</span>`;
    } else if (selectedStart) {
        rangeDisplay.innerHTML = `<span class="text-warning">Pilih jam akhir (setelah ${selectedStart}:00)</span>`;
    } else {
        rangeDisplay.innerHTML =
            '<span class="text-muted">Silakan pilih jam mulai dan jam akhir</span>';
    }
}

function updateHiddenInputs() {
    document.getElementById("jam_mulai").value = selectedStart || "";
    document.getElementById("jam_akhir").value = selectedEnd || "";
}

function updateBookedSlotsDisplay() {
    const bookedSlotsContainer = document.getElementById(
        "bookedSlotsContainer"
    );
    const bookedSlots = document.getElementById("bookedSlots");

    if (bookedRanges.length > 0) {
        bookedSlots.innerHTML = "";
        bookedRanges.forEach((range) => {
            const slot = document.createElement("div");
            slot.className = "booked-slot";
            slot.textContent = `${range.start}:00 - ${range.end}:00`;
            bookedSlots.appendChild(slot);
        });
        bookedSlotsContainer.style.display = "block";
    } else {
        bookedSlotsContainer.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    updateAvailableHours();

    if ("{{ old('jam_mulai') }}" && "{{ old('jam_akhir') }}") {
        updateButtonStates();
        updateRangeDisplay();
    }
});
