<?php
$page_name = parse_url($_SERVER['REQUEST_URI'])['path'];
require __DIR__ . '/classes/Database.php';
require __DIR__ . '/classes/Comment.php';

$config = require __DIR__ . '/classes/config.php';

echo '<main class="flex-1">';

function valider_name($name)
{
    if ($name === null) {
        return false;
    }
    $regex = "/^[A-Za-z]{3,}$/";
    if (preg_match($regex, $name)) {
        return true;
    }
    return false;
}
function valider_email($email)
{
    if ($email === null) {
        return false;
    }
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function valider_description($description)
{
    if ($description === null) {
        return false;
    }
    $regex = "/^.{20,}$/s";
    if (preg_match($regex, $description)) {
        return true;
    }
    return false;
}

function valider_les_champ($name, $email, $description)
{
    if (!valider_name($name)) {
        echo '
            <script>
                const name_input = document.querySelector(".username");
                console.log(name_input);
                name_input.focus();
            </script>
        ';
        return false;
    }
    if (!valider_email($email)) {
        echo '
            <script>
                const email_input = document.querySelector(".email");
                email_input.focus();
            </script>
        ';
        return false;
    }
    if (!valider_description($description)) {
        echo '
            <script>
                const description_input = document.querySelector(".description");
                description_input.focus();
            </script>
        ';
        return false;
    }
    return true;
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
    case '/propos':
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
        $tableaux = [
            'username' => null,
            'email' => null,
            'description' => null
        ];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tableaux['username'] = $_POST["username"];
            $tableaux['email'] = $_POST["email"];
            $tableaux['description'] = $_POST["description"];
            if (valider_name($tableaux['username']) && valider_email($tableaux['email']) && valider_description($tableaux['description'])) {
                $tableaux['username'] = null;
                $tableaux['email'] = null;
                $tableaux['description'] = null;
            }
        }

?>
        <section class="container mx-auto py-16">
            <h2 class="text-3xl font-bold mb-6 text-center">Contactez-nous</h2>
            <form class="max-w-xl mx-auto bg-white p-8 shadow-md rounded-lg space-y-4" method="post">
                <input type="text" placeholder="Votre nom" class="w-full border px-4 py-2 rounded-lg username" name="username" value=<?= $tableaux["username"] ?>>
                <?php
                if (!valider_name($tableaux['username']) && $tableaux['username'] !== null) {
                    echo "<h2 class= 'text-xl text-[red]'>Tu doit ecrire plus de deux carachter</h2>";
                }

                ?>
                <input type="email" placeholder="Votre email" class="w-full border px-4 py-2 rounded-lg email" name="email" value=<?= $tableaux["email"] ?>>
                <?php
                if (!valider_email($tableaux['email']) && $tableaux['email'] !== null) {
                    echo "<h2 class= 'text-xl text-[red]'>Tu doit ecrire un email valide</h2>";
                }
                ?>
                <textarea placeholder="Votre message" class="w-full border px-4 py-2 rounded-lg description" name="description"><?php echo $tableaux["description"] ?></textarea>
                <?php
                if (!valider_description($tableaux['description']) && $tableaux['description'] !== null) {
                    echo "<h2 class= 'text-xl text-[red]'>Tu doit ecrire une description plus que 20 charachter</h2>";
                }
                ?>
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700" name="password">Envoyer</button>
            </form>
        </section>'
<?php
        $data = new Database($config['database']);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $description = $_POST["description"];
            if (valider_les_champ($username, $email, $description) === true) {
                //ajouter un commentair dans le database;
                $query = 'insert into comments (name, email, descrip) 
                            values (:name,:email,:descrip)';
                $param = [
                    ':name' => $username,
                    ':email' => $email,
                    ':descrip' => $description
                ];
                $data->query($query, $param);
            }
        }
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
                    <h2 class="text-2xl font-bold mb-3">Message</h2>
                    <h2 class="text-2xl mb-3">' . $comment['descrip'] . '</h2>
                </div>
            </section>';
        }
        echo '</div>';

        break;
}
echo '</main>';
