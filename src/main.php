<?php
require 'vendor/autoload.php';

/*
    tutorials :
        - https://eilgin.github.io/php-the-right-way/
        - https://learndev.info/en#php
 */

// if ($argc != 2) {
//     echo "Usage: php main.php [name].\n";
//     exit(1);
// }

// $name = $argv[1];
// echo "Hello, $name\n";


/*  ----------------------------------------------------
    DATE
    ----------------------------------------------------
 */

/*
$raw = '22. 11. 1968';
$start = \DateTime::createFromFormat('d. m. Y', $raw);

echo 'Date : ' . $start->format('m/d/Y') . "\n";
echo 'Date : ' . $start->format('d/m/Y') . "\n";

// copy $start and add 1 month + 6 days
$end = clone $start;
$end->add(new \DateInterval('P1M6D'));

$diff = $end->diff($start);
echo 'Difference: ' . $diff->format('%m months, %d days (total: %a days)') . "\n";
// Difference: 1 months, 6 days (total: 36 days)

// show all thurdays between $start et $end
$periodInterval = \DateInterval::createFromDateString('first thursday');
$periodIterator = new \DatePeriod($start, $periodInterval, $end, \DatePeriod::EXCLUDE_START_DATE);
foreach ($periodIterator as $date) {
    // shows each date of each thursday
    echo $date->format('m/d/Y') . ' ';
}*/

/*  ----------------------------------------------------
    UTF-8 encoding
    ----------------------------------------------------
 */

/*
// specify that we are going to manipulate UTF-8
mb_internal_encoding('UTF-8');

// specify that we are going to display UTF-8 text in the browser
mb_http_output('UTF-8');

// our UTF-8 string
$string = 'Êl síla erin lû e-govaned vîn.';

// split the string (char non ascii for the example)
$string = mb_substr($string, 0, 15);

// db connexion for the string transformed
// notice `set names utf8mb4`
$link = new \PDO(
                    'mysql:host=your-hostname;dbname=your-db;charset=utf8mb4',
                    'your-username',
                    'your-password',
                    array(
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_PERSISTENT => false
                    )
                );

// stocks the string in the db
// db +  tables must be encoded with utf8mb4 (character set and collation).
$handle = $link->prepare('insert into ElvishSentences (Id, Body) values (?, ?)');
$handle->bindValue(1, 1, PDO::PARAM_INT);
$handle->bindValue(2, $string);
$handle->execute();

// get the string from the db
$handle = $link->prepare('select * from ElvishSentences where Id = ?');
$handle->bindValue(1, 1, PDO::PARAM_INT);
$handle->execute();

// stocks the result
$result = $handle->fetchAll(\PDO::FETCH_OBJ);

// specifies response type + charset
header('Content-Type: text/html; charset=utf-8');
?><!doctype html>
<html>
    <head>
        <title>page de test UTF-8</title>
    </head>
    <body>
        <?php
        foreach($result as $row){
            print($row->Body);  // Cela devrait correctement afficher notre contenu en UTF-8
        }
        ?>
    </body>
</html>*/


/*  ----------------------------------------------------
    DEPENDENCY INJECTION
    ----------------------------------------------------
 */

/*
namespace Database;

class Database
{
    protected $adapter;

    // public function __construct()
    // {
    //     $this->adapter = new MySqlAdapter;
    // }

    // public function __construct(MySqlAdapter $adapter)
    // {
    //     $this->adapter = $adapter;
    // }
    
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}

interface AdapterInterface {}

class MySqlAdapter implements AdapterInterface {}*/

/*  ----------------------------------------------------
    DATABASES
    ----------------------------------------------------
 */


////$pdo = new PDO('sqlite:users.db');

// NO
//$pdo->query("SELECT name FROM users WHERE id = " . $_GET['id']);

/* Why?
    Potential SQL injections

    https://example.com/script.php?id=1
    -> ok, id = 1

    but if : 
    https://example.com/script.php?id=1%3BDELETE+FROM+users
    -> warning, id = 1;DELETE FROM users
        the problem : SELECT name FROM users WHERE id = 1;DELETE FROM users
                      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^
                      ok                                    delete all users
 */

// YES
/*$stmt = $pdo->prepare('SELECT name FROM users WHERE id = :id');
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT); // <-- automatically cleaned by PDO (avoid SQL injections)
$stmt->execute();*/


/*  ----------------------------------------------------
    TEMPLATING
    ----------------------------------------------------
 */

// pure (plates)
/*
<?php $this->insert('header', ['title' => 'Profil utilisateur']) ?>

<h1>Profil utilisateur</h1>
<p>Bonjour, <?=$this->escape($name)?></p>

<?php $this->insert('footer') ?>
*/

// compiled (twig)
/* 
{% include 'header.html' with {'title': 'Profil utilisateur'} %}

<h1>Profil utilisateur</h1>
<p>Bonjour, {{ name }}</p>

{% include 'footer.html' %}
*/

/*  ----------------------------------------------------
    ERRORS & EXCEPTIONS
    ----------------------------------------------------
 */

/*class DemoException extends Exception {}

try
{
    // do something...
}
catch(DemoException $e)
{
    // do some stuff if a DemoException is raised
}
finally
{
    // some stuff executed if there was an exception or not
}*/

/*  ----------------------------------------------------
    SECURITY
    ----------------------------------------------------
 */

// I - hash

/*
require 'password.php';

$passwordHash = password_hash('secret-password', PASSWORD_DEFAULT);

if (password_verify('bad-password', $passwordHash)) {
    // Mot de passe correct
} else {
    // Mauvais mot de passe
}*/

// II - data filters

/* 
- XSS : strip_tags(), htmlentities(), htmlspecialchars(), escapeshellarg() (-> for shell).
- Validation
*/

// III - Configuration

/*
- store your configuration information where no unauthorized user can access it (file system)
- name the files with the .php extension (if the file is accessed directly, it will not be displayed as plain text)
- encryption of informations
 */

// IV - Logging

// a - development server

// in php.ini
/*
display_errors = On
display_startup_errors = On
error_reporting = -1
log_errors = On
*/

// b - production

/*
display_errors = Off
display_startup_errors = Off
error_reporting = E_ALL
log_errors = On
*/
