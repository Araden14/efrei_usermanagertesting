<?php

class UserManager {
    private PDO $db;

    public function __construct() {
        $dsn = "mysql:host=127.0.0.1;dbname=user_management;charset=utf8";
        $username = "root"; // Modifier si besoin
        $password = "root"; // Modifier si besoin
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function addUser(string $name, string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO users (name, email, created_at, updated_at) VALUES (:name, :email, :created_at, :updated_at)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'created_at' => $currentTime,
            'updated_at' => $currentTime
        ]);
    }

    public function removeUser(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() === 0) {
            throw new InvalidArgumentException("Utilisateur introuvable.");
        }
    }

    public function getUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUser(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        if (!$user) throw new Exception("Utilisateur introuvable.");
        return $user;
    }

    public function updateUser(int $id, string $name, string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email, updated_at = :updated_at WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'updated_at' => $currentTime
        ]);
    }
}
?>
