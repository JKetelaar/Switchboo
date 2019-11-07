<?php

namespace App\Controller;

use App\Entity\Quote;
use NumberFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SwitchController
 * @package App\Controller
 *
 * @Route("/switch/step")
 */
class SwitchController extends AbstractController
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/5", name="switch_step_5")
     */
    public function switchStepFive(Request $request)
    {
        return $this->render(
            'switch/step_5.html.twig'
        );
    }

    /**
     * @param int $step
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/{step}", name="switch_step")
     */
    public function switchStep(int $step, Request $request)
    {
        $numberFormatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $stepFormType = 'App\Form\QuoteStep'.ucfirst($numberFormatter->format($step)).'Type';

        return $this->nextStep($request, $step, $step + 1, $stepFormType);
    }

    /**
     * @param Request $request
     * @param int $currentStep
     * @param int $nextStep
     * @param string $formClass
     * @return RedirectResponse|Response
     */
    private function nextStep(Request $request, int $currentStep, int $nextStep, string $formClass)
    {
        if (($quote = $this->getQuote($request)) === null) {
            return $this->redirectToHome();
        }

        $form = $this->createForm($formClass, $quote);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quote = $form->getData();

            $this->getDoctrine()->getManager()->persist($quote);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('switch_step', ['step' => $nextStep]);
        }

        return $this->render(
            'switch/step_'.$currentStep.'.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @return Quote|null
     */
    private function getQuote(Request $request): ?Quote
    {
        $id = $request->getSession()->get('quote');

        if ($id === null) {
            return null;
        }

        return $this->getDoctrine()->getRepository(Quote::class)->find($id);
    }

    /**
     * @return RedirectResponse
     */
    private function redirectToHome(): RedirectResponse
    {
        return $this->redirectToRoute('home');
    }
}
