<?php


class ReportAsset implements JsonSerializable
{
   private $asset;
   private $new_asset;
   private $moved;
   private $moved_from_room;
   private $previous_room;
   private $present;

    /**
     * @return Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param Asset $asset
     */
    public function setAsset(Asset $asset): void
    {
        $this->asset = $asset;
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
    public function setNewAsset(bool $new_asset)
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
    public function setMoved(bool $moved)
    {
        $this->moved = $moved;
    }

    /**
     * @return Room|NULL
     */
    public function getPreviousRoom()
    {
        return $this->previous_room;
    }

    /**
     * @param Room|NULL $previous_room
     */
    public function setPreviousRoom(?Room $previous_room)
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
    public function setPresent(bool $present)
    {
        $this->present = $present;
    }

    /**
     * @return Room
     */
    public function getMovedFromRoom()
    {
        return $this->moved_from_room;
    }

    /**
     * @param Room $moved_from_room
     */
    public function setMovedFromRoom(Room $moved_from_room): void
    {
        $this->moved_from_room = $moved_from_room;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'asset' => $this->asset,
            'present' => $this->present,
            'previous_room' => $this->previous_room
        ];
    }
}