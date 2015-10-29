<?php

namespace ENI\QCM\Bundle\FormateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Doctrine\ORM\EntityRepository;
use ENI\QCM\Bundle\FormateurBundle\Entity\Theme;

class EnrichedTestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                /*
            ->add('name')
            ->add('timepassing')
            ->add('description')
            ->add('step1')
            ->add('step2')
                 * 
                 */
                /*
            ->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme'))
                ;
                 */
                 /*
                
            ->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
             'query_builder' => function (EntityRepository $t) {
                return $t->createQueryBuilder('t')
                        ->select('t')
                        ->orderBy('t.id', 'DESC');
            },
        ));*/
            
                 
                /*
            ->add('sectionid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Section'))
                 */
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ENI\QCM\Bundle\FormateurBundle\Entity\EnrichedTest'
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