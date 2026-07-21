<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Tailwind CSS (CDN for Development) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'unsoed-yellow': '#F2A900',
                        'unsoed-blue': '#005587',
                        'unsoed-darkblue': '#003B5C',
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                        'serif': ['Playfair Display', 'serif'],
                    },
                    boxShadow: {
                        'card': '0 10px 40px -10px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass {
                @apply bg-white/80 backdrop-blur-lg border border-white/20 shadow-xl;
            }
            .btn-primary {
                @apply bg-unsoed-yellow text-white px-6 py-3 rounded-xl font-bold hover:bg-yellow-500 hover:shadow-lg hover:-translate-y-1 transition-all duration-300;
            }
        }
    </style>
    <style>
        /* Sembunyikan ikon mata bawaan Microsoft Edge agar tidak ganda */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Abstract Background -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-48 -left-48 w-96 h-96 bg-unsoed-blue/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-unsoed-yellow/20 rounded-full blur-3xl"></div>
    </div>
    
    <div class="w-full max-w-5xl mx-auto px-4 z-10">
