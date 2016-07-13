<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 13/07/2016
 * Time: 14:56
 */

namespace TraitUploadBundle\Traits;

/**
 * Class CycleCallBackTrait
 * @package TraitUploadBundle\Traits
 */
Trait CycleCallBackTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upload_date", type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * Initialiser à la date : à la date du jour system
     *
     * @ORM\PreUpdate
     */
    public function addUpdateDate()
    {
        $this->setUpdateDate($this->init());
    }


    /**
     * @param $updateDate
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * get dateUpload
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @return \DateTime
     */
    public function init()
    {
        return new \DateTime('now');
    }


}