let currentEditingProductId = null;
// Add Button Modal
var modal = document.getElementById("modalWindowProducts");
var openBtn = document.getElementById("modalButtonProducts");

openBtn.onclick = function() {
    modal.style.display = "flex";
}

var closeBtn = document.getElementById("closeButton");
closeBtn.onclick = function() {
  modal.style.display = "none";
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
        window.location.reload();
    }
};

// Delete Product
var deleteButtons = document.querySelectorAll("[id^='deleteButton']");

deleteButtons.forEach(button => {
    button.onclick = function(){
        if (confirm(`Are you sure you want to delete this product?`)){
            const productId = this.id.replace("deleteButton", "");

        fetch('/GroupProject_SE/View/stockManager/products.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'delete',
                productID: productId})
        })
        .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`#deleteButton${productId}`).closest("tr");
                    row.parentNode.removeChild(row);
                    window.location.reload();
                } else {
                    console.error("Failed to delete product:", data.message);
                }
            })
            .catch(error => console.error('Error deleting product:', error));
        }
    }
});

// Edit Button Modal
const editButtons = document.querySelectorAll('.editButton');

editButtons.forEach(button => {
    button.onclick = async function(event) {
        const productId = event.target.getAttribute('data-id');
        currentEditingProductId = productId;
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
            console.error('Product not found');
        }
    };
});

var closeButtonEdit = document.getElementById("closeButtonEdit");

closeButtonEdit.onclick = function() {
    document.getElementById("modalWindowProductsEdit").style.display = "none";
    currentEditingProductId = null;
};

// Save button within Edit Modal
var saveEditButton = document.getElementById("saveEditButton");

saveEditButton.onclick = async function(){
    const productId = currentEditingProductId; // Reuse stored productId
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
            window.location.reload();
            document.getElementById("modalWindowProductsEdit").style.display = "none";
        } 
    } catch (error) {
        console.error("Failed to update product:", error);
    }
};

// Sort By
var sortButton = document.getElementById("sortButton");
var sortSelect = document.getElementById("sortSelect");

sortButton.onclick = async function() {
    const sortOption = sortSelect.value;

    const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'sort',
            sortOption: sortOption
        })
    });

    const sortedProducts = await response.json();
    const table = document.getElementById("laptopTable");
    const rows = table.querySelectorAll("tr");
    rows.forEach((row, index) => {
        if (index !== 0) row.remove();
    });

    tableBody.innerHTML = '';

    sortedProducts.forEach(product => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${product.quantity}</td>
            <td>
                <button id="editButton${product.ID}">Edit</button>
                <button id="deleteButton${product.ID}">Delete</button>
                <button id="detailsButton${product.ID}">Details</button> |
            </td>
        `;
        tableBody.appendChild(row);
    });
};

// Search Button

var searchButton = document.getElementById("searchButton");
var searchInput = document.getElementById("searchInput");
// If valid input, ,repopulate table ,Bring relevant rows to the top of table.

searchButton.onclick = async function(){
    if (searchInput){

    }
}



