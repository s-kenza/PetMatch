<?php

namespace App\Controller;

use PDO;
use App\Routing\Attribute\Route;

class IndexController extends AbstractController
{
  #[Route("/", name: "homepage", httpMethod: "GET")]
  public function home(): string
  {
    return $this->twig->render('index.html.twig');
  }

  #[Route("/repertoire", name: "repertoire", httpMethod: "GET")]
  public function repertoire(): string
  {
    session_start();
    $login = $_SESSION['login'] ?? null;

    // Pour gérer l'affichage de la grille des animaux
    $divOrder = ['', '', 'tall', 'wide', '', 'tall', 'big', '', ''];

    $statement='SELECT * FROM animaux';
    $stmt = $this->db->query($statement);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $this->twig->render('repertoire.html.twig', ['animaux' => $animaux, 'divOrder' => $divOrder, 'connexion' => ['login' => $login]]);
  }

  #[Route("/repertoire/{nom}/{id}", name: "animal_details", httpMethod: "GET")]
  public function animalDetails(): string
  {
      session_start();
      $login = $_SESSION['login'] ?? null;
      $loginId = $_SESSION['id'] ?? null;

      $url = $_SERVER['REQUEST_URI'];
      $segments = explode('/', parse_url($url, PHP_URL_PATH));
      $id = $segments[3];
      $nom = $segments[2];

      // Vérifier si l'animal est en demande d'adoption
      $checkStatement = "SELECT COUNT(*) as count FROM demandes_adoption WHERE animal_id = :animalId";
      $checkStmt = $this->db->prepare($checkStatement);
      $checkStmt->execute(['animalId' => $id]);
      $availabilityResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

      $statement = "SELECT animaux.image, animaux.nom, animaux.id, animaux.genre, animaux.espece, details_animaux.vaccinations, details_animaux.comportement, details_animaux.conditions_adoption FROM animaux JOIN details_animaux ON animaux.id = details_animaux.animal_id WHERE animaux.nom = :nom";
      $stmt = $this->db->prepare($statement);
      $stmt->execute(['nom' => $nom]);
      $animal = $stmt->fetch(PDO::FETCH_ASSOC);

      return $this->twig->render('animal_details.html.twig', ['animal' => $animal, 'connexion' => ['login' => $login, 'id' => $loginId], 'availabilityResult' => $availabilityResult]);
  }

  #[Route("/adoption", name: "adoption", httpMethod: "GET")]
  public function formulaire(): string
  {
    session_start();
    $login = $_SESSION['login'] ?? null;
    $id = $_SESSION['id'] ?? null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Récupérer les données soumises
      $nom = $_POST['nom'];
      $espece = $_POST['espece'];
      $age = $_POST['age'];
      $description = $_POST['description'];
      $genre = $_POST['genre'];

      $statement = "INSERT INTO animaux (nom, espece, age, description, genre) VALUES (:nom, :espece, :age, :description, :genre)";
      $stmt = $this->db->prepare($statement);
      $stmt->execute(['nom' => $nom, 'espece' => $espece, 'age' => $age, 'description' => $description, 'genre' => $genre]);

      // Récupérer l'id de l'animal nouvellement inséré
      $animalId = $this->db->lastInsertId();

      if (isset($_POST['vaccin1']) && isset($_POST['vaccin2'])) {
            $vaccins = 'Vaccin 1 et Vaccin 2';
        } elseif (isset($_POST['vaccin1'])) {
            $vaccins = 'Vaccin 1';
        } elseif (isset($_POST['vaccin2'])) {
            $vaccins = 'Vaccin 2';
        } else {
            $vaccins = '';
        }

        $statement = "INSERT INTO details_animaux (animal_id, vaccinations) VALUES (:animal_id, :vaccins)";
        $stmt = $this->db->prepare($statement);
        $stmt->execute(['animal_id' => $animalId, 'vaccins' => $vaccins]);

        $comportements = [];

        if (isset($_POST['comportement1'])) {
            $comportements[] = 'Joueur';
        }
        
        if (isset($_POST['comportement2'])) {
            $comportements[] = 'Sociable';
        }
        
        if (isset($_POST['comportement3'])) {
            $comportements[] = 'Calme';
        }
        
        if (isset($_POST['comportement4'])) {
            $comportements[] = 'Indépendant';
        }
        
        $comportementsStr = implode(', ', $comportements);

        $statement = "INSERT INTO details_animaux (animal_id, comportement) VALUES (:animal_id, :comportement)";
        $stmt = $this->db->prepare($statement);
        $stmt->execute(['animal_id' => $animalId, 'comportement' => $comportementsStr]);

        $conditionsAdoption = [];

        if (isset($_POST['condition1'])) {
            $conditionsAdoption[] = 'Famille avec enfants';
        }
        
        if (isset($_POST['condition2'])) {
            $conditionsAdoption[] = 'Maison avec jardin';
        }
        
        if (isset($_POST['condition3'])) {
            $conditionsAdoption[] = 'Environnement calme';
        }
        
        if (isset($_POST['condition4'])) {
            $conditionsAdoption[] = 'Personne seule ou couple';
        }
        
        $conditionsAdoptionStr = implode(', ', $conditionsAdoption);
        
        // Insérer les données dans la table "details_animaux"
        $statement = "INSERT INTO details_animaux (animal_id, conditions_adoption) VALUES (:animal_id, :conditions_adoption)";
        $stmt = $this->db->prepare($statement);
        $stmt->execute(['animal_id' => $animalId, 'conditions_adoption' => $conditionsAdoptionStr]);

        $statement = "INSERT INTO depots_adoption (animal_id, connexion_id, date_depot) VALUES (:animal_id, :connexion_id, NOW())";
        $stmt = $this->db->prepare($statement);
        $stmt->execute(['animal_id' => $animalId, 'connexion_id' => $id]);

      return $this->twig->render('success.html.twig', [
        'connexion' => ['login' => $login], 
        'animalId' => $animalId,
        'nom' => $nom,
      ]);
    }
      return $this->twig->render('form.html.twig', ['connexion' => ['login' => $login]]);
  }

  #[Route("/register", name: "register", httpMethod: "GET")]
  public function register(): string
  {
    session_start();
    $login = $_SESSION['login'] ?? null;

    // Vérifier si l'utilisateur est déjà connecté
    if ($login) {
        return $this->twig->render('account.html.twig', ['connexion' => ['login' => $login]]);
    }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $login = $_POST['login'];
          $mot_de_passe = $_POST['mot_de_passe'];

          // Vérifier si le login existe déjà dans la base de données
          $statement = "SELECT COUNT(*) as count FROM connexion WHERE login = :login";
          $stmt = $this->db->prepare($statement);
          $stmt->execute(['login' => $login]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($result['count'] > 0) {
              // Afficher une erreur si le login existe déjà
              return $this->twig->render('register.html.twig', ['error' => 'Ce nom d\'utilisateur existe déjà']);
          }

          $token = bin2hex(random_bytes(32));
          $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

          $insertStatement = "INSERT INTO connexion (login, mot_de_passe, token) VALUES (:login, :mot_de_passe, :token)";
          $insertStmt = $this->db->prepare($insertStatement);
          $insertStmt->execute(['login' => $login, 'mot_de_passe' => $hashed_password, 'token' => $token]);

          // Récupérer les données du login depuis la base de données
          $selectStatement = "SELECT login, id FROM connexion WHERE login = :login";
          $selectStmt = $this->db->prepare($selectStatement);
          $selectStmt->execute(['login' => $login]);
          $connexion = $selectStmt->fetch(PDO::FETCH_ASSOC);

          // Stocker le login dans la session
          $_SESSION['login'] = $connexion['login'];
          $_SESSION['id'] = $connexion['id'];

          return $this->twig->render('account.html.twig', ['connexion' => $connexion]);
      }

      return $this->twig->render('register.html.twig');
  }


  #[Route("/login", name: "login", httpMethod: "GET")]
public function login(): string
{
    session_start();
    $login = $_SESSION['login'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $mot_de_passe = $_POST['mot_de_passe'];

        $statement = "SELECT connexion.id, connexion.login, connexion.mot_de_passe FROM connexion WHERE connexion.login = :login";
        $stmt = $this->db->prepare($statement);
        $stmt->execute(['login' => $login]);
        $connexion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($connexion && password_verify($mot_de_passe, $connexion['mot_de_passe'])) {
            $_SESSION['login'] = $connexion['login'];
            $_SESSION['id'] = $connexion['id'];

            return $this->twig->render('account.html.twig', ['connexion' => $connexion]);
        } else {
            return $this->twig->render('login.html.twig', ['error' => 'Le mot de passe est incorrect']);
        }
    }

    return $this->twig->render('login.html.twig', ['connexion' => $login]);
}


  #[Route("/logout", name: "logout", httpMethod: "GET")]
  public function logout(): string
  {
      session_start();
      // Détruire toutes les données de session
      session_destroy();

      return $this->twig->render('index.html.twig');
  }

  #[Route("/account", name: "account", httpMethod: "GET")]
  public function account(): string
  {
    session_start();
    $login = $_SESSION['login'] ?? null;
    $id = $_SESSION['id'] ?? null;
    $animalId = $_POST['animalId'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $login && $id && $animalId) {
        // Vérifier si une demande d'adoption existe déjà pour cet utilisateur et cet animal
        $existingStatement = "SELECT COUNT(*) as count FROM demandes_adoption WHERE animal_id = :animalId AND connexion_id = :loginId";
        $existingStmt = $this->db->prepare($existingStatement);
        $existingStmt->execute(['animalId' => $animalId, 'loginId' => $id]);
        $existingResult = $existingStmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existingResult['count'] == 0) {
            // Insérer la demande d'adoption dans la table
            $insertStatement = "INSERT INTO demandes_adoption (animal_id, connexion_id, date_demande) VALUES (:animalId, :loginId, NOW())";
            $insertStmt = $this->db->prepare($insertStatement);
            $insertStmt->execute(['animalId' => $animalId, 'loginId' => $id]);

            $updateStatement = "UPDATE animaux SET disponible = false WHERE id = :animalId";
            $updateStmt = $this->db->prepare($updateStatement);
            $updateStmt->execute(['animalId' => $animalId]);
        }
    }  

    $demandeId = $_POST['demandeId'] ?? null;

      if ($id && $demandeId) {
          // Supprimer la demande d'adoption de la base de données
          $deleteStatement = "DELETE FROM demandes_adoption WHERE id = :demandeId AND connexion_id = :loginId";
          $deleteStmt = $this->db->prepare($deleteStatement);
          $deleteStmt->execute(['demandeId' => $demandeId, 'loginId' => $id]);
      }

      $depotId = $_POST['depotId'] ?? null;

      if ($id && $depotId) {
            // Vérifier si l'animal est présent dans la table demandes_adoption
        $checkStatement = "SELECT COUNT(*) as count FROM demandes_adoption WHERE animal_id = (
          SELECT animal_id FROM depots_adoption WHERE id = :depotId AND connexion_id = :loginId
      )";
        $checkStmt = $this->db->prepare($checkStatement);
        $checkStmt->execute(['depotId' => $depotId, 'loginId' => $id]);
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

      if ($checkResult['count'] == 0) {
          // Supprimer l'animal de la table depots_adoption
          $deleteDepotStatement = "DELETE FROM depots_adoption WHERE id = :depotId AND connexion_id = :loginId";
          $deleteDepotStmt = $this->db->prepare($deleteDepotStatement);
          $deleteDepotStmt->execute(['depotId' => $depotId, 'loginId' => $id]);

          // Supprimer l'animal de la table animaux
          $deleteAnimalStatement = "DELETE FROM animaux WHERE id = (
              SELECT animal_id FROM depots_adoption WHERE id = :depotId AND connexion_id = :loginId
          )";
          $deleteAnimalStmt = $this->db->prepare($deleteAnimalStatement);
          $deleteAnimalStmt->execute(['depotId' => $depotId, 'loginId' => $id]);
      } else {
          // L'animal est présent dans la table demandes_adoption, afficher un message d'erreur
          return $this->twig->render('account.html.twig', ['error' => "L'animal est en demande d'adoption. Vous ne pouvez plus supprimer ce dépôt d'adoption."]);
      }
    }

      $statement='SELECT * FROM animaux INNER JOIN demandes_adoption ON demandes_adoption.animal_id = animaux.id WHERE connexion_id = :loginId';
      $stmt = $this->db->prepare($statement);
      $stmt->execute(['loginId' => $id]);
      $demandes_adoption = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $statement2="SELECT * FROM animaux INNER JOIN depots_adoption ON depots_adoption.animal_id = animaux.id WHERE connexion_id = :loginId";
      $stmt2 = $this->db->prepare($statement2);
      $stmt2->execute(['loginId' => $id]);
      $depots_adoption = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      
    return $this->twig->render('account.html.twig',[ 'connexion' => ['login' => $login], 'demandes_adoption' => $demandes_adoption, 'depots_adoption' => $depots_adoption]);
  }

}
