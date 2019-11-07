<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteBaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 *
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        if (($quote = $this->getQuote($request)) === null) {
            $quote = new Quote();
        }

        $form = $this->generateForm($quote);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quote = $form->getData();

            $this->getDoctrine()->getManager()->persist($quote);
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->set('quote', $quote->getId());

            return $this->redirectToRoute('switch_step_1');
        }

        return $this->render(
            'home/index.html.twig',
            [
                'quote_form' => $form,
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

    private function generateForm(Quote $quote)
    {
        $form = $this->createForm(QuoteBaseType::class, $quote);

        return $form;
    }
}
