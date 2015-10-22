<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssuerafflingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ismarqueted')
            ->add('questionid')
            ->add('registrationid')
            ->add('answerid')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eni_qcm_bundle_stagiairebundle_issueraffling';
    }
}
