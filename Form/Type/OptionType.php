<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type;

use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Hackzilla\PasswordGenerator\Model\Option\Option;
use Hackzilla\PasswordGenerator\Model\Option\OptionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                'label' => 'OPTION_HOW_MANY_PASSWORDS',
            ));

        if (!is_a($options['generator'], 'Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface')) {
            return;
        }

        foreach ($options['generator']->getOptions() as $key => $option) {
            switch ($option->getType()) {
                case Option::TYPE_STRING:
                    $this->addStringType($builder, $key, $option);
                    break;

                case Option::TYPE_BOOLEAN:
                    $this->addBooleanType($builder, $key, $option);
                    break;

                case Option::TYPE_INTEGER:
                    $this->addIntegerType($builder, $key, $option);
                    break;
            }
        }
    }

    private function addStringType(FormBuilderInterface $builder, $key, OptionInterface $option)
    {
        $builder->add(
            $builder->create(strtolower($key), 'text', array(
                'data' => $option->getValue(),
                'label' => 'OPTION_'.$key,
                'required' => false,
            ))
        );
    }

    private function addBooleanType(FormBuilderInterface $builder, $key, OptionInterface $option)
    {
        $builder->add(
            $builder->create(strtolower($key), 'checkbox', array(
                'value' => 1,
                'data' => $option->getValue(),
                'label' => 'OPTION_'.$key,
                'required' => false,
            ))
        );
    }

    private function addIntegerType(FormBuilderInterface $builder, $key, OptionInterface $option)
    {
        $builder->add(
            $builder->create(strtolower($key), 'integer', array(
                'data' => $option->getValue(),
                'label' => 'OPTION_'.$key,
                'required' => false,
            ))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options',
            'csrf_protection' => false,
            'generator' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
