<?php
include_once '../repository/UserRepository.php';
include_once 'Token.php';
include_once '../repository/SessionRepository.php';
include_once '../config/Database.php';
include_once '../object/Session.php';

class Login
{
   static function userLogin($data)
   {
       // get database connection
       $database = new Database();
       $db = $database->getConnection();

       //check if complete data was passed
       if(empty($data->login) || empty($data->password))
       {
           http_response_code(400);
           echo json_encode(array("message" => "Incomplete data. Request could not be processed"));
       }
       else {
           //sanitize input data
           $login = htmlspecialchars(strip_tags($data->login));
           $password = htmlspecialchars(strip_tags($data->password));

           $ur = new UserRepository($db);
           $user = $ur->findOneByLogin($login);

           if($user!=null) {
               if(password_verify($password,$user->getHash()))
               {
                   $sr = new SessionRepository($db);

                   $session = new Session();
                   $session->setCreateDate(new DateTime('now'));
                   $session->setExpirationDate(new DateTime('tomorrow'));
                   $session->setToken(Token::getToken(20));
                   $session->setUserId($user->getId());

                   if($sr->addNew($session))
                   {
                       header("Authorization: Bearer " . $session->getToken());
                       http_response_code(200);
                       echo json_encode(array("message" => "Login success"));
                   }
                   else {
                       http_response_code(500);
                       echo json_encode(["message" => "Incomplete data passed to service. Unable to create session."]);
                   }
               }
               else
               {
                   http_response_code(401);
                   echo json_encode(array("message" => "Invalid login or password"));
               }
           }
           else {
               http_response_code(401);
               echo json_encode(array("message" => "Invalid login or password"));
           }
       }
   }
}