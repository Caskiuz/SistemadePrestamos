<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Préstamos Santa Ana</title>
    <link rel="icon" href="{{ asset('img/logoICO.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #dc2626 50%, #111827 100%);
            overflow: hidden;
        }
        
        .login-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        
        .login-brand {
            margin-bottom: 30px;
        }
        
        .login-brand img {
            max-width: 250px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(220, 38, 38, 0.3));
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .card-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        
        .card-header h4 {
            margin: 0 0 5px 0;
            font-size: 24px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .card-header .subtitle {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            width: 100%;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 15px 18px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
            outline: none;
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }
        
        .alert-danger {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #991b1b;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .simple-footer {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .simple-footer p {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: 500;
        }
        
        .simple-footer small {
            font-size: 12px;
            opacity: 0.8;
        }
        
        /* Desktop */
        @media (min-width: 768px) {
            .login-container {
                max-width: 450px;
            }
            
            .login-brand img {
                max-width: 280px;
            }
            
            .card-body {
                padding: 40px;
            }
            
            .card-header h4 {
                font-size: 26px;
            }
        }
        
        /* Mobile */
        @media (max-width: 767px) {
            .login-wrapper {
                padding: 15px;
            }
            
            .login-brand img {
                max-width: 200px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .form-control {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .btn-login {
                padding: 12px;
                font-size: 14px;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    @yield('content')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>