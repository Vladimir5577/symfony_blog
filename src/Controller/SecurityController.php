<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register_page", name="register_page")
     */
    public function register_page(): Response
    {
        return $this->render('security/register.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, ValidatorInterface $validator, UserRepository $userRepository, UserPasswordEncoderInterface $encoder): Response
    {

        $name = $request->request->get('name');
        $phone = $request->request->get('phone');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!is_null($user)) {
            return $this->json([
                'message' => 'User already exist'
            ], Response::HTTP_CONFLICT);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName($name);
        $user->setPhone($phone);
        $user->setEmail($email);

        // encode password
        $encodePassword = $encoder->encodePassword($user, $password);
        $user->setPassword($encodePassword);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }
 
        $entityManager->persist($user);
        $entityManager->flush();

//        dd($user);

        return $this->render('security/register.html.twig', ['error' => null, 'last_username' => null]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
