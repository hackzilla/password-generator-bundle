<?php

declare(strict_types=1);

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Controller;

use Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options;
use Hackzilla\Bundle\PasswordGeneratorBundle\Exception\UnknownGeneratorException;
use Hackzilla\Bundle\PasswordGeneratorBundle\Form\Type\OptionType;
use Hackzilla\PasswordGenerator\Exception\CharactersNotFoundException;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\DummyPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\HumanPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\HybridPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Password Generator controller.
 */
class GeneratorController extends AbstractController
{
    private HumanPasswordGenerator $humanPasswordGenerator;

    private HybridPasswordGenerator $hybridPasswordGenerator;

    private ComputerPasswordGenerator $computerPasswordGenerator;

    private RequirementPasswordGenerator $requirementPasswordGenerator;

    private DummyPasswordGenerator $dummyPasswordGenerator;

    private FormFactory $formFactory;

    private Environment $twigEnvironment;

    /**
     * GeneratorController constructor.
     */
    public function __construct(
        HumanPasswordGenerator $humanPasswordGenerator,
        HybridPasswordGenerator $hybridPasswordGenerator,
        ComputerPasswordGenerator $computerPasswordGenerator,
        RequirementPasswordGenerator $requirementPasswordGenerator,
        DummyPasswordGenerator $dummyPasswordGenerator,
        FormFactory $formFactory,
        Environment $twigEnvironment,
    )
    {
        $this->humanPasswordGenerator = $humanPasswordGenerator;
        $this->hybridPasswordGenerator = $hybridPasswordGenerator;
        $this->computerPasswordGenerator = $computerPasswordGenerator;
        $this->requirementPasswordGenerator = $requirementPasswordGenerator;
        $this->dummyPasswordGenerator = $dummyPasswordGenerator;
        $this->formFactory = $formFactory;
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * Password generator form.
     *
     * @param Request     $request
     * @param string|null $mode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request, ?string $mode = null): Response
    {
        $mode = $this->getMode($request, $mode);
        $passwordGenerator = $this->getPasswordGenerator($mode);

        $passwords = $error = null;
        $options = new Options($passwordGenerator);

        $form = $this->buildForm($passwordGenerator, $options, $mode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $passwords = $passwordGenerator->generatePasswords($options->getQuantity());
            } catch (CharactersNotFoundException $e) {
                $error = 'CharactersNotFoundException';
            }
        }

        $content = $this->twigEnvironment->render(
            '@HackzillaPasswordGenerator/Generator/form.html.twig', [
                'form'      => $form->createView(),
                'mode'      => $mode,
                'passwords' => $passwords,
                'error'     => $error,
            ]
        );

        return new Response($content);
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
    private function getPasswordGenerator($mode): PasswordGeneratorInterface
    {
        switch ($mode) {
            case 'dummy':
                return $this->dummyPasswordGenerator;

            case 'computer':
                return $this->computerPasswordGenerator;

            case 'human':
                return $this->humanPasswordGenerator;

            case 'hybrid':
                return $this->hybridPasswordGenerator;
        }

        throw new UnknownGeneratorException();
    }

    /**
     * Figure out password generator mode.
     *
     * @param Request $request
     * @param string  $mode
     *
     * @return string
     */
    private function getMode(Request $request, $mode = null): string
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
    private function buildForm(PasswordGeneratorInterface $passwordGenerator, Options $options, $mode = ''): FormInterface
    {
        return $this->formFactory->create(OptionType::class, $options, [
            'action'    => $this->generateUrl(
                'hackzilla_password_generator_show',
                [
                    'mode' => $mode,
                ]
            ),
            'method'    => 'GET',
            'generator' => $passwordGenerator,
        ]);
    }
}
