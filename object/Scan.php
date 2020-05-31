<?php


class Scan implements JsonSerializable
{
    private $id;
    private $room;
    private $owner;
    private $create_date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setRoom($room): void
    {
        $this->room = $room;
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
    public function setOwner($owner): void
    {
        $this->owner = $owner;
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
    public function setCreateDate($create_date): void
    {
        $this->create_date = $create_date;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'room' => $this->room,
            'owner' => $this->owner,
            'create_date' => $this->create_date
        ];
    }
}