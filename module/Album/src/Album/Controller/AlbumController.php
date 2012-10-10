<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Album\Model\Album,
    Album\Form\AlbumForm;


class AlbumController extends AbstractActionController
{
    protected $albumTable;
    protected $bugTable;
    protected $userTable;
    protected $productTable;
    protected $sm;

    public function indexAction()
    {
        var_dump($this->getBugTable()->select());
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter())
                ->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }
        $album = $this->getAlbumTable()->getAlbum($id);

        $form  = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id'    => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable)
            $this->albumTable = $this->sm()->get('AlbumTable');
        return $this->albumTable;
    }

    public function getProductTable()
    {
        if (!$this->productTable)
            $this->productTable = $this->sm()->get('ProductTable');
        return $this->productTable;
    }

    public function getUserTable()
    {
        if (!$this->userTable)
            $this->userTable = $this->sm()->get('UserTable');
        return $this->userTable;
    }

    public function getBugTable()
    {
        if (!$this->bugTable)
            $this->bugTable = $this->sm()->get('BugTable');
        return $this->bugTable;
    }

    public function sm()
    {
        if (!$this->sm)
            $this->sm = $this->getServiceLocator();
        return $this->sm;
    }
}