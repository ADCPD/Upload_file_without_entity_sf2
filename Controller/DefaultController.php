<?php

namespace TraitUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TraitUploadBundle\Consts\FlashBagConst;
use TraitUploadBundle\Entity\UploadWithTrait;
use TraitUploadBundle\Form\TraitFileUploadType;

/**
 * Class DefaultController
 * @package TraitUploadBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * return index template page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultTemplateAction()
    {
        return $this->render('@TraitUpload/Default/template.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
         $files = $em->getRepository('TraitUploadBundle:UploadWithTrait')->findAll();

        if (!$files) {
            throw $this->createNotFoundException('Aucune information n\'est disponible dans le base de données');
        }

        return $this->render('TraitUploadBundle:Default:index.html.twig', array(
            'entities' => $files,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $file = new UploadWithTrait();

        $form = $this->createForm(new TraitFileUploadType(), $file);
        $form->handleRequest($request);

        /** Manager */
        $file_manager = $this->get('trait_upload.manager.upload_with_trait_manager');

        if ($form->isSubmitted() && $form->isValid()) {

            $file_manager->getValidateUpload($file);

            /** upload() & addUpdateDate */
            $file_manager->getValidateUpload($file);

            /** persist & flush methode*/
            $file_manager->persistAndFlush($file);

            $this->get("session")->getFlashBag()->add(FlashBagConst::success_alert, FlashBagConst::success_message);
            return $this->redirectToRoute('trait_upload_show', array('id' => $file->getId()));
        }
        $this->get("session")->getFlashBag()->add(FlashBagConst::danger_alert, FlashBagConst::danger_message);
        return $this->render('TraitUploadBundle:Default:new.html.twig', array(
            'pannier' => $file,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param UploadWithTrait $file
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(UploadWithTrait $file)
    {
        $deleteForm = $this->createDeleteForm($file);

        return $this->render('TraitUploadBundle:Default:show.html.twig', array(
            'entity' => $file,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param UploadWithTrait $file
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, UploadWithTrait $file)
    {
        $deleteForm = $this->createDeleteForm($file);
        $editForm = $this->createForm(new TraitFileUploadType(), $file);
        $editForm->handleRequest($request);

        /** Manager */
        $file_manager = $this->get('trait_upload.manager.upload_with_trait_manager');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /** upload() & addUpdateDate */
            $file_manager->getValidateUpload($file);
            /** persist & flush methode*/
            $file_manager->persistAndFlush($file);
            $this->get("session")->getFlashBag()->add(FlashBagConst::success_alert, FlashBagConst::success_message);
            return $this->redirectToRoute('trait_upload_edit', array('id' => $file->getId()));
        }
        $this->get("session")->getFlashBag()->add(FlashBagConst::danger_alert, FlashBagConst::danger_message);
        return $this->render('TraitUploadBundle:Default:edit.html.twig', array(
            'entity' => $file,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param UploadWithTrait $file
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, UploadWithTrait $file)
    {
        $form = $this->createDeleteForm($file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }
        $this->get("session")->getFlashBag()->add(FlashBagConst::danger_alert, FlashBagConst::danger_message);
        return $this->redirectToRoute('trait_upload_index');
    }

    /**
     * Delete formType
     *
     * @param UploadWithTrait $file
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(UploadWithTrait $file)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trait_upload_delete', array('id' => $file->getId())))
            ->setMethod('DELETE')
            ->setAttribute('class', 'btn btn-danger btn-block')
            ->setAttribute('style', 'margin-top:5px;')
            ->getForm();
    }
}
