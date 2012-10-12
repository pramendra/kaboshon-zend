<?php

namespace Album\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * A music album.
 *
 * @ORM\Entity
 * @ORM\Table(name="album")
 * @property string $artist
 * @property string $title
 * @property int $id
 */
class Album extends \Abstracts\Entity
{
     /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $artist;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    
    protected $inputFilter;

    public function getData()
    {
        $data = $this->getArrayCopy();
        unset($data['id']);
        return $data;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name'     => 'id',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name'     => 'artist',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'StripTags'),
                            array('name'       => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 1,
                                    'max'      => 100,
                                ),
                            ),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name'     => 'title',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'StripTags'),
                            array('name'       => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 1,
                                    'max'      => 100,
                                ),
                            ),
                        ),
                    )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}