<?php
include_once '../object/Room.php';
include_once '../object/User.php';

class ReportHeader implements JsonSerializable
{
    /** integer id raportu  */
    private $id;

    /** string nazwa raportu */
    private $name;

    /** DateTime utworzenia raportu  */
    private $create_date;
    private $owner;
    private $room;
    /**
     * Zwraca id raportu
     * @return integer id raportu
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Ustawia id raportu
     * @param integer $id id raportu
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Zwraca nazwe raportu
     * @return string nazwa raportu
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Ustawia nazwe raportu
     * @param string $name nazwa raportu
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Zwraca date utworzenia raportu
     * @return DateTime data utworzenia raportu
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Ustawia date utworzenia raportu
     * @param DateTime $create_date data utworzenia raportu
     */
    public function setCreateDate(DateTime $create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room): void
    {
        $this->room = $room;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => (int)$this->id,
            "name" => $this->name,
            "create_date" => $this->create_date,
            "owner" => $this->owner->jsonSerializeNoHash(),
            "room" => $this->room
        ];
    }
}