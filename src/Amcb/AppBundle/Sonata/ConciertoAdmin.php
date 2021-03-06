<?php

namespace Amcb\AppBundle\Sonata;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConciertoAdmin extends Admin
{
    /**
     * Overriden values to the datagrid
     *
     * @var array
     */
    protected $datagridValues = array(
        #'_page'       => 1,
        '_sort_order' => 'DESC',
        #'_per_page'   => 25,
    );

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('tipo')
            ->add('lugar')
            ->add('fecha', 'datetime', array('years' => range(2008, (date('Y') + 1)), 'minutes' => array(0, 15, 30, 45)))
            ->add('noticia')                
            ->add('es_visible', null,       array('required' => false))
            ->add('maps',       null,       array('required' => false))
            ->add('es_gratis',  null,       array('required' => false))
            ->add('entradas',   'ckeditor', array('config_name' => 'mini_link', 'required' => false))
            ->add('programa',   'ckeditor', array('config_name' => 'default', 'required' => false))
            ->add('direccion')
            ->add('file', 'file', array(
                'required' => false,
                'data_class' => null,
                'label' => 'Cartel'
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('tipo')
            ->add('lugar')
            ->add('fecha')
            ->add('noticia')
            ->add('es_visible')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('lugar')
            ->add('fecha', null, array('format' => 'D, d M y, H:i'))
            ->add('noticia')
            ->add('es_visible')
        ;
    }

    public function prePersist($concierto)
    {
        $this->manageFileUpload($concierto);
    }

    public function preUpdate($concierto)
    {
        $this->manageFileUpload($concierto);
    }

    private function manageFileUpload($concierto)
    {
        if ($concierto->getFile()) {
            $concierto->setFechaModificacion(new \DateTime());
        }
    }
}
?>
