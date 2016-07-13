<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 13/07/2016
 * Time: 15:10
 */

namespace TraitUploadBundle\Manager;


use Doctrine\ORM\EntityManager;

/**
 * Class BasicManager
 * @package TraitUploadBundle\Manager
 */
abstract class BasicManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * BasicManager constructor.
     * @param EntityManager $em 
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

//    /**
//     * @return mixed
//     */
//    abstract function getRepository();

    /**
     * Fusion des deux methodes  persist() &  flush()
     * Method qui permet le sauvegarde des données dans la base
     *
     * @param $entity
     */
    public function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }


}