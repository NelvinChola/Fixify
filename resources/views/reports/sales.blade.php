<!-- resources/views/reports/sales.blade.php -->
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Sales Report</h4>
            </div>
            <div class="col-md-6 text-end">
                <input type="text" class="form-control daterange" placeholder="Date Range">
                <button class="btn btn-primary">Filter</button>
                <button class="btn btn-success">Export</button>
            </div>
        </div>

        <div class="chart-container mb-4" style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>

        <table class="table">
            <!-- Sales table data -->
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Initialize date range picker
    $('.daterange').daterangepicker();

    // Chart.js implementation
    const ctx = document.getElementById('salesChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($sales->pluck('date')) !!},
            datasets: [{
                label: 'Daily Sales',
                data: {!! json_encode($sales->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        }
    });
</script>
@endpush