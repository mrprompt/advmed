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
 * Subscription controller
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/subscription/", name="subscription_index")
     * @Method("GET")
     *
     * @param SubscriptionRepository         $repository
     * @param SerializerInterface    $serializer
     */
    public function index(SubscriptionRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $subscriptions = $repository->findAll();

        return $this->json($subscriptions);
    }

    /**
     * @Route("/subscription/", name="subscription_add")
     * @Method("POST")
     *
     * @param SubscriptionRepository        $subscriptionRepository
     * @param SerializerInterface           $serializer
     * @param Request                       $request
     */
    public function add(
        SubscriptionRepository $subscriptionRepository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $period = $request->get('period');
        $title = $request->get('title');
        $description = $request->get('description');
        $uid = (int) $request->get('user');

        try {
            $subscription = $subscriptionRepository->create(
                $uid,
                $title,
                $description,
                $period
            );

            return $this->json($subscription, 201);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/subscription/{id}", name="subscription_update")
     * @Method("PUT")
     *
     * @param SubscriptionRepository    $repository
     * @param SerializerInterface       $serializer
     * @param Request                   $request
     */
    public function update(
        SubscriptionRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');
        $title = (string) $request->get('title');
        $description = (string) $request->get('description');

        try {
            $subscription = $repository->update($id, $title, $description);

            return $this->json($subscription, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException($ex->getMessage());
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/subscription/{id}", name="subscription_delete")
     * @Method("DELETE")
     *
     * @param SubscriptionRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function delete(
        SubscriptionRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        try {
            $subscription = $repository->delete($id);

            return $this->json($subscription, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException($ex->getMessage());
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/subscription/{id}", name="subscription_details")
     * @Method("GET")
     *
     * @param SubscriptionRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function details(
        SubscriptionRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        $subscription = $repository->find($id);

        if (!$subscription) {
            throw $this->createNotFoundException('The subscription does not exist');
        }

        return $this->json($subscription, 200);
    }
}