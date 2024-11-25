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
// Opens modal and fills fields, WHERE ID = productId
var editButtons = document.querySelectorAll("[id^='editButton']");

editButtons.forEach(button => {
    button.onclick = async function(){
        const productId = this.id.replace("editButton", "");
        const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'read',
                productID: productId
            })
        });
        const product = await response.json();

        document.getElementById("editProductId").value = product.id;
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
    }
})

var closeButtonEdit = document.getElementById("closeButtonEdit")

closeButtonEdit.onclick = function() {
    document.getElementById("modalWindowProductsEdit").style.display = "none";
}

// Save button within Edit Modal
var saveEditButton = document.getElementById("saveEditButton");

saveEditButton.onclick = async function(){
    const productId = document.getElementById("editProductId").value;
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
            stock: productStock
        })
    });
    const result = await response.json();
    if (result.success) {
        window.location.reload();
        document.getElementById("modalWindowProductsEdit").style.display = "none";
    } else {
        console.error("Failed to update product:", result.message);
    }
}

// Product Details
var detailsButtons = document.querySelectorAll("[id^='detailsButton']");
var closeButtonDetails = document.getElementById("closeButtonDetails");

closeButtonDetails.onclick = function() {
    document.getElementById("modalWindowProductDetails").style.display = "none";
};

detailsButtons.forEach(button => {
    button.onclick = async function() {
        const productId = this.getAttribute("data-id");

        const response = await fetch('/GroupProject_SE/View/stockManager/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'details',
                productID: productId
            })
        });

        const product = await response.json();
            document.getElementById("detailsName").textContent = product.name;
            document.getElementById("detailsDescription").textContent = product.description;
            document.getElementById("detailsPrice").textContent = product.price;
            document.getElementById("detailsWeight").textContent = product.weight;
            document.getElementById("detailsSize").textContent = product.size;
            document.getElementById("detailsCPU").textContent = product.CPU;
            document.getElementById("detailsGPU").textContent = product.GPU;
            document.getElementById("detailsRAM").textContent = product.RAM;
            document.getElementById("detailsHardDrive").textContent = product.hard_drive;

            document.getElementById("modalWindowProductDetails").style.display = "block";
    }
});

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
    // Clear table and populate
    const tableBody = document.getElementById("productTableBody");

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
                <button data-id="${product.ID}" id="detailsButton${product.ID}">Details</button>
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



