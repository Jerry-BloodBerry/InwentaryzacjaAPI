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