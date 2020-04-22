<?php


class Building implements JsonSerializable
{
    private $id;
    private $name;

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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}