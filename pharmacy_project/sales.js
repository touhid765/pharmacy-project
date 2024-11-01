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
