<?php


class Report
{
    private $id;
    private $name;
    private $room;
    private $create_date;
    private $owner;

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
     * @return integer
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param integer $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return datetime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param datetime $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return integer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param integer $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

}