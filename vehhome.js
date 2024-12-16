document.addEventListener("DOMContentLoaded", function () {
    const fields = [
        { id: "rfid", hint: "This is a unique number printed on your RFID tag." },
        { id: "vehname", hint: "Enter the brand and model of your vehicle (e.g., Toyota Corolla)." },
        { id: "vehcolor", hint: "Specify the color of your vehicle (e.g., Red, Blue, Black)." },
        { id: "vehplate", hint: "Provide the license plate number of your vehicle." },
        { id: "payclass", hint: "Choose the payment class based on your vehicle type (e.g., Class A, B)." },
        { id: "vehtype", hint: "Specify the type of your vehicle (e.g., Sedan, SUV, Truck)." }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        const hint = document.getElementById(`${field.id}-hint`);

        input.addEventListener("focus", () => {
            hint.style.display = "block";
        });

        input.addEventListener("blur", () => {
            hint.style.display = "none";
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Add event listeners for Payment Class and Vehicle Type dropdowns
    const payclassDropdown = document.getElementById("payclass");
    const vehtypeDropdown = document.getElementById("vehtype");

    const payclassHint = document.getElementById("payclass-hint");
    const vehtypeHint = document.getElementById("vehtype-hint");

    payclassDropdown.addEventListener("change", () => {
        if (payclassDropdown.value) {
            payclassHint.style.display = "block";
            payclassHint.textContent = `You selected ${payclassDropdown.value}`;
        } else {
            payclassHint.style.display = "none";
        }
    });

    vehtypeDropdown.addEventListener("change", () => {
        if (vehtypeDropdown.value) {
            vehtypeHint.style.display = "block";
            vehtypeHint.textContent = `You selected ${vehtypeDropdown.value}`;
        } else {
            vehtypeHint.style.display = "none";
        }
    });
});
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');
}
