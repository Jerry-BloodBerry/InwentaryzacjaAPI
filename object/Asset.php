<?php
include_once 'Building.php';
include_once 'AssetType.php';

class Asset implements JsonSerializable
{
    //fields
    private $id;
    private $assetType;
    private $room;
    private $building;

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
     * @return AssetType
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * @param AssetType $assetType
     */
    public function setAssetType($assetType)
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
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'assetType' => $this->assetType,
            'room' => $this->room,
            'building' => $this->building
        ];
    }
}