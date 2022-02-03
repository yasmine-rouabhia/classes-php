<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user.css">
    <title>classes</title>
</head>
<body>
<?php
session_start();

//Création de la classe de Userpdo avec les attributs suivants
class Userpdo
{
//Propriétés
    private $id;
    public $login;
    public $email;
    protected $password;
    public $firstname;
    public $lastname;
    public $bdd;
    public $users;

    //Méthodes connexion a la BDD 
    public function __construct()
    {
        $this->bdd = new PDO("mysql:host=localhost;dbname=classes", 'root', '');
    }

    //Méthode pour enregistré un utilisateurs en BDD et retourne les infos
    public function Register($login, $email, $password, $firstname, $lastname)
    {
        if($this->bdd = new PDO("mysql:host=localhost;dbname=classes", 'root', ''))
        {
            $bdd = $this->bdd->prepare("INSERT INTO utilisateurs (login, email, password, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
            $bdd->execute(array($login, $email, $password, $firstname, $lastname));
            return "
            <table style='text-align:center'> 
                <theader>
                    <th>login</th>
                    <th>password</th>
                    <th>email</th>
                    <th>firstname</th>
                    <th>lastname</th>
                </theader>
                <tbody>
                    <td> $login </td>
                    <td> $password </td>
                    <td> $email </td>
                    <td> $firstname </td>
                    <td> $lastname </td>
                </tbody>
            </table>";
        }
    }

    //Méthode de connexion
    public function Connect($login, $password)
    {
        
        $pdo = new PDO("mysql:host=localhost;dbname=classes", 'root', '');
        $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $req->execute(array($login, $password));
        echo "Vous êtes connectez!" .$this->login;
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($results);
        
        foreach($results as $result)
        {
            $this->login = $result["login"];
            $this->password = $result["password"];
            $this->email = $result["email"];
            $this->firstname = $result["firstname"];
            $this->lastname = $result["lastname"];
            // echo $result["login"];
        } 
    }

    //Méthode pour déconnectez l'utilisateurs
    public function Disconnect()
    {
        session_destroy();
        echo "Vous êtes déconnectez!";
    }

    //Méthode pour supprimer un utilisateurs
    public function Delete()
    {

        $pdo = new PDO("mysql:host=localhost;dbname=classes", 'root', '');
        $requette = $pdo->prepare("DELETE FROM `utilisateurs` WHERE `login`");
        $requette->execute();
        echo 'Supprimer';
    }

    //Méthode pour mettre à jour les attributs de l'objet et modifie les infos en BDD
    public function Update($login, $password, $email, $firstname, $lastname)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", 'root', '');
        $requet = $pdo->prepare("UPDATE utilisateurs SET login='$login', password='$password', email='$email', firstname='$firstname', lastname='$lastname'");
        $requet->execute();
        echo 'Modification effectuer';
    }

    //Méthode permettant de savoir si l'utilisateur et co ou non
    public function isConnected()
    {
        $connect = NULL;
        if(!empty($this->login && $this->password))
            {
                $connect = true;
            }
        else
            {
                $connect = false;
            }
        return $connect;
    }

    //Méthode Get retourne tableau des infos utilisateurs
    public function getAllInfos()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", 'root', '');
        $req = $pdo->prepare("SELECT * FROM utilisateurs ");
        $req->execute();
        $allInfos =
            [
                `login` => $this->login,
                `password` => $this->password,
                `email`=> $this->email,
                `firstname`=>$this->firstname,
                `lastname`=>$this->lastname
            ];
        return $allInfos;
    }

    //Méthode pour récupérer le login de l'utilisateur
    public function getLogin()
    {
        return $this->login;
    }

    //Méthode pour récupérer l'email
    public function getEmail()
    {
        return $this->email;
    }

    //Méthode pour récupérer le prénom
    public function getFirstname()
    {
        return $this->firstname;
    }

    //Méthode pour récupérer le nom
    public function getLastname()
    {
        return $this->lastname;
    }
}

$user = new Userpdo();

// $user->Register("yas", "yas@yas", "y", "yy", "rr");
// $user->Connect("yas", "y");
// $user->Disconnect();
//$user->Delete();
//$user->Update("yo", "yoyo", "yo@yo", "oy", "oyo");
//$user->isConnected();
//$user->getAllInfos();
//$user->getLogin();
//$user->getEmail();
//$user->getFirstname();
//$user->getLastname();

?>
</body>
</html>