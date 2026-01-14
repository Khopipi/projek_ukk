<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Desa Sruni') - Desa Sruni</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Main Content */
        .content-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 20px;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            color: #667eea;
            border-top: 1px solid #e9ecef;
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
        }
        
        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5b6dd9 0%, #6b4099 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }
        
        .text-success {
            color: #10b981 !important;
        }
        
        .text-danger {
            color: #ef4444 !important;
        }
        
        .text-warning {
            color: #f59e0b !important;
        }
        
        .bg-success {
            background-color: #10b981 !important;
        }
        
        .bg-danger {
            background-color: #ef4444 !important;
        }
        
        .bg-warning {
            background-color: #f59e0b !important;
        }
        
        .bg-primary {
            background-color: #667eea !important;
        }
        
        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid #e9ecef;
            padding: 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .footer p {
            margin: 0;
            font-size: 0.875rem;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <i class="fas fa-map-location-dot"></i> Desa Sruni
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Desa Sruni. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
