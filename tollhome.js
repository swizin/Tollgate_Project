document.addEventListener("DOMContentLoaded", () => {
    const navItems = document.querySelectorAll("nav ul li");
    const sections = document.querySelectorAll("#content > div");

    // Function to handle section switching
    navItems.forEach((item) => {
        item.addEventListener("click", () => {
            const targetSection = item.getAttribute("data-section");

            // Hide all sections
            sections.forEach((section) => {
                section.classList.add("hidden");
            });

            // Show the targeted section
            const activeSection = document.getElementById(targetSection);
            if (activeSection) {
                activeSection.classList.remove("hidden");
            }
        });
    });
});

// Simulating "Open Gate" functionality
function openGate() {
    alert("Gate opened successfully!");
    const paymentHistoryList = document.getElementById("paymentHistoryList");
    const newHistoryItem = document.createElement("li");
    newHistoryItem.textContent = "RFID Tag #12345: Payment verified, gate opened on " + new Date().toLocaleString();
    paymentHistoryList.appendChild(newHistoryItem);
}
