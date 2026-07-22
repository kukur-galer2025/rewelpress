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
    
    <!-- Tailwind CSS (Compiled) -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/style.css">
</head>
<body class="bg-gray-900 text-gray-800 antialiased font-sans min-h-screen flex items-center justify-center relative overflow-x-hidden">
    <!-- Background Image -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <img src="<?= BASEURL; ?>/assets/img/bg_auth_pattern.png" alt="Geometric Background" class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-br from-unsoed-darkblue/90 via-unsoed-darkblue/70 to-unsoed-blue/90 backdrop-blur-[1px]"></div>
    </div>
    
    <!-- Decorative Orbs -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-48 -left-48 w-96 h-96 bg-unsoed-yellow/30 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400/20 rounded-full blur-[100px]"></div>
    </div>
    
    <div class="w-full max-w-5xl mx-auto px-4 z-10 py-6 md:py-10 flex flex-col h-full relative">
