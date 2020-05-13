<?php
include_once '../repository/SessionRepository.php';
include_once '../object/Session.php';
include_once 'BearerToken.php';

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
    
    private static function authorizeUser($token)

    {

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        $sr = new SessionRepository($db);
        $session = $sr->findOneByToken($token);

        if($session!=null)
        {
            try {
                return (self::validateTokenExpiry($session));
            } catch (Exception $e) {
                echo "Exception was thrown while validating token expiry: " . $e->getMessage();
            }
        }
        return false;
    }

    /**
     * 
     * Funkcja sprawdza czy Token przekazany przez uzytkownika nadal jest wazny
     * @param $session - obiekt typu session
     * @return bool w zaleznosci od tego czy jest nadal wazny, czy wygasl
     */
    private static function validateTokenExpiry($session)
    {
        return ($session->getExpirationDate()>new DateTime('now'));
    }
    /**
     * Funkcja przeprowadzajaca autoryzacje uzytkownika
     * @return bool w zaleznosci od tego czy autoryzacja powiodla sie
     */

    public static function performAuthorization()
    {
        if(!empty(BearerToken::getBearerToken())) {
            if(Security::authorizeUser(BearerToken::getBearerToken())) {
                return true;
            }
            else {
                http_response_code(503);
                echo json_encode(array("message" => "User authentication failed. Invalid or expired token", "auth" => false));
                return false;
            }
        }
        else {
            http_response_code(400);
            echo json_encode(array("message" => "Authentication failed. Auth token missing.", "auth" => false));
            return false;
        }
    }
}