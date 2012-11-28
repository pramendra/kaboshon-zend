<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * Catalog\Entity\Category
 *
 * @ORM\Table(name="shop_categories")
 * @ORM\Entity(repositoryClass="Catalog\Repository\Category")
 */
class Category extends \Abstracts\Entity implements InputFilterAwareInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string $descr
     *
     * @ORM\Column(name="descr", type="string", length=100, nullable=true)
     */
    protected $descr;

    /**
     * @var string $metaDescr
     *
     * @ORM\Column(name="meta_descr", type="text", length=255, nullable=true)
     */
    protected $metaDescr;

    /**
     * @var string $metaKeywords
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var Catalog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var Catalog\Entity\Category[]
     *
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @var Catalog\Entity\Product[]
     *
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Product", mappedBy="category")
     */
    protected $products;

    /**
     * input filter for this entity 
     * @var Zend\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->children = new ArrayCollection();
    }

    /**
     * create and return input filter for this entity 
     * @return Zend\InputFilter\InputFilterInterface
     */
    public function initFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        $inputFilter->add($factory->createInput(array(
           'name'       => 'id',
           'required'   => true,
           'filters'    => array(
               array('name' => 'Int'),
           ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 4,
                        'max'      => 100,
                    ),
                ),
            ),
        )));        
    }

    /**
     * {@inheritdoc}
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) 
            $this->inputFilter = $this->initFilter();

        return $this->inputFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }    
}
