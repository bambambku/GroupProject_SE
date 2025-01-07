



var modal = document.getElementById("modalWindowBranches");


var closeBtn = document.getElementById("closeButton");
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// Update Table, avoids the need to refresh page
async function updateTable() {
    try {
        const response = await fetch('/GroupProject_SE/View/admin/branches.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'read' })
        });
        
        const branches = await response.json();
        const tableBody = document.querySelector("#branches-table tbody");
        
        tableBody.querySelectorAll('tr').forEach(row => row.remove());

        // Loop through each branch in the response
        branches.forEach(branch => {
            const row = document.createElement("tr");
            
            row.innerHTML = `
                <td>${branch.branch_id}</td>
                <td>${branch.branch_name}</td>
                <td>${branch.town}</td>
                <td>${branch.postal_code}</td>
                <td>${branch.num_staff}</td> <!-- Number of staff per branch -->
                <td>
                    <button class="editButton" data-id="${branch.branch_id}">Edit</button> |
                    <button id="deleteButton${branch.branch_id}" class="deleteButton">Delete</button>
                </td>
            `;
            
            // Append the row to the table
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error("Error updating table:", error);
    }
}


// Delete Product
document.getElementById("branches-table").addEventListener("click", async function (event) {
    if (event.target.id.startsWith("deleteButton")) {
        const branchId = event.target.id.replace("deleteButton", ""); // Extract branch ID
        console.log(branchId);
        if (confirm(`Are you sure you want to delete this branch? All accounts associated will be removed.`)) {
            try {
                const response = await fetch('/GroupProject_SE/View/admin/branches.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'delete',
                        branchID: branchId
                    })
                });
                const result = await response.json();
                if (result.success) {
                    await updateTable();
                } else {
                    console.error("Failed to delete branch:", result.message);
                }
            } catch (error) {
                console.error("Error deleting branch:", error);
            }
        }
    }
});

