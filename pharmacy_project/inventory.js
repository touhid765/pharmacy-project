// Initial inventory data, only used if Local Storage is empty
const defaultInventoryData = [
    { id: 1, name: 'Amoxicillin 250 mg', stockIn: 500, stockOut: 0, expired: 0 },
    { id: 2, name: 'Cephalexin 250 mg', stockIn: 500, stockOut: 31, expired: 0 },
    { id: 3, name: 'Demerol 100 mg', stockIn: 310, stockOut: 0, expired: 0 },
    { id: 4, name: 'Demerol 50 mg', stockIn: 300, stockOut: 20, expired: 0 },
    { id: 5, name: 'Hydromorphone 2 mg', stockIn: 300, stockOut: 0, expired: 0 },
    { id: 6, name: 'Pyridoxine 50 mg', stockIn: 0, stockOut: 0, expired: 0 },
    { id: 7, name: 'Sample Med 500 mg', stockIn: 500, stockOut: 0, expired: 0 },
    { id: 8, name: 'Ibuprofen 200 mg', stockIn: 1000, stockOut: 100, expired: 5 },
    { id: 9, name: 'Paracetamol 500 mg', stockIn: 600, stockOut: 250, expired: 2 },
    { id: 10, name: 'Aspirin 100 mg', stockIn: 800, stockOut: 50, expired: 0 },
    { id: 11, name: 'Atorvastatin 10 mg', stockIn: 400, stockOut: 30, expired: 1 },
    { id: 12, name: 'Metformin 500 mg', stockIn: 500, stockOut: 200, expired: 0 }
];

// Function to get data from Local Storage or initialize with default data
function getInventoryData() {
    const data = localStorage.getItem('inventoryData');
    return data ? JSON.parse(data) : defaultInventoryData;
}

// Save data to Local Storage
function saveInventoryData() {
    localStorage.setItem('inventoryData', JSON.stringify(inventoryData));
}

// Initialize inventory data
let inventoryData = getInventoryData();

// Function to display inventory data in the table
function loadInventory() {
    const tableBody = document.getElementById('inventory-table');
    tableBody.innerHTML = '';

    inventoryData.forEach((item, index) => {
        const stockAvailable = item.stockIn - item.stockOut - item.expired;
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${item.name}</td>
                <td>${item.stockIn}</td>
                <td>${item.stockOut}</td>
                <td>${item.expired}</td>
                <td>${stockAvailable}</td>
                <td>
                    <button onclick="updateProduct(${item.id})">Update</button>
                    <button onclick="deleteProduct(${item.id})">Delete</button>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Function to delete a product
function deleteProduct(id) {
    inventoryData = inventoryData.filter(item => item.id !== id);
    saveInventoryData();
    loadInventory();
}

// Function to update a product
function updateProduct(id) {
    const product = inventoryData.find(item => item.id === id);
    if (product) {
        const newStockIn = prompt("Enter new Stock In value:", product.stockIn);
        const newStockOut = prompt("Enter new Stock Out value:", product.stockOut);
        const newExpired = prompt("Enter new Expired value:", product.expired);

        if (newStockIn !== null) product.stockIn = parseInt(newStockIn);
        if (newStockOut !== null) product.stockOut = parseInt(newStockOut);
        if (newExpired !== null) product.expired = parseInt(newExpired);

        saveInventoryData();
        loadInventory();
    }
}

// Function to add a new product
function addMedicine() {
    const name = document.getElementById('new-product-name').value;
    const stockIn = parseInt(document.getElementById('new-stock-in').value) || 0;
    const stockOut = parseInt(document.getElementById('new-stock-out').value) || 0;
    const expired = parseInt(document.getElementById('new-expired').value) || 0;

    if (name) {
        const newProduct = {
            id: inventoryData.length ? inventoryData[inventoryData.length - 1].id + 1 : 1,
            name,
            stockIn,
            stockOut,
            expired
        };

        inventoryData.push(newProduct);
        saveInventoryData();
        loadInventory();

        // Clear input fields
        document.getElementById('new-product-name').value = '';
        document.getElementById('new-stock-in').value = '';
        document.getElementById('new-stock-out').value = '';
        document.getElementById('new-expired').value = '';
    } else {
        alert("Please enter a product name.");
    }
}

// Load the inventory data on page load
window.onload = loadInventory;








