<!DOCTYPE html>
<html>
<head>
    <title>Export Data</title>
    <!-- Tambahkan Bootstrap atau style sesuai kebutuhan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Export Data ke Excel</h1>
        <p>Klik tombol di bawah untuk mengunduh data dalam format Excel.</p>
        <a href="{{ route('dashboard.export-all') }}" class="btn btn-primary">
            <i class="bi bi-download"></i> Download Data Excel
        </a>
    </div>

    <!-- Tambahkan Bootstrap Icon (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
