<?php

namespace App\Controller;

use App\Repository\RatingRepository;
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

        $array_rating = $user->getGivenRatings()->toArray();

        $amount_rating = count($array_rating);
        $rating_sum = 0;
        array_map(function ($value) use (&$rating_sum, $array_rating) {
            $rating_sum += $value->getRate();
//            dump($value->getRate());
        }, $array_rating);

        if ($array_rating) {
            $rating = $rating_sum / $amount_rating;
        } else {
            $rating = 0;
        }

        // dd($rating_sum, $amount_rating, $rating, 'Finish');


        return $this->render('blog/profile.html.twig', ['user' => $user, 'rating' => $rating, 'amount_rating' => $amount_rating]);
    }

    /**
     * @Route("/user_profile/{id}", name="user_profile")
     */
    public function user_profile(int $id, RatingRepository $ragingRepository): Response
    {
        $auth_user_id = $this->getUser() ? $this->getUser()->getId() : null;

        if ($auth_user_id == $id) {
            $user = $this->getUser();
        } else {
            /** @var $user User */
            $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        }

//        $summrate = $ragingRepository->getUserRatings();
//        dd($summrate);
//
        $array_rating = $user->getGivenRatings()->toArray();
//        dd($array_rating);

        if ($auth_user_id) {
            $userGaveARate = $ragingRepository->checkIfUserGaveRating($id, $auth_user_id);
        } else {
            $userGaveARate = false;
        }
//        dd($userGaveARate);

        $amount_rating = count($array_rating);
        $rating_sum = 0;
        array_map(function ($value) use (&$rating_sum, $array_rating) {
            $rating_sum += $value->getRate();
//            dump($value->getRate());
        }, $array_rating);

        if ($amount_rating) {
            $rating = $rating_sum / $amount_rating;
        } else {
            $rating = null;
        }

//        dd($rating_sum, $amount_rating, $rating, 'Finish');

        return $this->render('blog/profile.html.twig', ['user' => $user, 'rating' => $rating, 'amount_rating' => $amount_rating, 'userGaveARate' => $userGaveARate]);
    }

    /**
     * @Route("/edit_profile", name="edit_profile")
     */
    public function edit_profile(Request $request, Handler $handler): Response
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

        $errors = $validator->validate($post);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirect('/');
    }
}
