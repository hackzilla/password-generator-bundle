<?php

declare(strict_types=1);

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type;

use Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options;
use Hackzilla\PasswordGenerator\Generator\HumanPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Hackzilla\PasswordGenerator\Model\Option\Option;
use Hackzilla\PasswordGenerator\Model\Option\OptionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => 'OPTION_HOW_MANY_PASSWORDS',
                ],
            );

        $generator = $options['generator'];

        if (!is_a($generator, PasswordGeneratorInterface::class)) {
            return;
        }

        foreach ($generator->getOptions() as $key => $option) {
            if (
                $generator instanceof HumanPasswordGenerator
                && HumanPasswordGenerator::OPTION_LENGTH === $key
            ) {
                continue;
            }

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

    /**
     * @param FormBuilderInterface $builder
     * @param                      $key
     * @param OptionInterface      $option
     */
    private function addStringType(FormBuilderInterface $builder, $key, OptionInterface $option): void
    {
        $builder->add(
            $builder->create(
                strtolower($key),
                TextType::class,
                [
                    'data' => $option->getValue(),
                    'label' => 'OPTION_'.$key,
                    'required' => false,
                ],
            ),
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param                      $key
     * @param OptionInterface      $option
     */
    private function addBooleanType(FormBuilderInterface $builder, $key, OptionInterface $option): void
    {
        $builder->add(
            $builder->create(
                strtolower($key),
                CheckboxType::class,
                [
                    'value' => 1,
                    'data' => $option->getValue(),
                    'label' => 'OPTION_'.$key,
                    'required' => false,
                ],
            ),
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param                      $key
     * @param OptionInterface      $option
     */
    private function addIntegerType(FormBuilderInterface $builder, $key, OptionInterface $option): void
    {
        $builder->add(
            $builder->create(
                strtolower($key),
                IntegerType::class,
                [
                    'data' => $option->getValue(),
                    'label' => 'OPTION_'.$key,
                    'required' => false,
                ],
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Options::class,
                'csrf_protection' => false,
                'generator' => null,
            ],
        );
    }

    public function getName(): string
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
