document.addEventListener("DOMContentLoaded", () => {
  const studentForm = document.querySelector("#student-form");
  const lecturerForm = document.querySelector("#lecturer-form");
  const bookingForm = document.querySelector("#booking-form");
  const lecturerSelect = document.querySelector("#lecturer_id");
  const slotSelect = document.querySelector("#time_slot");

  function validEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  }

  function applyFormValidation(form) {
    if (!form) return;
    form.addEventListener("submit", (e) => {
      const emailInput = form.querySelector("input[type='email']");
      const required = form.querySelectorAll("[required]");

      for (const field of required) {
        if (!String(field.value).trim()) {
          e.preventDefault();
          alert("Please fill in all required fields.");
          return;
        }
      }

      if (emailInput && !validEmail(emailInput.value.trim())) {
        e.preventDefault();
        alert("Please enter a valid email address.");
      }
    });
  }

  function updateSlots() {
    if (!lecturerSelect || !slotSelect) return;
    const selected = lecturerSelect.options[lecturerSelect.selectedIndex];
    const slotsData = selected?.dataset?.slots || "";
    const slots = slotsData
      .split(",")
      .map((s) => s.trim())
      .filter(Boolean);

    slotSelect.innerHTML = "";
    if (!slots.length) {
      const option = document.createElement("option");
      option.value = "";
      option.textContent = "-- Select lecturer first --";
      slotSelect.appendChild(option);
      return;
    }

    slots.forEach((slot) => {
      const option = document.createElement("option");
      option.value = slot;
      option.textContent = slot;
      slotSelect.appendChild(option);
    });
  }

  if (lecturerSelect && slotSelect) {
    lecturerSelect.addEventListener("change", updateSlots);
    updateSlots();
  }

  applyFormValidation(studentForm);
  applyFormValidation(lecturerForm);
  applyFormValidation(bookingForm);
});

