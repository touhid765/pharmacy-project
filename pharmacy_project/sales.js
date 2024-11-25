// document.getElementById('salesForm').addEventListener('submit', function (e) {
//     e.preventDefault();

//     // Get form values
//     const itemName = document.getElementById('itemName').value;
//     const itemPrice = parseFloat(document.getElementById('itemPrice').value);
//     const quantity = parseInt(document.getElementById('quantity').value);
//     const discount = parseFloat(document.getElementById('discount').value);

//     // Calculate discount amount and total price
//     const discountAmount = (itemPrice * discount) / 100;
//     const totalPrice = (itemPrice - discountAmount) * quantity;

//     // Add to table
//     const tableBody = document.querySelector('#salesTable tbody');
//     const newRow = document.createElement('tr');

//     newRow.innerHTML = `
//         <td>${itemName}</td>
//         <td>$${itemPrice.toFixed(2)}</td>
//         <td>${quantity}</td>
//         <td>${discount}%</td>
//         <td>$${totalPrice.toFixed(2)}</td>
//     `;

//     tableBody.appendChild(newRow);

//     // Update total sales
//     const currentTotal = parseFloat(document.getElementById('totalSales').textContent);
//     document.getElementById('totalSales').textContent = (currentTotal + totalPrice).toFixed(2);

//     // Clear form inputs
//     document.getElementById('salesForm').reset();
// });


document.addEventListener('DOMContentLoaded', function() {
    // Load stored sales data
    loadSalesData();

    // Add event listener for the form submission
    document.getElementById('sales-form').addEventListener('submit', function(e) {
        e.preventDefault();
        addSale();
    });

    // Calculate total amount automatically
    document.getElementById('quantity').addEventListener('input', calculateTotalAmount);
    document.getElementById('selling-price').addEventListener('input', calculateTotalAmount);
});

// Function to calculate total amount
function calculateTotalAmount() {
    const quantity = document.getElementById('quantity').value;
    const sellingPrice = document.getElementById('selling-price').value;
    const totalAmount = quantity * sellingPrice;
    document.getElementById('total-amount').value = totalAmount || 0;
}

// Function to add sale to the table and store in local storage
function addSale() {
    const date = document.getElementById('date').value;
    const customerId = document.getElementById('customer-id').value;
    const medicineName = document.getElementById('medicine-name').value;
    const quantity = document.getElementById('quantity').value;
    const sellingPrice = document.getElementById('selling-price').value;
    const totalAmount = document.getElementById('total-amount').value;

    // Create sale object
    const sale = {
        date,
        customerId,
        medicineName,
        quantity,
        sellingPrice,
        totalAmount
    };

    // Get existing sales from local storage or create a new array
    let salesData = JSON.parse(localStorage.getItem('salesData')) || [];
    salesData.push(sale);

    // Save updated sales data to local storage
    localStorage.setItem('salesData', JSON.stringify(salesData));

    // Reload the sales table
    loadSalesData();

    // Reset form after adding the sale
    document.getElementById('sales-form').reset();
    document.getElementById('total-amount').value = 0;
}

// Function to load sales data from local storage and display it
function loadSalesData() {
    const salesData = JSON.parse(localStorage.getItem('salesData')) || [];
    const salesTableBody = document.getElementById('sales-data');

    // Clear existing table rows
    salesTableBody.innerHTML = '';

    // Loop through sales data and create table rows
    salesData.forEach((sale, index) => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${sale.date}</td>
            <td>${sale.medicineName}</td>
            <td>${sale.sellingPrice}</td>
            <td>${sale.quantity}</td>
            <td>${sale.totalAmount}</td>
            <td><button class="delete-button" onclick="deleteSale(${index})">Delete</button></td>
        `;

        salesTableBody.appendChild(row);
    });
}

// Function to delete a sale from the table and local storage
function deleteSale(index) {
    let salesData = JSON.parse(localStorage.getItem('salesData')) || [];

    // Remove the sale from the array
    salesData.splice(index, 1);

    // Update local storage with the new data
    localStorage.setItem('salesData', JSON.stringify(salesData));

    // Reload the sales table
    loadSalesData();
}

