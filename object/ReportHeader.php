<?php


class ReportHeader implements JsonSerializable
{
    private $id;
    private $name;
    private $create_date;
    private $owner_id;
    private $owner_name;
    private $room_name;
    private $room_id;
    private $building_name;

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
     * @return integer
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param integer $owner_id
     */
    public function setOwnerId(int $owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return string
     */
    public function getOwnerName()
    {
        return $this->owner_name;
    }

    /**
     * @param string $owner_name
     */
    public function setOwnerName(string $owner_name)
    {
        $this->owner_name = $owner_name;
    }

    /**
     * @return string
     */
    public function getRoomName()
    {
        return $this->room_name;
    }

    /**
     * @param string $room_name
     */
    public function setRoomName(string $room_name)
    {
        $this->room_name = $room_name;
    }

    /**
     * @return string
     */
    public function getBuildingName()
    {
        return $this->building_name;
    }

    /**
     * @param string $building_name
     */
    public function setBuildingName(string $building_name)
    {
        $this->building_name = $building_name;
    }

    /**
     * @return integer
     */
    public function getRoomId()
    {
        return $this->room_id;
    }

    /**
     * @param integer $room_id
     */
    public function setRoomId(int $room_id)
    {
        $this->room_id = $room_id;
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
            "owner_id" => $this->owner_id,
            "owner_name" => $this->owner_name,
            "room_name" => $this->room_name,
            "building_name" => $this->building_name
        ];
    }
}