<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class UrlShortenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'invalid_message' => 'Invalid url',
                'constraints'     => [
                    new NotBlank(['message' => 'Url is empty']),
                    new Url(['message' => 'Invalid url']),
                    new Length(['min' => 1, 'max' => 2048]),
                ],
                'attr' => ['class' => 'mr-2'],
                'label_attr' => ['class' => 'mr-2'],
            ])
            ->add('ttl', ChoiceType::class, [
                'label' => 'Time limit',
                'choices' => [
                    'Without limit' => 0,
                    '10 minutes'    => 10,
                    '30 minutes'    => 30,
                    '1 hour'        => 60,
                    '2 hours'       => 60 * 2,
                    '1 day'         => 60 * 24,
                    '2 days'        => 60 * 24 * 2
                ],
                'invalid_message' => 'Invalid period',
                'attr' => ['class' => 'mr-2'],
                'label_attr' => ['class' => 'mr-2'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
