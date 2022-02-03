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

//Création de la classe User avec les attributs suivants
class User
{
//Propriétés
    private $id;
    public $login;
    public $email;
    public $firstname;
     public $lastname;
    protected $password;
    public $bdd;
    public $users;

//Méthodes Connexion à la BDD
    public function __construct()
    {
        $this->bdd = mysqli_connect("localhost", "root", "", "classes");
        $requete = mysqli_query($this->bdd, "SELECT * FROM utilisateurs");
        $this->users = mysqli_fetch_all($requete);
    }

//  Créée un utilisateurs en BDD, et retourne les infos de l'utilisateur
    public function Register($login, $email, $password, $firstname, $lastname)
    {
        foreach ($this->users as $user)
        {
            if($login == $user[1])
            {
                echo "login indisponible";
            }
            elseif($login != $user[1])
            {
                $resuser = mysqli_query($this->bdd, "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
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
    }
//Méthode de connexion
    public function Connect($login, $password)
    {
        foreach ($this->users as $user)
        {
            if($login == $user[1] && $password = $user[2])
            {
                $_SESSION["login"] = $login;
                $this->login = $login;
                $this->email = $user[3];
                $this->firstname = $user[4];
                $this->lastname = $user[5];
                echo "Vous êtes connectez !" .$this->login;
            }
        }

    }
//Méthode pour déconnexion
    public function Disconnect()
    {
        session_destroy();
        echo "Vous êtes déconnectez!";
    }
//Méthode pour supprimer
    public function Delete()
    {
        $login = $this->login;
        $redelete = mysqli_query($this->bdd, "DELETE FROM utilisateurs WHERE login = '$login'");
        session_destroy();
        $this->login = NULL;
        return $login."est supprimer";
    }
//Méthode pour mise à jour
    public function Update($login, $password, $email, $firstname, $lastname)
    {
        if(isset($_SESSION["login"]))
        {
            $log = $_SESSION["login"];
            $reupdate = mysqli_query($this->bdd, "UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE login = '$log'");
            return "Mise à jour reussis";
        }
    }
//Méthode pour savoir si l'utilisateur et connecté ou non
    public function isConnected()
    {
        return (isset($_SESSION["login"]));
    }
//Méthode get pour récupérer les infos de l'utilisateur
    public function getAllInfos()
    {
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
                    <td>$login</td>
                    <td>$password</td>
                    <td>$email</td>
                    <td>$firstname</td>
                    <td>$lastname</td>
                </tbody>
            </table>";
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

$user = new User();

//$user->register("yas","pp", "yas@yas.fr", "yas", "rr");
//$user->Connect("yas", "pp");
//$user->delete();
//$user->update("", "", "", "","");
//$user->isConnected();
//$user->getAllInfos();
//$user->getLogin();
//$user->getEmail();
//$user->getFirstname();
//$user->getLastname();
?>
</body>
</html>
