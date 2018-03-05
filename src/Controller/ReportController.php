<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Report controller
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class ReportController extends Controller
{
    /**
     * @Route("/report/", name="report_index")
     * @Method("GET")
     *
     * @param SubscriptionRepository    $repository
     * @param SerializerInterface       $serializer
     */
    public function index(
        SubscriptionRepository $repository, 
        SerializerInterface $serializer
    ): JsonResponse
    {
        $reports = $repository->reportAll();

        return $this->json($reports);
    }

    /**
     * @Route("/report/{id}", name="report_details")
     * @Method("GET")
     *
     * @param SubscriptionRepository    $repository
     * @param SerializerInterface       $serializer
     * @param Request                   $request
     */
    public function details(
        SubscriptionRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        try {
            $id = (int) $request->get('id');
            $report = $repository->reportByUser($id);

            return $this->json($report, 200);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException('The report does not exist');
        }
    }
}