<?php

namespace ENI\QCM\Bundle\FormateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Doctrine\ORM\EntityRepository;

class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('timepassing')
            ->add('description')
            ->add('step1')
            ->add('step2')
            ->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ENI\QCM\Bundle\FormateurBundle\Entity\Test'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eni_qcm_bundle_formateurbundle_test';
    }
}
