<?php

namespace App\Controller;

use App\Entity\API\Supplier;
use App\Entity\PersonalInformation;
use App\Entity\Quote;
use App\Form\QuoteStepFourType;
use App\Service\SwitchException;
use App\Service\SwitchManager;
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
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/4", name="switch_step_4")
     */
    public function switchStepFour(Request $request)
    {
        if (($quote = $this->getQuote($request)) === null) {
            return $this->redirectToHome();
        }

        if (($personalInformation = $quote->getPersonalInformation()) === null) {
            $personalInformation = new PersonalInformation();
        }

        $form = $this->createForm(QuoteStepFourType::class, $personalInformation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personalInformation = $form->getData();
            $quote->setPersonalInformation($personalInformation);

            $this->getDoctrine()->getManager()->persist($personalInformation);
            $this->getDoctrine()->getManager()->persist($quote);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('switch_step_5');
        }

        return $this->render(
            'switch/step_4.html.twig',
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
     * @param array|null $errors
     * @return RedirectResponse
     */
    private function redirectToHome(?array $errors = null): RedirectResponse
    {
        return $this->redirectToRoute('home', ['errors' => $errors]);
    }

    /**
     * @param int $step
     * @param Request $request
     * @param SwitchManager $switchManager
     * @return RedirectResponse|Response
     *
     * @Route("/{step}", name="switch_step")
     */
    public function switchStep(int $step, Request $request, SwitchManager $switchManager)
    {
        $numberFormatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $stepFormType = 'App\Form\QuoteStep'.ucfirst($numberFormatter->format($step)).'Type';

        return $this->nextStep($request, $step, $step + 1, $stepFormType, $switchManager);
    }

    /**
     * @param Request $request
     * @param int $currentStep
     * @param int $nextStep
     * @param string $formClass
     * @param SwitchManager $switchManager
     * @return RedirectResponse|Response
     */
    private function nextStep(Request $request, int $currentStep, int $nextStep, string $formClass, SwitchManager $switchManager)
    {
        if (($quote = $this->getQuote($request)) === null) {
            return $this->redirectToHome();
        }

        $switchManager->setQuote($quote);

        $suppliers = null;
        $options = [];
        if ($currentStep === 1) {
            $suppliers = [];
            $plans = [];
            /** @var Supplier $supplier */
            try {
                foreach ($switchManager->getSuppliers() as $supplier) {
                    $suppliers[$supplier->getName()] = $supplier->getId();
                    foreach ($supplier->getPlans() as $plan) {
                        $plans[$plan->getName()] = $plan->getId();
                    }
                }
            } catch (SwitchException $e) {
                return $this->redirectToHome($e->getErrors());
            }
            ksort($suppliers);
            $options['suppliers'] = $suppliers;
            $options['plans'] = $plans;
        } elseif ($currentStep === 2) {
            $options['payment_methods'] = $switchManager->getPaymentMethods();
        } elseif ($currentStep === 3) {
            $suppliers = $switchManager->getFutureSupplies();
            $options['suppliers'] = $suppliers;
        }

        $form = $this->createForm($formClass, $quote, $options);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Quote $quote */
            $quote = $form->getData();

            if ($currentStep === 2) {
                if ($request->request->get('quote_step_two')['selectedGasSpend'] == '1') {
                    $quote->setSelectedGasSpend(true);
                    $quote->setGasUseKWH(null);
                } else {
                    $quote->setSelectedGasSpend(false);
                    $quote->setGasMoneyPerType(null);
                    $quote->setGasMoneySpend(null);
                }
                if ($request->request->get('quote_step_two')['selectedElecSpend'] == '1') {
                    $quote->setSelectedElecSpend(true);
                    $quote->setElecUseKWH(null);
                } else {
                    $quote->setSelectedElecSpend(false);
                    $quote->setElecMoneyPerType(null);
                    $quote->setElecMoneySpend(null);
                }
            }

            if ($request->request->get('quote_step_one') !== null && $request->request->get(
                    'quote_step_one'
                )['sameSupplier'] == '0') {
                $quote->setSameSupplier(false);
            }

            $this->getDoctrine()->getManager()->persist($quote);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('switch_step', ['step' => $nextStep]);
        }


        return $this->render(
            'switch/step_'.$currentStep.'.html.twig',
            [
                'form' => $form->createView(),
                'suppliers' => $suppliers,
                'payment_methods' => ($currentStep === 3 ? $switchManager->getPaymentMethods(
                    true
                ) : null),
            ]
        );
    }
}
