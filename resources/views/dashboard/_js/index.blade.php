@push('vendor-script')
<script src="{{ url('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ url('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('position-category-chart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [
                {
                    label: 'Penjualan',
                    data: @json($dataPenjualan),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)', // Hijau
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pembelian',
                    data: @json($dataPembelian),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)', // Merah
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.raw || 0;
                            return `${label}: Rp ${value.toLocaleString('id-ID')}`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
