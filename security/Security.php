<?php
include_once '../repository/SessionRepository.php';
include_once '../object/Session.php';

class Security
{
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
     * @param Session $session
     * @return bool
     * @throws Exception
     */
    private static function validateTokenExpiry($session)
    {
        return (new DateTime($session->getExpirationDate())>new DateTime('now'));
    }
}