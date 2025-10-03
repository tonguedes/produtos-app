import Chart from 'chart.js/auto';

// Gráfico de categorias
if (document.getElementById('productsByCategoryChart')) {
    new Chart(document.getElementById('productsByCategoryChart'), {
        type: 'doughnut',
        data: {
            labels: ['Bebidas', 'Doces', 'Salgados', 'Outros'],
            datasets: [{
                data: [12, 19, 7, 5],
                backgroundColor: ['#3b82f6','#10b981','#f43f5e','#f59e0b','#a855f7'],
            }]
        }
    });
}

// Gráfico por mês
if (document.getElementById('productsByMonthChart')) {
    new Chart(document.getElementById('productsByMonthChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai'],
            datasets: [{
                label: 'Produtos',
                data: [5, 10, 8, 15, 12],
                backgroundColor: '#6366f1'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}
