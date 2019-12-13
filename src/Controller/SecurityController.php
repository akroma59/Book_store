<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1. Check if user is already loged in
        // --
        if ($this->getUser()) 
        {
            return $this->redirectToRoute('homepage');
        }
        // 2. Init Entities
        // --
        $user = new User();
        // 3. Form management
        // --
        
        // Create new form based on the User Entity
        $form = $this->createForm(RegisterType::class, $user);
        
        // Handle the Request (request method === post)
        $form->handleRequest($request);
        
        // On form submit
        if ($form->isSubmitted() && $form->isValid())
        {
            // PlainText Password
            $plainPassword = $form->get('password')->getData();
            // Encode the plain password
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $plainPassword
            );
            // Generate the Activation Token
            $activationToken = md5($user->getEmail().uniqid());
            // 3. Set and Persist data
            // --
            
            $user->setPassword($encodedPassword);
            $user->setActivateToken($activationToken);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Your account is now created, check your mailbox to active.');
            return $this->redirectToRoute('login');
        }
        // Create the form view
        $form = $form->createView();
        return $this->render('security/register.html.twig', [
            'form' => $form
        ]);
    }
    
    /**
     * @Route("/account", name="account")
     */
    public function account()
    {
        return $this->render('security/account.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // 1. Check if user is already loged in
        // --
        // if ($this->getUser()) 
        // {
        //     return $this->redirectToRoute('homepage');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}