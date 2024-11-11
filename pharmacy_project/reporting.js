// Predefined transactions for September and October 2024
const transactions = [
  { date: '2024-09-01', details: 'Sale of Paracetamol', amount: 200 },
  { date: '2024-09-03', details: 'Purchase of Amoxicillin', amount: -150 },
  { date: '2024-09-05', details: 'Sale of Cough Syrup', amount: 300 },
  { date: '2024-09-07', details: 'Purchase of Bandages', amount: -100 },
  { date: '2024-09-09', details: 'Sale of Ibuprofen', amount: 250 },
  { date: '2024-09-11', details: 'Purchase of Vitamin C', amount: -200 },
  { date: '2024-09-13', details: 'Sale of Antiseptic', amount: 350 },
  { date: '2024-09-15', details: 'Purchase of Insulin', amount: -300 },
  { date: '2024-09-17', details: 'Sale of Aspirin', amount: 150 },
  { date: '2024-09-19', details: 'Purchase of Cough Syrup', amount: -120 },
  { date: '2024-09-21', details: 'Sale of Paracetamol', amount: 200 },
  { date: '2024-09-23', details: 'Purchase of Bandages', amount: -50 },
  { date: '2024-09-25', details: 'Sale of Vitamin C', amount: 400 },
  { date: '2024-09-27', details: 'Purchase of Amoxicillin', amount: -250 },
  { date: '2024-09-29', details: 'Sale of Antiseptic', amount: 300 },
  { date: '2024-10-01', details: 'Sale of Cough Syrup', amount: 275 },
  { date: '2024-10-03', details: 'Purchase of Ibuprofen', amount: -200 },
  { date: '2024-10-05', details: 'Sale of Aspirin', amount: 180 },
  { date: '2024-10-07', details: 'Purchase of Insulin', amount: -320 },
  { date: '2024-10-09', details: 'Sale of Paracetamol', amount: 225 },
  { date: '2024-10-11', details: 'Purchase of Bandages', amount: -90 },
  { date: '2024-10-13', details: 'Sale of Ibuprofen', amount: 260 },
  { date: '2024-10-15', details: 'Purchase of Vitamin C', amount: -150 },
  { date: '2024-10-17', details: 'Sale of Antiseptic', amount: 325 },
  { date: '2024-10-19', details: 'Purchase of Cough Syrup', amount: -170 },
  { date: '2024-10-21', details: 'Sale of Aspirin', amount: 190 },
  { date: '2024-10-23', details: 'Purchase of Insulin', amount: -220 },
  { date: '2024-10-25', details: 'Sale of Vitamin C', amount: 310 },
  { date: '2024-10-27', details: 'Purchase of Amoxicillin', amount: -280 },
  { date: '2024-10-29', details: 'Sale of Paracetamol', amount: 240 },
];

function viewRecords() {
  const startDate = document.getElementById('startDate').value;
  const endDate = document.getElementById('endDate').value;
  const reportResults = document.getElementById('reportResults');

  // Clear previous results
  reportResults.innerHTML = '';

  if (!startDate || !endDate) {
    reportResults.innerHTML = '<p style="color: red;">Please select both start and end dates.</p>';
    return;
  }

  // Filter transactions within the selected date range
  const filteredTransactions = transactions.filter(transaction => {
    return transaction.date >= startDate && transaction.date <= endDate;
  });

  if (filteredTransactions.length === 0) {
    reportResults.innerHTML = '<p>No transactions found for the selected date range.</p>';
    return;
  }

  // Display filtered transactions
  filteredTransactions.forEach(transaction => {
    const transactionItem = document.createElement('div');
    transactionItem.className = 'report-item';
    transactionItem.innerHTML = `
      <p><strong>Date:</strong> ${transaction.date}</p>
      <p><strong>Details:</strong> ${transaction.details}</p>
      <p><strong>Amount:</strong> $${transaction.amount}</p>
    `;
    reportResults.appendChild(transactionItem);
  });
}



  
  