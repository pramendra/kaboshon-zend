<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Album\Entity\Album,
    Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{

    protected $sm;
    protected $em;

    public function indexAction()
    {
        return new ViewModel(array(
                    'albums' => $this->em()->getRepository('Album\Entity\Album')->findAll(),
                ));
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();

            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $album->populate($form->getData());
                $this->em()->persist($album);
                $this->em()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id)
            return $this->redirect()->toRoute('album', array('action' => 'add'));

        $album = $this->em()->find('Album\Entity\Album', $id);
        $form  = new AlbumForm();
        $form->setBindOnValidate(false);
        $form->bind($album);
        $form->get('submit')->setAttribute('label', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->em()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id'   => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id    = (int) $request->getPost()->get('id');
                $album = $this->em()->find('Album\Entity\Album', $id);
                if ($album) {
                    $this->em()->remove($album);
                    $this->em()->flush();
                }
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id'    => $id,
            'album' => $this->em()->find('Album\Entity\Album', $id)
        );
    }

    public function testAction()
    {                
        $data = $this->em()->getRepository('Album\Entity\Bug')->getOpenBugsByProduct();           
        return array('data' => $data);
    }

    protected function em()
    {
        if (null === $this->em) {
            $this->em = $this->sm()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    protected function sm()
    {
        if (!$this->sm)
            $this->sm = $this->getServiceLocator();
        return $this->sm;
    }

}