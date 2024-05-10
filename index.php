<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ylagan's Backery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    .body{
        position: fixed;
        background-color: url('./assets/image/cob-16.jpg');
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-position: all;
    }
    .orange{
        background-color: #451a03;
    }
    .orage2{
        border: 2px solid #78350f;
        color: #ea580c;
         background-color: #fff;
         transition: background-color 0.3s ease;
         text-decoration: none;
    }
    .orange2:hover{
            background-color: #78350f; 
            color: #fff; 
    
    }
    .rounded-half {
           border-radius: 30px 0px 0px 0px;
            width: 450px;
            height: auto;
            margin-top: 70%;
            margin-left: 160px;
        }
 .class{
    margin-left: 300px;
 }
    </style>
<body class="bg-slate-100">
    <div class="body">
 <div class="class lg:w-1/2 ml-auto mr-auto mt-60 text-center">
    <h1 class="text-3xl font-bold text-center text-black mb-2">Ylagan's Backery</h1>
    <p class="text-lg text-black mb-4">Welcome to Ylagan's Bakery, where we offer a delightful range of freshly baked goods.</p>
    <div class="space-x-4">
        <button id="login" class="orange text-white font-bold py-2 px-4 rounded">Login</button>
        <button id="signup" class="orange2 font-bold py-2 px-4 rounded">Sign up</button>
    </div>
</div>
</div>

            <!-- <div class="lg:w-1/2 mt-8 lg:mt-0">
                <img src="./assets/image/cob-16.jpg" alt="image" class="rounded-half">
            </div> -->
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
  
</body>
</html>
