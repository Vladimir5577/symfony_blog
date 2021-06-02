<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

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
    public function home(): Response
    {
        /** @var Post $posts */
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy([], ['id' => 'DESC']);

//        dd($posts->getUserId()->getName());

        return $this->render('home/home.html.twig', ['posts' => $posts]);
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
}
