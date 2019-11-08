<?php

namespace App\Controller\Admin;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/quote")
 */
class QuoteController extends AbstractController
{
    /**
     * @Route("/", name="quote_index", methods={"GET"})
     */
    public function index(QuoteRepository $quoteRepository): Response
    {
        return $this->render(
            'quote/index.html.twig',
            [
                'quotes' => $quoteRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="quote_show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        return $this->render(
            'quote/show.html.twig',
            [
                'quote' => $quote,
            ]
        );
    }
}
