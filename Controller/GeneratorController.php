<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Controller;

use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options;
use Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type\OptionType;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\HybridPasswordGenerator;

/**
 * Password Generator controller.
 *
 */
class GeneratorController extends Controller
{

    /**
     * Password generator form.
     *
     * @param Request $request
     * @param string|null $mode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request, $mode = null)
    {
        $mode = $this->getMode($request, $mode);
        $passwordGenerator = $this->getPasswordGenerator($mode);

        $passwords = null;
        $options = $this->createOptionEntity($passwordGenerator, $mode);

        $form = $this->buildForm($passwordGenerator, $options);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $passwordGenerator->setLength($options->getLength());
            $passwordGenerator->setOptions($options->getOptionValue());
            $passwords = $passwordGenerator->generatePasswords($options->getQuantity());
        }

        return $this->render('HackzillaPasswordGeneratorBundle:Generator:form.html.twig', array(
            'form' => $form->createView(),
            'mode' => $mode,
            'passwords' => $passwords,
        ));
    }

    /**
     * Lookup Password Generator Service
     *
     * @param string $mode
     * @return PasswordGeneratorInterface
     */
    private function getPasswordGenerator($mode)
    {
        switch ($mode) {
            case 'dummy':
                $serviceName = 'hackzilla_password_generator_dummy';
                break;

            case 'computer':
                $serviceName = 'hackzilla_password_generator_computer';
                break;

            case 'human':
                $serviceName = 'hackzilla_password_generator_human';
                break;

            case 'hybrid':
                $serviceName = 'hackzilla_password_generator_hybrid';
                break;

            default:
                $serviceName = 'hackzilla_password_generator';
        }

        return $this->container->get($serviceName);
    }

    /**
     * Figure out password generator mode
     *
     * @param Request $request
     * @param string $mode
     *
     * @return string
     */
    private function getMode(Request $request, $mode = null)
    {
        if (is_null($mode)) {
            switch ($request->query->get('mode')) {
                case 'dummy':
                case 'human':
                case 'hybrid':
                case 'computer':
                    return $request->query->get('mode');

                default:
                    return 'computer';
            }
        }

        return $mode;
    }

    /**
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param $mode
     * @return Options
     */
    private function createOptionEntity(PasswordGeneratorInterface $passwordGenerator, $mode)
    {
        $options = new Options($passwordGenerator->getPossibleOptions());
        $options->setMode($mode);

        if ($mode == 'computer') {
            $options->{$passwordGenerator->getOptionKey(ComputerPasswordGenerator::OPTION_LOWER_CASE)} = true;
            $options->{$passwordGenerator->getOptionKey(ComputerPasswordGenerator::OPTION_NUMBERS)} = true;
            $options->setLength($this->container->getParameter('hackzilla_password_generator.computer.length'));
        } else if ($mode == 'human') {
            $options->setLength($this->container->getParameter('hackzilla_password_generator.human.length'));
        } else if ($mode == 'hybrid') {
            $options->{$passwordGenerator->getOptionKey(HybridPasswordGenerator::OPTION_UPPER_CASE)} = true;
            $options->{$passwordGenerator->getOptionKey(HybridPasswordGenerator::OPTION_LOWER_CASE)} = true;
            $options->{$passwordGenerator->getOptionKey(HybridPasswordGenerator::OPTION_NUMBERS)} = true;
            $options->setLength($this->container->getParameter('hackzilla_password_generator.hybrid.segmentCount'));
        }

        return $options;
    }

    /**
     * Build form
     *
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param array $options
     *
     * @return \Symfony\Component\Form\Form
     */
    private function buildForm(PasswordGeneratorInterface $passwordGenerator, $options)
    {
        return $this->createForm(new OptionType($passwordGenerator->getPossibleOptions()), $options, array(
            'action' => $this->generateUrl('hackzilla_password_generator_show'),
            'method' => 'GET',
        ));
    }

}
