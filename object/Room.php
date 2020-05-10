<?php


class Room implements JsonSerializable
{
    private $id;
    private $name;
    private $building;

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
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding(Building $building)
    {
        $this->building = $building;
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => (int) $this->id,
            "name" => $this->name,
            "building" => $this->building
        ];
    }
}