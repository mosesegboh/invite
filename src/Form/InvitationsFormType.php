<?php

namespace App\Form;

use App\Entity\Invitations;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


class InvitationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, array('attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a subject',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your subject should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 255,
                ])
            ],
                ))
            ->add('receiver_id', EntityType::class, array('attr' => ['class' => 'form-control user-search'],
            'class' => User::class,
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a user to send a request to',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your subject should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 255,
                ])
            ],
            ))
            ->add('message', TextareaType::class, array('attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a message',
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 255,
                ])
            ],
                ))
            ->add('sender_id', HiddenType::class)
            ->add('status', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invitations::class,
        ]);
    }
}
