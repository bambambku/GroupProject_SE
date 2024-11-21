const sortDropdown = document.getElementById('sortDropdown');
const table = document.getElementById('laptopTable');
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
        case 'name': sortTable(0); break;
        case 'price': sortTable(2); break;
        case 'ram': sortTable(7); break;
        case 'hard_drive': sortTable(8); break;
        case 'size': sortTable(4); break;
        case 'weight': sortTable(3); break;
    }
})