<?php


class Building implements JsonSerializable
{
    private $id;
    private $name;

    /**
     * @return NULL|integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer|NULL $id
     */
    public function setId(?int $id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return string|NULL
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|NULL $name
     */
    public function setName(?string $name)
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