<?php

namespace Kbh\GestionCongesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Kbh\GestionCongesBundle\Entity\ParamPermissions;
use Kbh\GestionCongesBundle\Form\ParamPermissionsType;

/**
 * ParamPermissions controller.
 *
 */
class ParamPermissionsController extends Controller
{

    /**
     * Lists all ParamPermissions entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KbhGestionCongesBundle:ParamPermissions')->findAll();

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ParamPermissions entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ParamPermissions();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('parampermissions_show', array('id' => $entity->getId())));
        }

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ParamPermissions entity.
     *
     * @param ParamPermissions $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ParamPermissions $entity)
    {
        $form = $this->createForm(new ParamPermissionsType(), $entity, array(
            'action' => $this->generateUrl('parampermissions_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ParamPermissions entity.
     *
     */
    public function newAction()
    {
        $entity = new ParamPermissions();
        $form   = $this->createCreateForm($entity);

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ParamPermissions entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KbhGestionCongesBundle:ParamPermissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParamPermissions entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ParamPermissions entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KbhGestionCongesBundle:ParamPermissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParamPermissions entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ParamPermissions entity.
    *
    * @param ParamPermissions $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ParamPermissions $entity)
    {
        $form = $this->createForm(new ParamPermissionsType(), $entity, array(
            'action' => $this->generateUrl('parampermissions_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ParamPermissions entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KbhGestionCongesBundle:ParamPermissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ParamPermissions entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parampermissions_edit', array('id' => $id)));
        }

        return $this->render('KbhGestionCongesBundle:Admin\ParamPermissions:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ParamPermissions entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KbhGestionCongesBundle:ParamPermissions')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ParamPermissions entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('parampermissions'));
    }

    /**
     * Creates a form to delete a ParamPermissions entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parampermissions_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
