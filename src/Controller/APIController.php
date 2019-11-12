<?php

namespace App\Controller;

use App\Entity\API\Supplier;
use App\Entity\Quote;
use App\Service\SwitchManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class APIController
 * @package App\Controller
 *
 * @Route("/api")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/plans/{supplierID}", name="api_plans")
     * @param Request $request
     * @param SwitchManager $switchManager
     * @param int $supplierID
     * @return JsonResponse
     */
    public function plans(Request $request, SwitchManager $switchManager, int $supplierID)
    {
        $quote = $this->getQuote($request);
        $postcode = $quote->getPostcode();
        $plans = [];
        /** @var Supplier[] $suppliers */
        $suppliers = $switchManager->getSuppliers($postcode);
        foreach ($suppliers as $supplier) {
            if ($supplier->getId() === $supplierID) {
                $plans = $supplier->getPlans();
                break;
            }
        }

        return new JsonResponse($plans);
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
}
