



// Add Button Modal
var modal = document.getElementById("modalWindowBranches");
//var openBtn = document.getElementById("addNewProductBtn");

// openBtn.onclick = function() {
//     modal.style.display = "flex";
// }

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
        
        // Remove all existing rows from the table
        tableBody.querySelectorAll('tr').forEach(row => row.remove());

        // Loop through each branch in the response
        branches.forEach(branch => {
            const row = document.createElement("tr");
            
            // Fill in the row with branch data and staff count
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


// Add Product
// var addBtn = document.getElementById("addButton");

// addBtn.onclick = async function() {

//     const productName = document.getElementById("productName").value;
//     const productDescription = document.getElementById("productDescription").value;
//     const productPrice = document.getElementById("productPrice").value;
//     const productWeight = document.getElementById("productWeight").value;
//     const productSize = document.getElementById("productSize").value;
//     const productCPU = document.getElementById("productCPU").value;
//     const productGPU = document.getElementById("productGPU").value;
//     const productRAM = document.getElementById("productRAM").value;
//     const productHardDrive = document.getElementById("productHard-Drive").value;
//     const productStock = document.getElementById("productStock").value;
//     const productBranch = document.getElementById("productBranch").value;
//     // Need to add specific validation
//     if (!productName || !productDescription || !productPrice || !productWeight || !productSize || !productCPU || !productGPU || !productRAM || !productHardDrive || !productStock || !productBranch) {
//         alert('Please fill in all fields.');
//         return;
//     }

//     const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify({
//             action: 'create',
//             name: productName,
//             description: productDescription,
//             price: productPrice,
//             weight: productWeight,
//             size: productSize,
//             CPU: productCPU,
//             GPU: productGPU,
//             RAM: productRAM,
//             hard_drive: productHardDrive,
//             stock: productStock,
//             branch: productBranch
//         })
//     });
//     const result = await response.json();
//     if (result.success) {
//         await updateTable();
//         modal.style.display = "none";
//     }
//     else{
//         console.error("Error adding product");
//     }
// };

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

// Edit Button
// document.getElementById("laptopTable").addEventListener("click", async function (event) {
//     if (event.target.classList.contains("editButton")) {
//         const productId = event.target.getAttribute('data-id');
//         currentEditingProductId = productId;
        
//         try {
//             const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
//                 method: 'POST',
//                 headers: { 'Content-Type': 'application/json' },
//                 body: JSON.stringify({
//                     action: 'read',
//                     productID: productId
//                 })
//             });

//             const product = await response.json();

//             if (product) {
//                 document.getElementById("editProductName").value = product.name;
//                 document.getElementById("editProductDescription").value = product.description;
//                 document.getElementById("editProductPrice").value = product.price;
//                 document.getElementById("editProductWeight").value = product.weight;
//                 document.getElementById("editProductSize").value = product.size;
//                 document.getElementById("editProductCPU").value = product.CPU;
//                 document.getElementById("editProductGPU").value = product.GPU;
//                 document.getElementById("editProductRAM").value = product.RAM;
//                 document.getElementById("editProductHardDrive").value = product.hard_drive;
//                 document.getElementById("editProductStock").value = product.quantity;

//                 document.getElementById("modalWindowProductsEdit").style.display = "flex";
//             } else {
//                 console.error('Product not found.');
//             }
//         } catch (error) {
//             console.error("Failed to fetch product details for editing:", error);
//         }
//     }
// });

// // Save Edit Button
// document.getElementById("saveEditButton").onclick = async function () {
//     const productId = currentEditingProductId;

//     const productName = document.getElementById("editProductName").value;
//     const productDescription = document.getElementById("editProductDescription").value;
//     const productPrice = document.getElementById("editProductPrice").value;
//     const productWeight = document.getElementById("editProductWeight").value;
//     const productSize = document.getElementById("editProductSize").value;
//     const productCPU = document.getElementById("editProductCPU").value;
//     const productGPU = document.getElementById("editProductGPU").value;
//     const productRAM = document.getElementById("editProductRAM").value;
//     const productHardDrive = document.getElementById("editProductHardDrive").value;
//     const productStock = document.getElementById("editProductStock").value;

//     try {
//         const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/json' },
//             body: JSON.stringify({
//                 action: 'update',
//                 productID: productId,
//                 name: productName,
//                 description: productDescription,
//                 price: productPrice,
//                 weight: productWeight,
//                 size: productSize,
//                 CPU: productCPU,
//                 GPU: productGPU,
//                 RAM: productRAM,
//                 hard_drive: productHardDrive,
//                 quantity: productStock
//             })
//         });

//         const result = await response.json();

//         if (result.success) {
//             await updateTable();
//             document.getElementById("modalWindowProductsEdit").style.display = "none";
//             currentEditingProductId = null;
//         } else {
//             console.error("Failed to update product:", result.message);
//         }
//     } catch (error) {
//         console.error("Error saving product edits:", error);
//     }
// };
// const closeButtonEdit = document.getElementById("closeButtonEdit");

// closeButtonEdit.onclick = function () {
//     document.getElementById("modalWindowProductsEdit").style.display = "none";
//     currentEditingProductId = null;
// };

// // Sort By
// var sortButton = document.getElementById("sortButton");
// var sortSelect = document.getElementById("sortSelect");

// sortButton.onclick = async function() {
//     const sortOption = sortSelect.value;

//     try {
//         const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/json' },
//             body: JSON.stringify({
//                 action: 'sort',
//                 sortOption: sortOption
//             })
//         });

//         const sortedProducts = await response.json();
        
//         const tableBody = document.querySelector("#laptopTable tbody");
//         tableBody.innerHTML = '';

//         sortedProducts.forEach(product => {
//             const row = document.createElement("tr");
//             row.innerHTML = `
//                 <td>${product.name}</td>
//                 <td>${product.description}</td>
//                 <td>${product.price}</td>
//                 <td>${product.weight}</td>
//                 <td>${product.size}</td>
//                 <td>${product.CPU}</td>
//                 <td>${product.GPU}</td>
//                 <td>${product.RAM}</td>
//                 <td>${product.hard_drive}</td>
//                 <td>${product.quantity !== null ? product.quantity : 'N/A'}</td>
//                 <td>
//                     <button class="editButton" data-id="${product.ID}">Edit</button> |
//                     <button id="deleteButton${product.ID}" class="deleteButton">Delete</button>
//                 </td>
//             `;
//             tableBody.appendChild(row);
//         });

//     } catch (error) {
//         console.error("Error sorting products:", error);
//     }
//     applyLowStockStyling();
// };


// function applyLowStockStyling() {
//     const rows = document.querySelectorAll('#laptopTable tbody tr');

//     rows.forEach(row => {
//         const quantityCell = row.querySelector('td:nth-child(10)');
//         const productNameCell = row.querySelector('td:nth-child(1)');

//         const quantity = parseInt(quantityCell.textContent, 10);

//         if (!isNaN(quantity) && quantity < 10) {
//             quantityCell.style.color = 'red';
//             productNameCell.style.color = 'red';
//         } else {
//             quantityCell.style.color = '';
//             productNameCell.style.color = '';
//         }
//     });
// }

// // Search Button

// var searchButton = document.getElementById("searchButton");
// var searchInput = document.getElementById("searchInput");
// // If valid input, ,repopulate table ,Bring relevant rows to the top of table.

// searchButton.onclick = async function(){
//     if (searchInput){

//     }
// }

