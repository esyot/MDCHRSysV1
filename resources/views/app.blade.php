<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <link rel="icon" type="image/png" href="/assets/images/mdc-logo.png">
  <title>MDC - HR System</title>

  @vite('resources/js/app.js')
  @inertiaHead
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    @media (min-width: 768px) {
      .grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 1024px) {
      .grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }
  </style>
</head>

<body>
  @inertia
</body>

  <!-- <script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.addEventListener('keydown', event => {
      
      if (event.key === 'F12') {
          event.preventDefault();
      }

      if (event.ctrlKey && event.key === 'u') {
          event.preventDefault();
      }

    
      if (event.ctrlKey && event.shiftKey && event.key === 'I') {
          event.preventDefault();
      }
    });
  </script> -->


</html>
