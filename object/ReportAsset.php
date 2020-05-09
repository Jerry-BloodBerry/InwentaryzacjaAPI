<?php


class ReportAsset implements JsonSerializable
{
   private $id;
   private $type;
   private $asset_type_name;
   private $new_asset;
   private $moved;
   private $moved_from_id;
   private $moved_from_name;
   private $previous_room;
   private $present;

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
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param integer $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAssetTypeName()
    {
        return $this->asset_type_name;
    }

    /**
     * @param string $asset_type_name
     */
    public function setAssetTypeName($asset_type_name)
    {
        $this->asset_type_name = $asset_type_name;
    }

    /**
     * @return boolean
     */
    public function getNewAsset()
    {
        return $this->new_asset;
    }

    /**
     * @param boolean $new_asset
     */
    public function setNewAsset($new_asset)
    {
        $this->new_asset = $new_asset;
    }

    /**
     * @return boolean
     */
    public function getMoved()
    {
        return $this->moved;
    }

    /**
     * @param boolean $moved
     */
    public function setMoved($moved)
    {
        $this->moved = $moved;
    }

    /**
     * @return integer|NULL
     */
    public function getMovedFromId()
    {
        return $this->moved_from_id;
    }

    /**
     * @param integer|NULL $moved_from_id
     */
    public function setMovedFromId($moved_from_id)
    {
        $this->moved_from_id = $moved_from_id;
    }

    /**
     * @return string|NULL
     */
    public function getMovedFromName()
    {
        return $this->moved_from_name;
    }

    /**
     * @param string|NULL $moved_from_name
     */
    public function setMovedFromName($moved_from_name)
    {
        $this->moved_from_name = $moved_from_name;
    }

    /**
     * @return integer
     */
    public function getPreviousRoom()
    {
        return $this->previous_room;
    }

    /**
     * @param integer $previous_room
     */
    public function setPreviousRoom($previous_room)
    {
        $this->previous_room = $previous_room;
    }

    /**
     * @return boolean
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * @param boolean $present
     */
    public function setPresent($present)
    {
        $this->present = $present;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
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