<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 12/07/2016
 * Time: 10:33
 */

namespace TraitUploadBundle\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;


/**
 * Class FileUploader
 * @package TraitUploadBundle\Traits
 */
Trait FileUploader
{


    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;


    /**
     * @var UploadedFile
     */
    private $file;


    /**
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
//        return 'img/uploads';

        return 'image/upload/' . $this->direcion_file_path;
    }

    /**
     * Method to upload file / to add in the controller
     * @ORM\PostPersist()
     */
    public function upload()
    {

        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }


    /**
     * @ORM\PrePersist()
     */
    public function preUpload()
    {
        if ($this->file) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid('file_') . '.' . $this->file->guessExtension());
        }
    }

    /**
     * @return null|string
     */
    public function getFullPath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->id . '.' . $this->path;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getFullPath()) {
            unlink($file);
        }
    }
}