

async function updateTable() {
    try {
        const response = await fetch('/GroupProject_SE/View/admin/staff.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'read' })
        });
        const staff_members = await response.json();
        const tableBody = document.querySelector("#user-table tbody");
        tableBody.querySelectorAll('tr').forEach(row => row.remove());

        staff_members.forEach(staff => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${staff.staff_id}</td>
                <td>${staff.branch_name}</td>
                <td>${staff.full_name}</td>
                <td>${staff.role_name}</td>
                <td>
                    <button id="editButton"${staff.staff_id}">View</button> |
                    <button id="deleteButton${staff.staff_id}" class="deleteButton">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error("Error updating table:", error);
    }
}




// Delete Product
document.getElementById("user-table").addEventListener("click", async function (event) {
    if (event.target.id.startsWith("deleteButton")) {
        const staffId = event.target.id.replace("deleteButton", ""); // Extract product ID
        console.log(staffId);
        if (confirm(`Are you sure you want to delete this account?`)) {
            try {
                const response = await fetch('/GroupProject_SE/View/admin/staff.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'delete',
                        staffID: staffId
                    })
                });
                const result = await response.json();
                if (result.success) {
                    await updateTable();
                } else {
                    console.error("Failed to delete account:", result.message);
                }
            } catch (error) {
                console.error("Error deleting account:", error);
            }
        }
    }
});


