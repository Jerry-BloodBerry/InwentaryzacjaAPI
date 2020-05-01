<?php


class ReportAsset implements JsonSerializable
{
    private $report_id;
    private $asset_id;
    private $previous_room;

    /**
     * @return integer
     */
    public function getReportId()
    {
        return $this->report_id;
    }

    /**
     * @param integer $report_id
     */
    public function setReportId($report_id)
    {
        $this->report_id = $report_id;
    }

    /**
     * @return integer
     */
    public function getAssetId()
    {
        return $this->asset_id;
    }

    /**
     * @param integer $asset_id
     */
    public function setAssetId($asset_id)
    {
        $this->asset_id = $asset_id;
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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'report_id' => $this->report_id,
            'asset_id' => $this->asset_id,
            'previous_room' => $this->previous_room
        ];
    }
}