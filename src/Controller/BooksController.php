<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BooksType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



/**
 * @Route("/book", name="books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(): Response
    {

        $books = $this->getDoctrine()
            ->getRepository(Books::class)
            ->findAll()
            ;

        return $this->render('books/index.html.twig', [
           'books' => $books,
        ]);
        
    }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {

        // Create a new Book
        $book = new Books;

        // Define $errors array
        $errors = [];

        // Create the new form
        $form = $this->createForm(BooksType::class, $book);

        // Handle the request...(request method === post)
        $form->handleRequest($request);

        // On form submit
        if ($form->isSubmitted())
        {
            // Handle form errors
            // ....

            // If the form is valid
            if ($form->isValid())
            {
                // Save in database
                $em = $this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush($book);
                
                // Redirect the user
                return $this->redirectToRoute('books:read',[
                    'id' => $book->getId(),
                ]);
            }
        }

        // Create the form view
        $form = $form->createView();

        return $this->render('books/create.html.twig', [
            'form' => $form,
            'errors' => $errors,
        ]);
    }

    /**
     *  @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read($id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Books::class)
            ->find($id)
            ;

        return $this->render('books/read.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     *  @Route("/{id}/update", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(Request $request, Books $book): Response
    {
        $errors = [];

        $form = $this->createForm(BooksType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('books:read', [
                    'id' => $book->getId(),
                ]);
            }
        }

        return $this->render('books/update.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }
    
    /**
     *  @Security("has_role('ROLE_ADMIN')")
     *  @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     * 
     */
    public function delete(Request $request, Books $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();

            return $this->redirectToRoute('books:index');
        }

        return $this->render('books/delete.html.twig',[
            'book'=> $book,
        ]);
    }
}
