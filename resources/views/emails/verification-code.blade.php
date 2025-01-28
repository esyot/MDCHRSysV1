<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Code</title>
    <style>
        /* Basic Reset */
        body, div, h1, p, small {
            margin: 0;
            padding: 0;
        }
        
        /* Body and Main Layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .content {
            text-align: center;
        }

        .header {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Logo Styling */
        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 120px; /* Adjust width as needed */
            height: auto;
        }

        .code-container h1 {
            font-size: 36px;
            color: #2a7be2;
            font-weight: bold;
            padding: 10px 0;
            background-color: #e3f1fe;
            border-radius: 6px;
        }

        small {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .logo img {
                width: 100px; /* Adjust for smaller screen */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        <!-- Logo Section -->
        <div class="logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5HqCbuDQf2bfsr7EMHSCt6ehwaifOmMa9PA&s" alt="Your Logo">
        </div>

        <!-- Header Section -->
        <div class="header">
            
<h1>MDC HR - SYSTEM</h1>
            <span>Your Authentication Code is:</span>
        </div>

        <!-- Code Display -->
        <div class="code-container">
            <h1>{{ $code }}</h1>
        </div>

        <!-- Disclaimer -->
        <small>Please don't share this code with anyone.</small>
    </div>
</div>

</body>
</html>
