<?php

/** Klasa srodka trwalego w raporcie */
class ReportAsset implements JsonSerializable
{
    /** integer id srodka trwalego */
    private $id;

    /** integer typ srodka trwalego */
    private $type;

    /** string nazwa typu srodka trwalego  */
    private $asset_type_name;

    /** boolean czy nowy srodek trwaly */
    private $new_asset;

    /** boolean czy srodek trwaly zostal przeniesiony */
    private $moved;

    /** integer id pokoju z ktorego srodek trwaly zostal przeniesiony */
    private $moved_from_id;

    /** string nazwa pokoju z ktorego srodek trwaly zostal przeniesiony */
    private $moved_from_name;

    /** integer id pokoju z ktorego srodek trwaly zostal przeniesiony? */
    private $previous_room;

    /** boolean czy srodek trwaly znajduje obecnie sie w tym pokoju  */
    private $present;


    /**
     * Zwraca id srodka trwalego
     * @return integer id srodka trwalego
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Ustawia id srodka trwalego
     * @param integer $id id srodka trwalego
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Zwraca typ srodka trwalego
     * @return integer typ srodka trwalego
     */
    public function getType()
    {
        return (int) $this->type;
    }

    /**
     * Ustawia typ srodka trwalego
     * @param integer $type typ srodka trwalego
     */
    public function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * Zwraca nazwe typu srodka trwalego
     * @return string nazwa typu srodka trwalego
     */
    public function getAssetTypeName()
    {
        return $this->asset_type_name;
    }

    /**
     * Ustawia nazwe typu srodka trwalego
     * @param string $asset_type_name nazwa typu srodka trwalego
     */
    public function setAssetTypeName(string $asset_type_name)
    {
        $this->asset_type_name = $asset_type_name;
    }

    /**
     * Zwraca czy srodek trwaly jest nowy
     * @return boolean czy nowy srodek trwaly
     */
    public function getNewAsset()
    {
        return $this->new_asset;
    }

    /**
     * Ustawia czy srodek trwaly jest nowy
     * @param boolean $new_asset czy nowy srodek trwaly
     */
    public function setNewAsset(bool $new_asset)
    {
        $this->new_asset = $new_asset;
    }

    /**
     * Zwraca czy srodek trwaly zostal przeniesiony
     * @return boolean czy srodek trwaly zostal przeniesiony
     */
    public function getMoved()
    {
        return $this->moved;
    }

    /**
     * Ustawia czy srodek trwaly zostal przeniesiony
     * @param boolean $moved czy srodek trwaly zostal przeniesiony
     */
    public function setMoved(bool $moved)
    {
        $this->moved = $moved;
    }

    /**
     * Zwraca id pokoju z ktorego srodek trwaly zostal przeniesiony
     * @return integer|NULL id pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function getMovedFromId()
    {
        return $this->moved_from_id;
    }

    /**
     * Ustawia id pokoju z ktorego srodek trwaly zostal przeniesiony
     * @param integer|NULL $moved_from_id id pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function setMovedFromId(?int $moved_from_id)
    {
        $this->moved_from_id = $moved_from_id;
    }

    /**
     * Zwraca nazwe pokoju z ktorego srodek trwaly zostal przeniesiony
     * @return string|NULL nazwa pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function getMovedFromName()
    {
        return $this->moved_from_name;
    }

    /**
     * Ustawia nazwe pokoju z ktorego srodek trwaly zostal przeniesiony
     * @param string|NULL $moved_from_name nazwa pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function setMovedFromName(?string $moved_from_name)
    {
        $this->moved_from_name = $moved_from_name;
    }

    /**
     * Zwraca id pokoju z ktorego srodek trwaly zostal przeniesiony
     * @return integer|NULL id pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function getPreviousRoom()
    {
        return $this->previous_room;
    }

    /**
     * Ustawia id pokoju z ktorego srodek trwaly zostal przeniesiony
     * @param integer|NULL $previous_room id pokoju z ktorego srodek trwaly zostal przeniesiony
     */
    public function setPreviousRoom(?int $previous_room)
    {
        $this->previous_room = $previous_room;
    }

    /**
     * Zwraca czy srodek trwaly znajduje obecnie sie w tym pokoju
     * @return boolean czy srodek trwaly znajduje obecnie sie w tym pokoju
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * Ustawia czy srodek trwaly znajduje obecnie sie w tym pokoju
     * @param boolean $present czy srodek trwaly znajduje obecnie sie w tym pokoju
     */
    public function setPresent(bool $present)
    {
        $this->present = $present;
    }

    /**
     * Zwraca srodek trwaly w raporcie w postaci JSON
     * @return string srodek trwaly w raporcie w postaci JSON
     */
    public function jsonSerialize()
    {
        return [
            'id' => (int)$this->id,
            'type' => $this->type,
            'asset_type_name' => $this->asset_type_name,
            'new_asset' => $this->new_asset,
            'moved' => $this->moved,
            'moved_from_id' => $this->moved_from_id,
            'moved_from_name' => $this->moved_from_name,
            'previous_room' => $this->previous_room,
            'present' => $this->present
        ];
    }
}