<?php
include_once 'Building.php';
include_once 'AssetType.php';
include_once 'Room.php';

class Asset implements JsonSerializable
{
    //fields
    private $id;
    private $assetType;
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
        $this->id = (int) $id;
    }

    /**
     * @return AssetType
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * @param AssetType $assetType
     */
    public function setAssetType(AssetType $assetType)
    {
        $this->assetType = $assetType;
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
    public function setRoom(Room $room)
    {
        $this->room = $room;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $json = array();
        $json['id'] = (int) $this->id;
        $json['type'] = $this->assetType;
        if($this->room != null)
            $json['room'] = $this->room;
        return $json;
    }
}