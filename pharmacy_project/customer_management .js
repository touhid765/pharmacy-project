document.addEventListener("DOMContentLoaded", () => {
    const customerForm = document.getElementById('customerForm');
    const customerRecords = document.getElementById('customerRecords');

    // Load existing customer records from local storage
    loadCustomerRecords();

    customerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const customerName = document.getElementById('customerName').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const medicines = document.getElementById('medicines').value;
        const discount = document.getElementById('discount').value;
        const totalAmount = document.getElementById('totalAmount').value;
        const paidStatus = document.getElementById('paidStatus').value;

        const customerData = {
            customerName,
            phoneNumber,
            medicines,
            discount,
            totalAmount,
            paidStatus
        };

        // Store in local storage
        storeCustomerData(customerData);

        // Clear the form
        customerForm.reset();

        // Load updated records
        loadCustomerRecords();
    });

    function storeCustomerData(customerData) {
        let records = JSON.parse(localStorage.getItem('customerRecords')) || [];
        records.push(customerData);
        localStorage.setItem('customerRecords', JSON.stringify(records));
    }

    function loadCustomerRecords() {
        customerRecords.innerHTML = '';
        let records = JSON.parse(localStorage.getItem('customerRecords')) || [];
        
        records.forEach(record => {
            const recordDiv = document.createElement('div');
            recordDiv.className = 'record';
            recordDiv.innerHTML = `
                <strong>Name:</strong> ${record.customerName}<br>
                <strong>Phone:</strong> ${record.phoneNumber}<br>
                <strong>Medicines:</strong> ${record.medicines}<br>
                <strong>Discount:</strong> ${record.discount}<br>
                <strong>Total Amount:</strong> ${record.totalAmount}<br>
                <strong>Paid Status:</strong> ${record.paidStatus}
            `;
            customerRecords.appendChild(recordDiv);
        });
    }
});












