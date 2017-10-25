<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="blog_")
 */
class BlogController extends Controller
{
    /**
     * @Route("", name="index")
     * @Route("/{page}", name="index_paged", requirements={"page":"\d+"})
     */
    public function indexAction($page = 1): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findLatest($page);

        return $this->render('index.html.twig', ['posts' => $posts]);
    }

    /**
     * @param Post $post
     *
     * @Route("{slug}", name="post")
     *
     * @return Response
     */
    public function showAction(Post $post): Response
    {
        return $this->render('blog/show.html.twig', ['post' => $post]);
    }
}
