<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 12/07/2016
 * Time: 10:41
 */

namespace TraitUploadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TraitUploadBundle\Consts\PathToUploadConst;
use TraitUploadBundle\Traits\CycleCallBackTrait;
use TraitUploadBundle\Traits\FileUploader;

/**
 * Class UploadWithTrait
 * @ORM\Table(name="upload_trait")
 * @ORM\Entity(repositoryClass="TraitUploadBundle\Repository\UploadWithTraitRepository")
 * @ORM\HasLifecycleCallbacks
 */
class UploadWithTrait
{

    /**
     * Definir le nom de dossier ou les documents seront enregistrer
     * Cette attribue sera utiliser dans la methode d'upload (use FileUploader)
     *
     * @var string
     */
    private $direcion_file_path = PathToUploadConst::section_about;


    /**
     *  Method d'upload de fichier
     */
    use FileUploader;

    /**
     * Method associer au {{ HasLifecycleCallbacks }}
     */
    use CycleCallBackTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}