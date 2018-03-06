<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Repository\AdvertisementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Advertisement controller
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AdvertisementController extends Controller
{
    /**
     * @Route("/advertisement/", name="advertisement_index")
     * @Method("GET")
     *
     * @param AdvertisementRepository         $repository
     * @param SerializerInterface    $serializer
     */
    public function index(AdvertisementRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $advertisements = $repository->findAll();

        return $this->json($advertisements);
    }

    /**
     * @Route("/advertisement/", name="advertisement_add")
     * @Method("POST")
     *
     * @param AdvertisementRepository        $advertisementRepository
     * @param SerializerInterface           $serializer
     * @param Request                       $request
     */
    public function add(
        AdvertisementRepository $advertisementRepository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
            
            $request->request->replace($data);
        }

        $period = $request->get('period');
        $title = $request->get('title');
        $description = $request->get('description');
        $uid = (int) $request->get('user');

        try {
            $advertisement = $advertisementRepository->create(
                $uid,
                $title,
                $description,
                $period
            );

            return $this->json($advertisement, 201);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/advertisement/{id}", name="advertisement_update")
     * @Method("PUT")
     *
     * @param AdvertisementRepository    $repository
     * @param SerializerInterface       $serializer
     * @param Request                   $request
     */
    public function update(
        AdvertisementRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
            
            $request->request->replace($data);
        }
        
        $id = (int) $request->get('id');
        $title = (string) $request->get('title');
        $description = (string) $request->get('description');

        try {
            $advertisement = $repository->update($id, $title, $description);

            return $this->json($advertisement, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException($ex->getMessage());
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/advertisement/{id}", name="advertisement_delete")
     * @Method("DELETE")
     *
     * @param AdvertisementRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function delete(
        AdvertisementRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        try {
            $advertisement = $repository->delete($id);

            return $this->json($advertisement, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException($ex->getMessage());
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/advertisement/{id}", name="advertisement_details")
     * @Method("GET")
     *
     * @param AdvertisementRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function details(
        AdvertisementRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        $advertisement = $repository->find($id);

        if (!$advertisement) {
            throw $this->createNotFoundException('The advertisement does not exist');
        }

        return $this->json($advertisement, 200);
    }
}