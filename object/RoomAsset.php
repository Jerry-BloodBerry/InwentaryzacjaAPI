<?php


class RoomAsset implements JsonSerializable
{
    private $asset;
    private $new_asset;
    private $moved;
    private $moved_from_room;

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
    public function setNewAsset(bool $new_asset): void
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
    public function setMoved(bool $moved): void
    {
        $this->moved = $moved;
    }

    /**
     * @return Room|NULL
     */
    public function getMovedFromRoom()
    {
        return $this->moved_from_room;
    }

    /**
     * @param Room|NULL $moved_from_room
     */
    public function setMovedFromRoom(?Room $moved_from_room): void
    {
        $this->moved_from_room = $moved_from_room;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $json = [];
        $json ['asset'] = $this->asset;
        $json ['new_asset'] = $this->new_asset;
        $json ['moved'] = $this->moved;
        $json ['moved_from_room'] = $this->moved_from_room;

        return $json;
    }
}