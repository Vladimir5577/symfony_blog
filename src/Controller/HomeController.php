<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_1222")
     */
    public function index_example(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, PaginatorInterface $paginator, PostRepository $postRepository, UserRepository $userRepository): Response
    {
        $active_users = $userRepository->getActiveUsers();

        /** @var Post $posts */
        $posts = $postRepository->getPosts($active_users);

//        $posts = $this->getDoctrine()
//            ->getRepository(Post::class)
//            ->findBy(['is_active' => true], ['id' => 'DESC']);

        $pagination = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            2
        );

//        dd($posts->getUserId()->getName());

        return $this->render('home/home.html.twig', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/wiev_blog/{id}", name="wiev_blog")
     */
    public function wiev_blog(int $id): Response
    {
        /** @var Post $post */
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        $comments = $post->getComments();
        $arrCollection = new ArrayCollection($comments->toArray());
//        dd($arrCollection);
//        dd($arrCollection->matching(
//            Criteria::create()->where(
//                Criteria::expr()->eq(
//                    'comment','Another Comment'
//                )
//            )
//        ));

//        dd(get_class($comments));
//        dd($comments);

        return $this->render('blog/wiev_blog.html.twig', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * @Route("/send_email")
     */
    public function send_email(\Swift_Mailer $mailer)
    {
        // dd(354);
       $message = (new \Swift_Message('Hello Email'))
            ->setFrom('vladimir160933@gmail.com')
            ->setTo('cosplayphoto3@gmail.com')
            ->setBody(
                'Hello Symfony',
                'text/html'
            )
        ;

        $mailer->send($message);

        return new Response;
    }
}
