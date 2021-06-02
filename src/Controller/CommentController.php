<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentController extends AbstractController
{
    /**
     * @Route("/add_comment", name="add_comment")
     */
    public function add_comment(Request $request,  ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $post_id = $request->request->get('post_id');
        $post_comment = $request->request->get('comment');

//        dd($auth_user_id, $post_id, $comment);

        $comment = new Comment();

        $comment->setUserId($this->getUser());
        $comment->setComment($post_comment);

        // validation
        $errors = $validator->validate($comment);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($post_id);

        $post->addComment($comment);

        $entityManager->persist($comment);
        $entityManager->flush();

        // dd('Post added successfylly');

        return $this->redirect('/wiev_blog/' . $post_id);
    }
}
