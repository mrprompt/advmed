<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * User controller
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @Route("/user/", name="user_index")
     * @Method("GET")
     *
     * @param UserRepository         $repository
     * @param SerializerInterface    $serializer
     */
    public function index(
        UserRepository $repository, 
        SerializerInterface $serializer
    ): JsonResponse
    {
        $users = $repository->findAll();

        return $this->json($users);
    }

    /**
     * @Route("/user/", name="user_add")
     * @Method("POST")
     *
     * @param UserRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function add(
        UserRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
            
            $request->request->replace($data);
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $phone = $request->get('phone');
        $street = $request->get('street');
        $number = $request->get('number');
        $neighborhood = $request->get('neighborhood');

        try {
            $user = $repository->create(
                $name,
                $email,
                $password,
                $phone,
                $street,
                $number,
                $neighborhood
            );

            return $this->json($user, 201);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/user/{id}", name="user_update")
     * @Method("PUT")
     *
     * @param UserRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function update(
        UserRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
            
            $request->request->replace($data);
        }

        $id = (int) $request->get('id');
        $name = $request->get('name');
        $phone = $request->get('phone');
        $street = $request->get('street');
        $number = $request->get('number');
        $neighborhood = $request->get('neighborhood');

        try {
            $user = $repository->update(
                $id, 
                $name, 
                $phone, 
                $street, 
                $number, 
                $neighborhood
            );

            return $this->json($user, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException('The user does not exist');
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }

    /**
     * @Route("/user/{id}", name="user_delete")
     * @Method("DELETE")
     *
     * @param UserRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function delete(
        UserRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        try {
            $user = $repository->delete($id);

            return $this->json($user, 204);
        } catch (\OutOfRangeException $ex) {
            throw $this->createNotFoundException('The user does not exist');
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 500);
        }
    }

    /**
     * @Route("/user/{id}", name="user_details")
     * @Method("GET")
     *
     * @param UserRepository        $repository
     * @param SerializerInterface   $serializer
     * @param Request               $request
     */
    public function details(
        UserRepository $repository, 
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse
    {
        $id = (int) $request->get('id');

        $user = $repository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->json($user, 200);
    }
}