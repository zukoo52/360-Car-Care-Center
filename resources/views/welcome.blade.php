
 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <title>360carcare</title>
 
     <!-- Fonts -->
     <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
 
     <!-- Styles -->
     <style>
         html,
         body {
             background-color: #f5f5f5; /* Light gray background */
             color: #333; 
             font-family: 'Nunito', sans-serif;
             font-weight: 200;
             height: 100vh;
             margin: 0;
         }
 
         .full-height {
             height: 100vh;
         }
 
         .flex-center {
             align-items: center;
             display: flex;
             justify-content: center;
             height: 100%;
         }
         
 
         .position-ref {
             position: relative;
         }
 
         .top-right {
             position: absolute;
             right: 10px;
             top: 18px;
         }
 
         .content {
             text-align: center;
         }
 
         .title {
             font-size: 84px;
             font-weight: bold; /* Bold */
             text-transform: uppercase; /* Uppercase */
             margin-bottom: 20px;
             color: #007bff; /* Blue color */
         }
         .subtitle {
             font-size: 32px; /* Larger font size */
             text-transform: uppercase; /* Uppercase */
             margin-bottom: 30px;
         }
 
         .links>a {
             color: #007bff; /* Blue color */
             padding: 10px 25px;
             font-size: 16px;
             font-weight: 600;
             letter-spacing: .1rem;
             text-decoration: none;
             text-transform: uppercase;
             transition: all 0.3s ease;
             border: 2px solid transparent;
             border-radius: 30px;
         }
 
         .links>a:hover {
             background-color: #007bff; /* Blue color */
             color: #fff; /* White color */
             border-color: #007bff; /* Blue color */
         }
 
         .m-b-md {
             margin-bottom: 30px;
         }
     </style>
 </head>
 
 <body>
     <div class="flex-center position-ref full-height">
         @if (Route::has('login'))
         <div class="top-right links">
             @auth
             <a href="{{ url('/home') }}">Home</a>
             @else
             <a href="{{ route('login') }}">Login</a>
 
             @if (Route::has('register'))
             <a href="{{ route('register') }}">Register</a>
             @endif
             @endauth
         </div>
         @endif
 
         <div class="content">
             <img src="/assets/placeholders/official-logo.png" 
             alt="360carcare Logo" style="max-width: 200px;">
 
             <div class="title m-b-md">
                 360carcare
             </div>
             <div class="subtitle m-b-md">
                <b><u>Your one-stop solution for all car care needs</u></b>
             </div>
 
             <div class="links">
                 <a href="https://laravel.com/docs">Services</a>
                 <a href="https://laracasts.com">About Us</a>
                 <a href="https://laravel-news.com">Contact</a>
             </div>
         </div>
     </div>
 </body>
 
 </html>
 