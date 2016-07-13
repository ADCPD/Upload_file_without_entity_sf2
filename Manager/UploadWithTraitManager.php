<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 13/07/2016
 * Time: 15:08
 */

namespace TraitUploadBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Class UploadWithTraitManager
 * @package TraitUploadBundle\Manager
 */
class UploadWithTraitManager extends BasicManager
{
    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * UploadWithTraitManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
    }

    /**
     * @return \TraitUploadBundle\Repository\UploadWithTraitRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository('TraitUploadBundle:UploadWithTrait');
    }


    /**
     * Method qui  upload un fichier et initialise sa date d'upload
     *
     * @param $entity
     */
    public function getValidateUpload($entity)
    {
        $entity->upload();
        $entity->addUpdateDate();
    }
}