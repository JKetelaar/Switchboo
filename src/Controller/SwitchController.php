<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteStepOneType;
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
     * @Route("/{step}", name="switch_step")
     */
    public function switchStep(Request $request)
    {
        return $this->nextStep($request, 1, 2, QuoteStepOneType::class);
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

        $form = $this->createForm(QuoteStepOneType::class, $quote);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quote = $form->getData();

            $this->getDoctrine()->getManager()->persist($quote);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('switch_step_'.$nextStep);
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
