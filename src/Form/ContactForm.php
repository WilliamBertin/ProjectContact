<?php
// src/Form/ContactForm.php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('attr' => array('placeholder' => 'Nom'),   'required' => false))
            ->add('lastname',  TextType::class, array('attr' => array('placeholder' => 'Prénom'), 'required' => false))
            ->add('fullname',  TextType::class, array('attr' => array('placeholder' => 'Nom + Prénom (*)'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez remplir ce champ")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Adresse e-mail (*)'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez remplir ce champ")),
                    new Email(array("message" => "Veuillez reenseigner une adresse mail valide")),
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'         => Contact::class,
                'csrf_protection'    => false
        ));
    }
}