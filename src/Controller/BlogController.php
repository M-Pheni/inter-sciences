<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\PostType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(BlogPostRepository $postRepos): Response
    {
        $post = $postRepos->findBy([], ['createdAt' => 'desc']);
        return $this->render('blog/index.html.twig', compact('post'));
    }

    #[Route("/article/{id<[0-9]+>}", name: "app_post_show", methods: ["GET"])]
    public function show(BlogPost $post): Response
    {
        return $this->render('blog/show.html.twig', compact('post'));
    }

    #[Route('/article/creation', name: 'app_post_create', methods: ["GET", "POST"])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $post = new BlogPost;

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $pin->setUser($this->getUser());
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Article crée avec success');

            return $this->redirectToRoute('app_blog');
        }

        return $this->render('blog/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/{id<[0-9]+>}/modifier', name: 'app_post_edit', methods: ["GET", "POST"])]
    public function edit(Request $request, BlogPost $post, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $pin->setUser($this->getUser());
            // dd($post);
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Article mis-à-jours avec success');

            return $this->redirectToRoute('app_blog');
        }

        return $this->render('blog/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/{id<[0-9]+>}/supprimer', name: 'app_post_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, BlogPost $post, EntityManagerInterface $em): Response
    {
        // $this->denyAccessUnlessGranted('PIN_MANAGE', $post);

        if ($this->isCsrfTokenValid('post_deletion_' . $post->getId(), $request->request->get('csrf_token'))) {
            $em->remove($post);
            $em->flush();

            $this->addFlash('info', 'Articles supprimer avec succes !');
        }

        return $this->redirectToRoute('app_blog');
    }
}
