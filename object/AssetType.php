<?php


class AssetType implements JsonSerializable
{
    private $id;
    private $letter;
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
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * @param string $letter
     */
    public function setLetter(string $letter)
    {
        $this->letter = $letter;
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
            "id" => (int) $this->id,
            "letter" => $this->letter,
            "name" => $this->name
        ];
    }
}