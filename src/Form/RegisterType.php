<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* Prénom */
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Saisir votre Prénom."
                    ])
                ],
            ])
            /* Nom */
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Saisir votre Nom."
                    ])
                ],
            ])
            /* Date de naissance */
            ->add('birthday', BirthdayType::class, [
                'label' => "Date de naissance",
                'required' => true,
                'years' => $this->getYears(),
                'constraints' => [
                    new Date([
                        'message' => "La date n'est pas valide..."
                    ])
                ],
            ])
            /* Adresse email */
            ->add('email', EmailType::class, [
                'label' => "Adresse Email",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Saisir une adresse email.",
                    ]),
                    new Email([
                        'message' => "L'adresse email n'est pas valide.",
                    ]),
                ],
            ])
            /* Mot de passe */
            ->add('password', RepeatedType::class, [
                'label' => false,
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => "Nouveau mot de passe",
                    'required' => true,
                    'constraints' => [
                        new Length([
                            'min' => 1,
                            'minMessage' => "Saisir votre nouveau mot de passe",
                        ]),
                        new NotNull([
                            'message' => "Saisir votre nouveau mot de passe",
                        ]),
                        new NotBlank([
                            'message' => "Saisir votre nouveau mot de passe",
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => "Repéter le mot de passe",
                    'constraints' => [
                        new NotBlank([
                            'message' => "Repéter le mot de passe",
                        ]),
                    ],
                ],
                'invalid_message' => "Les mots de passe doivent etre identiques.",
            ])
            /* Accepte les conditions d'utilisation */
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'CGU',
                'mapped' => false, // Permet de préciser que ce champ n'est pas dans l'entité
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepter les conditions d'utilisation.",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getYears()
    {
        $years = [];
        $now = date('Y');
        $now18 = $now-17;
        $range = 100;
        for ($i=$now18; $i>($now18-$range); $i--)
        {
            $years[] = $i;
        }
        return $years;
    }
}
