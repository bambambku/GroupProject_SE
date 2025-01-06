document.addEventListener('DOMContentLoaded', () => {
    // LowapplyStockStyling();
});
let currentEditingProductId = null;


// Add Button Modal
var modal = document.getElementById("modalWindowProducts");
var openBtn = document.getElementById("addNewProductBtn");

openBtn.onclick = function() {
    modal.style.display = "flex";
}

var closeBtn = document.getElementById("closeButton");
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// Update Table, avoids the need to refresh page
async function updateTable() {
    try {
        const response = await fetch('/GroupProject_SE/View/Manager/manager.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'read' })
        });
        const allstaff = await response.json();
        const tableBody = document.querySelector("#staffTable tbody");
        tableBody.querySelectorAll('tr').forEach(row => row.remove());

        allstaff.forEach(staff => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${staff.f_name}</td>
                <td>${staff.l_name}</td>
                <td>${staff.password}</td>
                <td>${staff.branch_id}</td>
                <td>${staff.role_id}</td>
                <td>${staff.email}</td>
                <td>
                    <button class="editButton" data-id="${staff.ID}">Edit</button> |
                    <button id="deleteButton${staff.ID}" class="deleteButton">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error("Error updating table:", error);
    }
}

// Add Product
var addBtn = document.getElementById("addButton");

addBtn.onclick = async function() {

    const productName = document.getElementById("productName").value;
    const productDescription = document.getElementById("productDescription").value;
    const productPrice = document.getElementById("productPrice").value;
    const productWeight = document.getElementById("productWeight").value;
    const productSize = document.getElementById("productSize").value;
    const productCPU = document.getElementById("productCPU").value;
    const productGPU = document.getElementById("productGPU").value;
    const productRAM = document.getElementById("productRAM").value;
    const productHardDrive = document.getElementById("productHard-Drive").value;
    const productStock = document.getElementById("productStock").value;
    const productBranch = document.getElementById("productBranch").value;
    // Need to add specific validation
    if (!productName || !productDescription || !productPrice || !productWeight || !productSize || !productCPU || !productGPU || !productRAM || !productHardDrive || !productStock || !productBranch) {
        alert('Please fill in all fields.');
        return;
    }

    const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'create',
            name: productName,
            description: productDescription,
            price: productPrice,
            weight: productWeight,
            size: productSize,
            CPU: productCPU,
            GPU: productGPU,
            RAM: productRAM,
            hard_drive: productHardDrive,
            stock: productStock,
            branch: productBranch
        })
    });
    const result = await response.json();
    if (result.success) {
        await updateTable();
        modal.style.display = "none";
    }
    else{
        console.error("Error adding product");
    }
};

// Delete Staff Member ? Maybe Not used by manager but by admin?
document.getElementById("staffTable").addEventListener("click", async function (event) {
    if (event.target.id.startsWith("deleteButton")) {
        const staffID = event.target.id.replace("deleteButton", ""); // Extract product ID

        if (confirm(`Are you sure you want to delete this product?`)) {
            try {
                const response = await fetch('/GroupProject_SE/View/stockManager/manager.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'delete',
                        productID: staffID
                    })
                });
                const result = await response.json();
                if (result.success) {
                    await updateTable();
                } else {
                    console.error("Failed to delete product:", result.message);
                }
            } catch (error) {
                console.error("Error deleting product:", error);
            }
        }
    }
});

// Edit Button
document.getElementById("staffTable").addEventListener("click", async function (event) {
    if (event.target.classList.contains("editButton")) {
        const productId = event.target.getAttribute('data-id');
        currentEditingProductId = productId;
        
        try {
            const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'read',
                    productID: productId
                })
            });

            const product = await response.json();

            if (product) {
                document.getElementById("editProductName").value = product.name;
                document.getElementById("editProductDescription").value = product.description;
                document.getElementById("editProductPrice").value = product.price;
                document.getElementById("editProductWeight").value = product.weight;
                document.getElementById("editProductSize").value = product.size;
                document.getElementById("editProductCPU").value = product.CPU;
                document.getElementById("editProductGPU").value = product.GPU;
                document.getElementById("editProductRAM").value = product.RAM;
                document.getElementById("editProductHardDrive").value = product.hard_drive;
                document.getElementById("editProductStock").value = product.quantity;

                document.getElementById("modalWindowProductsEdit").style.display = "flex";
            } else {
                console.error('Product not found.');
            }
        } catch (error) {
            console.error("Failed to fetch product details for editing:", error);
        }
    }
});

// Save Edit Button
document.getElementById("saveEditButton").onclick = async function () {
    const productId = currentEditingProductId;

    const productName = document.getElementById("editProductName").value;
    const productDescription = document.getElementById("editProductDescription").value;
    const productPrice = document.getElementById("editProductPrice").value;
    const productWeight = document.getElementById("editProductWeight").value;
    const productSize = document.getElementById("editProductSize").value;
    const productCPU = document.getElementById("editProductCPU").value;
    const productGPU = document.getElementById("editProductGPU").value;
    const productRAM = document.getElementById("editProductRAM").value;
    const productHardDrive = document.getElementById("editProductHardDrive").value;
    const productStock = document.getElementById("editProductStock").value;

    try {
        const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'update',
                productID: productId,
                name: productName,
                description: productDescription,
                price: productPrice,
                weight: productWeight,
                size: productSize,
                CPU: productCPU,
                GPU: productGPU,
                RAM: productRAM,
                hard_drive: productHardDrive,
                quantity: productStock
            })
        });

        const result = await response.json();

        if (result.success) {
            await updateTable();
            document.getElementById("modalWindowProductsEdit").style.display = "none";
            currentEditingProductId = null;
        } else {
            console.error("Failed to update product:", result.message);
        }
    } catch (error) {
        console.error("Error saving product edits:", error);
    }
};
const closeButtonEdit = document.getElementById("closeButtonEdit");

closeButtonEdit.onclick = function () {
    document.getElementById("modalWindowProductsEdit").style.display = "none";
    currentEditingProductId = null;
};

// Sort By
var sortButton = document.getElementById("sortButton");
var sortSelect = document.getElementById("sortSelect");

sortButton.onclick = async function() {
    const sortOption = sortSelect.value;

    try {
        const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'sort',
                sortOption: sortOption
            })
        });

        const sortedProducts = await response.json();
        
        const tableBody = document.querySelector("#staffTable tbody");
        tableBody.innerHTML = '';

        sortedProducts.forEach(product => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.price}</td>
                <td>${product.weight}</td>
                <td>${product.size}</td>
                <td>${product.CPU}</td>
                <td>${product.GPU}</td>
                <td>${product.RAM}</td>
                <td>${product.hard_drive}</td>
                <td>${product.quantity !== null ? product.quantity : 'N/A'}</td>
                <td>
                    <button class="editButton" data-id="${product.ID}">Edit</button> |
                    <button id="deleteButton${product.ID}" class="deleteButton">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

    } catch (error) {
        console.error("Error sorting products:", error);
    }
};


// Search Button

var searchButton = document.getElementById("searchButton");
var searchInput = document.getElementById("searchInput");
// If valid input, ,repopulate table ,Bring relevant rows to the top of table.

searchButton.onclick = async function(){
    if (searchInput){

    }
}



// Table Drop Sort

const sortDropdown = document.getElementById('sortSelect');
const table = document.getElementById('staffTable');
const tbody = table.querySelector('tbody')
// Function to sort table rows
function sortTable(columnIndex, isNumeric = true) {
    const rows = Array.from(tbody.rows)
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim()
        // Compare numeric or text values
        return isNumeric ? (parseFloat(aText) - parseFloat(bText)) : aText.localeCompare(bText);
    })
    // Clear and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}

// Event listener for dropdown change
sortDropdown.addEventListener('change', () => {
    switch (sortDropdown.value) {
        case 'staffID': sortTable(0); break;
        case 'forename': sortTable(1); break;
        case 'surname': sortTable(2); break;
        case 'branchID': sortTable(4); break;
        case 'roleID': sortTable(5); break;
    }
})