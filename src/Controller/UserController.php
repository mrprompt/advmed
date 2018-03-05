<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\AddressEntity;
use App\Entity\PhoneEntity;
use App\Entity\UserEntity;
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
    public function index(UserRepository $repository, SerializerInterface $serializer): JsonResponse
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
        $user = new UserEntity;
        $user->setName($request->get('name'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));

        $phone = new PhoneEntity;
        $phone->setNumber($request->get('phone'));

        $address = new AddressEntity;
        $address->setStreet($request->get('street'));
        $address->setNumber($request->get('number'));
        $address->setNeighborhood($request->get('neighborhood'));

        $user->addAddress($address);
        $user->addPhone($phone);

        try {
            $repository->create($user);

            return $this->json($user, 201);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }
    }
}