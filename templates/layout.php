<?php
$page_name = parse_url($_SERVER['REQUEST_URI'])['path'];
require 'classes/Database.php';
require 'classes/Comment.php';


echo '<main class="flex-1">';

function valider_name($name){
    $regex = "/^[A-Za-z]{3,}$/";
    
}
function valider_email($email){
    $regex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

}
function valider_description($description){
    $regex = "/^[a-zA-Z ]{20,}$/";
}



switch ($page_name) {
    case '/':
        echo '<section class="container mx-auto py-20 text-center h-1/2 ">
                <h2 class="text-4xl font-bold mb-6">Propulsez votre entreprise vers le digital</h2>
                <p class="text-lg mb-8 text-gray-600">Création de sites Web, automatisation, solutions digitales sur mesure.</p>
                <a href="services" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">Voir nos
                    services</a>
            </section>';
        break;
    case '/about':
        echo '<section class="container mx-auto py-16">
            <h2 class="text-3xl font-bold mb-6 text-center">À propos de nous</h2>
            <p class="text-gray-700 text-lg leading-8 text-center max-w-3xl mx-auto">
                DigitalWave Solutions est une agence spécialisée dans la création et le développement de solutions digitales modernes.
                Notre mission est d\'accompagner les entreprises dans leur transformation numérique grâce à des outils efficaces et adaptés.
            </p>
        </section>';
        break;
    case '/services':
        echo '<section class="container mx-auto py-16">
                <h2 class="text-3xl font-bold mb-8 text-center">Nos Services</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-bold mb-2">Création de sites Web</h3>
                        <p class="text-gray-600">Sites vitrines, e-commerce, applications modernes.</p>
                    </div>
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Développement sur mesure</h3>
                    <p class="text-gray-600">Outils internes, solutions métiers spécifiques.</p>
                </div>
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h3 class="text-xl font-bold mb-2">Automatisation & API</h3>
                    <p class="text-gray-600">Automatisation des tâches, intégration d\'API.</p>
                </div>
                </div>
            </section>';
        break;

    case '/contact':
        echo '<section class="container mx-auto py-16">
                <h2 class="text-3xl font-bold mb-6 text-center">Contactez-nous</h2>
                <form class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg space-y-4" method="post">
                    <input type="text" placeholder="Votre nom" class="w-full border px-4 py-2 rounded-lg" name="username">
                    <input type="email" placeholder="Votre email" class="w-full border px-4 py-2 rounded-lg" name="email">
                    <textarea placeholder="Votre message" class="w-full border px-4 py-2 rounded-lg" name="description"></textarea>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700" name="password">Envoyer</button>
                </form>
            </section>';

        
        $username = $_POST["username"];
        $email = $_POST["email"];
        $description = $_POST["description"];

        $data = new Database();
        $comments = $data->query('select * from comments');

        echo '<div class = "grid grid-cols-3">';
        foreach ($comments as $comment) {
            echo '<section class="container mx-auto py-16">
                <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg space-y-4">
                    <h2 class="text-3xl font-bold mb-6 text-center">Exemple De Contact</h2>
                    <h2 class="text-2xl font-bold mb-3">Name : </h2>
                    <h2 class="text-2xl mb-3">' . $comment['name'] . '</h2>
                    <h2 class="text-2xl font-bold mb-3">Email : </h2>
                    <h2 class="text-2xl mb-3">' . $comment['email'] . '</h2>
                    <h2 class="text-2xl font-bold mb-3">Description</h2>
                    <h2 class="text-2xl mb-3">' . $comment['descrip'] . '</h2>
                </div>
            </section>';
        }
        echo '</div>';

        break;
}
echo '</main>';
