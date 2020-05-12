<?php
include_once '../object/Room.php';
include_once '../object/User.php';

class ReportHeader implements JsonSerializable
{
    private $id;
    private $name;
    private $create_date;
    private $owner;
    private $room;
    /**
     * @return integer
     */
    public function getId()
    {
        return (int) $this->id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param DateTime $create_date
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