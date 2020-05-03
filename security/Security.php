<?php
include_once '../repository/SessionRepository.php';
include_once '../object/Session.php';

/**
 * Klasa majaca za zadanie autoryzacje uzytkownika podczas logowania
 */
class Security
{
    /**
     * Funkcja autoryzujaca uzytkownika podczas logowania
     * @param $token - token reprezentujacy zalogowanego uzytkownika w sesji
     * 
     */
    public static function authorizeUser($token)
    {

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        $sr = new SessionRepository($db);
        $session = $sr->findOneByToken($token);

        if($session!=null)
        {
            return (self::validateTokenExpiry($session));
        }
        return false;
    }

    /**
     * 
     * Funkcja sprawdza czy Token przekazany przez użytkownika nadal jest ważny
     * @return true jezeli nadal wazny, a false jezeli juz wygasl 
     */
    private static function validateTokenExpiry($session)
    {
        return (new DateTime($session->getExpirationDate())>new DateTime('now'));
    }
}