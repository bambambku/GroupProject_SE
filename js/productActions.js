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
    // Validation for fields, Don't allow null values etc

    // AJAX request to add the product
    const response = await fetch('../../Model/add_product.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            name: productName,
            description: productDescription,
            price: productPrice,
            weight: productWeight,
            size: productSize,
            CPU: productCPU,
            GPU: productGPU,
            RAM: productRAM,
            hard_drive: productHardDrive
        })
    });
    window.location.reload();
};

// Delete Product
var deleteButtons = document.querySelectorAll("[id^='deleteButton']");

deleteButtons.forEach(button => {
    button.onclick = function(){
        if (confirm(`Are you sure you want to delete this product?`)){
            const productId = this.id.replace("deleteButton", "");

        // AJAX request to delete product
        fetch('../../Model/delete_product.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ productID: productId})
        })
        .then(response => response.json())
        .then(data =>{
            if (!data.failure) {
                window.location.reload();  
            } else {
                console.error("Failed to delete product:", data.message);
            }
        })}
    }
});

// Edit Button Modal
// Opens modal and fills fields, WHERE ID = productId
var editButtons = document.querySelectorAll("[id^='editButton']");

editButtons.forEach(button => {
    button.onclick = async function(){
        
        const productId = this.id.replace("editButton", "");

        const response = await fetch('../../Model/get_product.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ productID: productId })
        });
        const product = await response.json();

        document.getElementById("editProductId").value = productId;
        document.getElementById("editProductName").value = product.name;
        document.getElementById("editProductDescription").value = product.description;
        document.getElementById("editProductPrice").value = product.price;
        document.getElementById("editProductWeight").value = product.weight;
        document.getElementById("editProductSize").value = product.size;
        document.getElementById("editProductCPU").value = product.CPU;
        document.getElementById("editProductGPU").value = product.GPU;
        document.getElementById("editProductRAM").value = product.RAM;
        document.getElementById("editProductHardDrive").value = product.hard_drive;
        
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

    const response = await fetch('../../Model/update_product.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            productID: productId,
            name: productName,
            description: productDescription,
            price: productPrice,
            weight: productWeight,
            size: productSize,
            CPU: productCPU,
            GPU: productGPU,
            RAM: productRAM,
            hard_drive: productHardDrive 
        })
    });
    const result = await response.json();
    if (result.success) {
        window.location.reload();
    } else {
        console.error("Failed to update product:", result.message);
    }
}

// Product Details

var detailsButton = document.getElementById("detailsButton");

detailsButton.onclick = async function(){

}

// Search Button

var searchButton = document.getElementById("searchButton");
var searchInput = document.getElementById("searchInput");
// If valid input, ,repopulate table ,Bring relevant rows to the top of table.

searchButton.onclick = async function(){
    if (searchInput){

    }
}

