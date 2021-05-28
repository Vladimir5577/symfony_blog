<?php

namespace App\Controller;

use App\UseCases\User\Edit\Command;
use App\UseCases\User\Edit\Form;
use App\UseCases\User\Edit\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Entity\Post;
use App\Service\FileUploader;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('blog/profile.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/user_profile/{id}", name="user_profile")
     */
    public function user_profile(int $id): Response
    {
        $auth_user_id = $this->getUser()->getId();

        if ($auth_user_id == $id) {
            $user = $this->getUser();
        } else {
            $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        }

        return $this->render('blog/profile.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/edit_profile", name="edit_profile")
     */
    public function edit_rofile(Request $request, Handler $handler): Response
    {
        /*
        $options = [];
        $command = Command::createFromArray($options);
        $handler->handle($command);
        $command = Command::createFromUser($this->getUser());
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $handler->handle($command);
            } catch (\DomainException $exception){

            }
        }
        */
        return $this->render('blog/edit_profile.html.twig', ['user' => $this->getUser(),
//            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update_profile", name="update_profile", methods={"GET","POST"})
     */
    public function update_profile(Request $request, ValidatorInterface $validator, string $uploadDir,  FileUploader $uploader): Response
    {
//    	 dd($request->get('name'));
    	$image = $request->files->get('image');
        $name = $request->request->get('name');
        $phone = $request->request->get('phone');
        $email = $request->request->get('email');
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $user->setName($name);
        $user->setPhone($phone);
        $user->setEmail($email);

        // validation
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        if ($image) {
            $file_name = $image->getClientOriginalName();
            $user->setPhoto($file_name);
	        $uploader->upload($uploadDir, $image, $file_name);
    	}
    	
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('blog/profile.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/add_post", name="add_post")
     */
    public function add_post()
    {
        return $this->render('blog/add_post.html.twig');
    }

    /**
     * @Route("/save_post", name="save_post")
     */
    public function save_post(Request $request, ValidatorInterface $validator, string $uploadDir,  FileUploader $uploader): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $image = $request->files->get('image');

//        dd($title, $description, $image);
        $user = $this->getUser();

        $post = new Post();
        $post->setUserId($user);
        $post->setTitle($title);
        $post->setDescription($description);

        if ($image) {
            $file_name = $image->getClientOriginalName();
            $post->setImage($file_name);
            $uploader->upload($uploadDir, $image, $file_name);
        }

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirect('/');
    }
}
