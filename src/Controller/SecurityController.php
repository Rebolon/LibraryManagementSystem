<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\UserInfo;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     * @param int $loginTokenTtl
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(int $loginTokenTtl, UserPasswordEncoderInterface  $encoder)
    {
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $token = bin2hex(random_bytes(20));
        $ttl = new \DateTime();
        $ttl->add(new \DateInterval('PT'.$loginTokenTtl.'S'));
        $user->setApiToken($encoder->encodePassword($user, $token))
            ->setApiTokenTtl($ttl);

        $this->getDoctrine()
            ->getManager()
            ->persist($user);
        $this->getDoctrine()
            ->getManager()
            ->flush();

        return $this->json([
            'token' => $token,
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}
