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
     */
    public function indexAction(Post $page): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findLatest($page);

        return $this->render('index.html.twig');
    }
}
