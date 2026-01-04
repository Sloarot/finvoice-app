@extends('components.layout')

@section('title', 'Charts')
@section('page_title', 'Invoice Analytics')

@section('content')
    <!-- Monthly Invoice Totals Bar Chart -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Monthly Invoice Totals (EUR)</h3>
        <div class="relative" style="height: 400px;">
            <canvas id="monthlyInvoicesChart"></canvas>
        </div>
    </div>

    <!-- Yearly Total Summary -->
    <div class="mb-8 bg-[#702963] text-white rounded-lg p-6">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold">Total Income This Year</h3>
            <div class="text-3xl font-bold" id="yearlyTotal">Loading...</div>
        </div>
    </div>

    <!-- Client Revenue Distribution Pie Chart -->
    <div>
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Client Revenue Distribution</h3>
        <div class="relative" style="height: 400px;">
            <canvas id="topClientsChart"></canvas>
        </div>
    </div>
@endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch and display yearly total
            fetch('{{ route('api.charts.yearly') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('yearlyTotal').textContent = '€' + data.total.toLocaleString('de-DE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                })
                .catch(error => console.error('Error loading yearly total:', error));

            // Monthly Invoices Bar Chart
            fetch('{{ route('api.charts.monthly') }}')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('monthlyInvoicesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Total Invoice Amount (EUR)',
                                data: data.data,
                                backgroundColor: 'rgba(112, 41, 99, 0.8)',
                                borderColor: 'rgba(112, 41, 99, 1)',
                                borderWidth: 2,
                                borderRadius: 5,
                                hoverBackgroundColor: 'rgba(112, 41, 99, 1)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '€' + value.toLocaleString('de-DE', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Total: €' + context.parsed.y.toLocaleString('de-DE', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading monthly invoice data:', error));

            // Top Clients Pie Chart
            fetch('{{ route('api.charts.clients') }}')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('topClientsChart').getContext('2d');

                    // Generate dynamic colors for each client
                    const colors = [
                        'rgba(112, 41, 99, 0.9)',
                        'rgba(255, 99, 132, 0.9)',
                        'rgba(54, 162, 235, 0.9)',
                        'rgba(255, 206, 86, 0.9)',
                        'rgba(75, 192, 192, 0.9)',
                        'rgba(153, 102, 255, 0.9)',
                        'rgba(255, 159, 64, 0.9)',
                        'rgba(199, 199, 199, 0.9)',
                        'rgba(83, 102, 255, 0.9)',
                        'rgba(255, 99, 255, 0.9)'
                    ];

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Revenue (EUR)',
                                data: data.data,
                                backgroundColor: colors,
                                borderColor: colors.map(color => color.replace('0.9', '1')),
                                borderWidth: 2,
                                hoverOffset: 15
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        padding: 15,
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.parsed || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return label + ': €' + value.toLocaleString('de-DE', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }) + ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading top clients data:', error));
        });
    </script>
    @endpush
{{-- @endsection --}}
