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
    const response = await fetch('../Model/add_product.php', {
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
        fetch('../Model/delete_product.php',{
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

// Edit Products
var editButtons = document.getElementById("[id^='editButton']");
editButtons.forEach(button => {
    button.onclick = function(){
        const productId = this.id.replace("editButton", "");
        
    
    }

})

// Product Details