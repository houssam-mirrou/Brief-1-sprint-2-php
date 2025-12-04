<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col">

<header class="bg-white shadow-md">
    <nav class="container mx-auto flex justify-between items-center py-4">
        <h1 class="text-2xl font-bold text-blue-600">DigitalWave</h1>
        <ul class="flex space-x-6">
            <li><a href="/" class="<?= isUrl('/index') || isUrl('/') ? 'text-blue-600 font-medium' : 'hover:text-blue-600' ?>">Accueil</a></li>
            <li><a href="/services" class="<?= isUrl('/services') ? 'text-blue-600 font-medium' : 'hover:text-blue-600' ?>">Services</a></li>
            <li><a href="/propos" class="<?= isUrl('/propos') ? 'text-blue-600 font-medium' : 'hover:text-blue-600' ?>">À propos</a></li>
            <li><a href="/contact" class="<?= isUrl('/contact') ? 'text-blue-600 font-medium' : 'hover:text-blue-600' ?>">Contact</a></li>
        </ul>
    </nav>
</header>