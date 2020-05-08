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
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
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
    public function setName($name)
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
    public function setCreateDate($create_date)
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
    public function setOwnerId($owner_id)
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
    public function setOwnerName($owner_name)
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
    public function setRoomName($room_name)
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
    public function setBuildingName($building_name)
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
    public function setRoomId($room_id)
    {
        $this->room_id = $room_id;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "create_date" => $this->create_date,
            "owner_id" => $this->owner_id,
            "owner_name" => $this->owner_name,
            "room_name" => $this->room_name,
            "building_name" => $this->building_name
        ];
    }
}