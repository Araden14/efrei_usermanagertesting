<?php

require_once 'UserManager.php';
use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase {
    private PDO $db;
    private UserManager $userManager;
    
    protected function setUp(): void
    {
        $dsn = "mysql:host=127.0.0.1;dbname=user_management;charset=utf8";
        $username = "root";
        $password = "root";
        
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        $this->userManager = new UserManager();
        
        // Nettoyage des données avant chaque test (suppression de tout les utilisateurs)
        $this->db->exec("DELETE FROM users");
    }
    
    public function testAddUser(): void
    {
        $this->userManager->addUser("Arnaud", "arnaud@test.com");
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => 'arnaud@test.com']);
        $user = $stmt->fetch();
        
        $this->assertNotFalse($user, "Échec de l'ajout de l'utilisateur : Utilisateur non trouvé dans la base de données.");
        $this->assertEquals("Arnaud", $user['name'], "Échec de l'ajout de l'utilisateur : Le nom ne correspond pas.");
        echo "Test 'testAddUser' réussi : Utilisateur ajouté avec succès avec le nom 'Arnaud'.\n";
    }

    public function testAddUserEmailException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->addUser("Arnaud", "mailinvalide.fr");
        echo "Test 'testAddUserEmailException' réussi : Exception d'email invalide lancée comme prévu.\n";
    }

    public function testUpdateUser(): void
    {
        $this->userManager->addUser("Arnaud", "arnaud@test.com");
        $user = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $user->execute(['email' => 'arnaud@test.com']);
        $user = $user->fetch();
        $this->userManager->updateUser($user['id'], "Arnaud2", "arnaud@test.com");
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => 'arnaud@test.com']);
        $updatedUser = $stmt->fetch();
        $this->assertEquals("Arnaud2", $updatedUser['name'], "Échec de la mise à jour de l'utilisateur : Le nom ne correspond pas.");
        echo "Test 'testUpdateUser' réussi : Utilisateur mis à jour avec succès au nom 'Arnaud2'.\n";
    }

    public function testRemoveUser(): void
    {
        $this->userManager->addUser("Arnaud", "arnaud@test.com");
        $user = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $user->execute(['email' => 'arnaud@test.com']);
        $user = $user->fetch();
        $this->userManager->removeUser($user['id']);
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => 'arnaud@test.com']);
        $user = $stmt->fetch();
        $this->assertFalse($user, "Échec de la suppression de l'utilisateur : L'utilisateur existe toujours dans la base de données.");
        echo "Test 'testRemoveUser' réussi : Utilisateur supprimé avec succès.\n";
    }

    public function testGetUsers(): void
    {
        $this->userManager->addUser("Arnaud", "arnaud@test.com");
        $this->userManager->addUser("Arnaud2", "arnaud2@test.com");
        $users = $this->userManager->getUsers();
        $this->assertCount(2, $users, "Échec de la récupération des utilisateurs : Le nombre d'utilisateurs ne correspond pas.");
        $this->assertEquals("Arnaud", $users[0]['name'], "Échec de la récupération des utilisateurs : Le nom du premier utilisateur ne correspond pas.");
        $this->assertEquals("Arnaud2", $users[1]['name'], "Échec de la récupération des utilisateurs : Le nom du deuxième utilisateur ne correspond pas.");
        echo "Test 'testGetUsers' réussi : Utilisateurs récupérés avec succès.\n";
    }

    public function testInvalidUpdateThrowsException(): void
    {
        $this->userManager->addUser("Arnaud3", "arnaud3@test.com");
        $user = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $user->execute(['email' => 'arnaud3@test.com']);
        $user = $user->fetch();
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->updateUser($user['id'], "Arnaud3", "mailinvalide.fr");
        echo "Test 'testInvalidUpdateThrowsException' réussi : Exception d'email invalide lancée comme prévu.\n";
    }

    public function testInvalidDeleteThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->removeUser(999999);
        echo "Test 'testInvalidDeleteThrowsException' réussi : Exception d'ID utilisateur invalide lancée comme prévu.\n";
    }
    
}