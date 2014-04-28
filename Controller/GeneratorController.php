<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hackzilla\PasswordGenerator\Generator\PasswordGenerator;
use Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options;
use Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type\OptionType;

/**
 * Password Generator controller.
 *
 */
class GeneratorController extends Controller
{

    /**
     * Password generator form.
     *
     */
    public function formAction(Request $request)
    {
        $passwordGenerator = $this->container->get('hackzilla_password_generator');

        $passwords = null;
        $options = $this->createOptionType($passwordGenerator);
        $form = $this->buildForm($passwordGenerator, $options);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $passwordGenerator->setLength($options->getLength());
            $passwordGenerator->setOptions($options->getOptionValue());
            $passwords = $passwordGenerator->generatePasswords($options->getQuantity());
        }

        return $this->render('HackzillaPasswordGeneratorBundle:Generator:form.html.twig', array(
                    'form' => $form->createView(),
                    'passwords' => $passwords,
        ));
    }

    private function createOptionType(\Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface $passwordGenerator)
    {
        $options = new Options($passwordGenerator->getPossibleOptions());

        $options->{$passwordGenerator->getOptionKey(PasswordGenerator::OPTION_LOWER_CASE)} = true;
        $options->{$passwordGenerator->getOptionKey(PasswordGenerator::OPTION_NUMBERS)} = true;

        return $options;
    }

    private function buildForm(\Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface $passwordGenerator, $options)
    {
        return $this->createForm(new OptionType($passwordGenerator->getPossibleOptions()), $options, array(
                    'action' => $this->generateUrl('hackzilla_password_generator_show'),
                    'method' => 'GET',
        ));
    }

}
