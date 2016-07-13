<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 12/07/2016
 * Time: 10:54
 */

namespace TraitUploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TraitFileUploadType
 * @package TraitUploadBundle\Form
 */
class TraitFileUploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => "Nom du fichier : "
            ))
            ->add('file', 'file', array(
                'label' => 'uploader : '
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TraitUploadBundle\Entity\UploadWithTrait'
        ));
    }
}