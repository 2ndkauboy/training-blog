<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/{slug}", name="post")
     */
    public function showAction(Post $post)
    {
        return $this->render('blog/show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/comment/{slug}/new", name="comment_new", methods={"POST"})
     */
    public function commentNewAction(Request $request, EntityManagerInterface $em, Post $post)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setPost($post);

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('blog_post', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('blog/comment_form_error.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }

    public function commentFormAction(Post $post)
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('blog/_comment_form.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }
}
