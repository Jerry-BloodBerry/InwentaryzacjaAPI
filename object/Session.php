<?php


class Session
{
    private $id;
    private $user_id;
    private $token;
    private $expiration_date;
    private $create_date;
    private $expired;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return (int) $this->user_id;
    }

    /**
     * @param integer $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return datetime
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param datetime $expiration_date
     */
    public function setExpirationDate(DateTime $expiration_date)
    {
        $this->expiration_date = $expiration_date;
    }

    /**
     * @return datetime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param datetime $create_date
     */
    public function setCreateDate(DateTime $create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $expired
     */
    public function setExpired(bool $expired)
    {
        $this->expired = $expired;
    }




}