<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OptionType extends AbstractType
{

    private $_options;

    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('quantity', 'integer', array(
                    'label' => 'How many passwords',
                ))
        ;

        $builder
                ->add('length', 'integer', array(
                    'label' => 'Password length',
                ))
        ;

        foreach ($this->_options as $key => $setting) {
            $builder->add(
                    $builder->create($setting['key'], 'checkbox', array(
                        'value' => $key,
                        'label' => $setting['label'],
                        'required' => false,
                    ))
            );
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }

}
