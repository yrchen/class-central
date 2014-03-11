<?php

namespace ClassCentral\SiteBundle\Controller;

use ClassCentral\SiteBundle\Entity\CourseStatus;
use ClassCentral\SiteBundle\Entity\UserCourse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ClassCentral\SiteBundle\Entity\Initiative;
use ClassCentral\SiteBundle\Form\InitiativeType;

/**
 * Initiative controller.
 *
 */
class InitiativeController extends Controller
{
    /**
     * Lists all Initiative entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ClassCentralSiteBundle:Initiative')->findAll();

        return $this->render('ClassCentralSiteBundle:Initiative:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Initiative entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Initiative')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Initiative entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClassCentralSiteBundle:Initiative:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Initiative entity.
     *
     */
    public function newAction()
    {
        $entity = new Initiative();
        $form   = $this->createForm(new InitiativeType(), $entity);

        return $this->render('ClassCentralSiteBundle:Initiative:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Initiative entity.
     *
     */
    public function createAction()
    {
        $entity  = new Initiative();
        $request = $this->getRequest();
        $form    = $this->createForm(new InitiativeType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('initiative_show', array('id' => $entity->getId())));
            
        }

        return $this->render('ClassCentralSiteBundle:Initiative:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Initiative entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Initiative')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Initiative entity.');
        }

        $editForm = $this->createForm(new InitiativeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClassCentralSiteBundle:Initiative:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Initiative entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Initiative')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Initiative entity.');
        }

        $editForm   = $this->createForm(new InitiativeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('initiative_edit', array('id' => $id)));
        }

        return $this->render('ClassCentralSiteBundle:Initiative:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Initiative entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ClassCentralSiteBundle:Initiative')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Initiative entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('initiative'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Shows all providers
     */
    public function providersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cache = $this->get('Cache');

        $info = $cache->get('providers_info', array($this, 'getProviders'));

        return $this->render('ClassCentralSiteBundle:Initiative:providers.html.twig',array(
            'page' => 'providers',
            'providers' => $info['providers'],
            'courseCount' => $info['courseCount'] // A map of initiative id to course counts

        ));
    }

    /**
     * Returns all the providers and a map of all the provider id to counts
     *
     */
    public function getProviders()
    {
        $em = $this->getDoctrine()->getManager();
        // Get all providers
        $providers = $em->getRepository('ClassCentralSiteBundle:Initiative')->findAll();

        $validStatusBound = CourseStatus::COURSE_NOT_SHOWN_LOWER_BOUND;
        // Get provider count
        $results = $em->createQuery("
            SELECT i.id, count(DISTINCT c.id) as courseCount
            FROM ClassCentralSiteBundle:Initiative i
            JOIN i.courses c
            WHERE c.status < $validStatusBound
            GROUP BY c.initiative
        ")->getArrayResult();

        $providerCountMap = array();
        foreach($results as $result)
        {
            if( $result['courseCount'] == 0 )
            {
                continue; // Do not show courses with no providers
            }
            $providerCountMap[ $result['id'] ] = $result['courseCount'];
        }

        return array(
            'providers' => $providers,
            'courseCount' => $providerCountMap
        );
    }


}
