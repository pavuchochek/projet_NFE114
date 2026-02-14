<?php
require('../models/Database.php');
class AuthDTO  {

    public static function login($email, $password, $role) {
        switch($role) {
            case 'Adherent':
                return self::loginAdherent($email, $password);
            case 'Coach':
                return self::loginCoach($email, $password);
            case 'Admin':
                return self::loginAdmin($email, $password);
            default:
                return false;
        }
    }

    public static function loginAdherent($email, $password) {
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT id_adherent, mdp FROM adherent WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['mdp'])) {
            return $user['id_adherent'];
        }
        return false;
    }

    public static function loginCoach($email, $password) {
        $stmt = Database::getInstance()->getConnection()->prepare("SELECT id_coach, mdp FROM coach WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['mdp'])) {
            return $user['id_coach'];
        }
        return false;
    }

    public static function loginAdmin($email, $password) {
        if($email === $_ENV['ADMIN_EMAIL'] && $password === $_ENV['ADMIN_PASSWORD']) {
            return $_ENV['ADMIN_ID'];
        return false;
    }
    }
}

