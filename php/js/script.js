const ctx = document.getElementById('financeChart');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Thu nhập', 'Chi tiêu'],
        datasets: [{
            data: [8000000, 3500000],
            backgroundColor: ['#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
