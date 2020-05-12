<?php


class User implements JsonSerializable
{
    private $id;
    private $login;
    private $hash;

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
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => (int) $this->id,
            "login" => $this->login,
            "hash" => $this->hash
        ];
    }

    public function jsonSerializeNoHash()
    {
        return [
            "id" => (int) $this->id,
            "login" => $this->login
        ];
    }
}