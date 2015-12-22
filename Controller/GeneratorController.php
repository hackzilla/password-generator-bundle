<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Controller;

use Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options;
use Hackzilla\Bundle\PasswordGeneratorBundle\Exception\UnknownGeneratorException;
use Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type\OptionType;
use Hackzilla\PasswordGenerator\Exception\CharactersNotFoundException;
use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Password Generator controller.
 */
class GeneratorController extends Controller
{
    /**
     * Password generator form.
     *
     * @param Request     $request
     * @param string|null $mode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request, $mode = null)
    {
        $mode = $this->getMode($request, $mode);
        $passwordGenerator = $this->getPasswordGenerator($mode);

        $passwords = $error = null;
        $options = new Options($passwordGenerator);

        $form = $this->buildForm($passwordGenerator, $options, $mode);

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $passwords = $passwordGenerator->generatePasswords($options->getQuantity());
            } catch (CharactersNotFoundException $e) {
                $error = 'CharactersNotFoundException';
            }
        }

        return $this->render('HackzillaPasswordGeneratorBundle:Generator:form.html.twig', array(
            'form' => $form->createView(),
            'mode' => $mode,
            'passwords' => $passwords,
            'error' => $error,
        ));
    }

    /**
     * Lookup Password Generator Service.
     *
     * @param string $mode
     *
     * @return PasswordGeneratorInterface
     *
     * @throws UnknownGeneratorException
     */
    private function getPasswordGenerator($mode)
    {
        switch ($mode) {
            case 'dummy':
            case 'computer':
            case 'human':
            case 'hybrid':
                $serviceName = 'hackzilla.password_generator.'.$mode;
                break;

            default:
                throw new UnknownGeneratorException();
        }

        return $this->container->get($serviceName);
    }

    /**
     * Figure out password generator mode.
     *
     * @param Request $request
     * @param string  $mode
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
     * Build form.
     *
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param Options                    $options
     * @param string                     $mode
     *
     * @return \Symfony\Component\Form\Form
     */
    private function buildForm(PasswordGeneratorInterface $passwordGenerator, Options $options, $mode = '')
    {
        return $this->createForm(new OptionType($passwordGenerator), $options, array(
            'action' => $this->generateUrl('hackzilla_password_generator_show', array('mode' => $mode)),
            'method' => 'GET',
        ));
    }
}
