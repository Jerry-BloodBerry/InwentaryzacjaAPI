<?php

/** Klasa z metadanymi raportu */
class ReportHeader implements JsonSerializable
{
    /** integer id raportu  */
    private $id;

    /** string nazwa raportu */
    private $name;

    /** DateTime utworzenia raportu  */
    private $create_date;

    /** id wlasciciela raportu */
    private $owner_id;

    /** string nazwa wlasciciela raportu */
    private $owner_name;

    /** string nazwa pokoju raportu */
    private $room_name;

    /** integer id pokoju raportu  */
    private $room_id;

    /** string nazwa budynku  */
    private $building_name;

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
     * Zwraca id wlascieciela
     * @return integer id wlasciciela
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Ustawia id wlascieciela
     * @param integer $owner_id id wlascieciela
     */
    public function setOwnerId(int $owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * Zwraca nazwe wlasciciela
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