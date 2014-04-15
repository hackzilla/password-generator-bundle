<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hackzilla\Bundle\TicketBundle\Form\GeneratorType;

/**
 * Password Generator controller.
 *
 */
class PasswordGeneratorController extends Controller
{

    /**
     * Lists all Ticket entities.
     *
     */
    public function formAction(Request $request)
    {
        $passwords = null;
        $options = new \Hackzilla\Bundle\PasswordGeneratorBundle\Entity\Options();

        $form = $this->createForm(new \Hackzilla\Bundle\PasswordGeneratorBundle\Entity\OptionType, $options, array(
            'action' => $this->generateUrl('hackzilla_password_generator_show'),
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $passwords = array('123456');
        }

        return $this->render('HackzillaPasswordGeneratorBundle:Generator:form.html.twig', array(
                    'form' => $form->createView(),
                    'passwords' => $passwords,
        ));
    }

    public function generateAction()
    {
        
    }

}
