<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchProductType extends AbstractType
{
    private $router;
    public array $portList = [];

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->setAction($this->router->generate('app_shop'))
        ->setMethod('GET')
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control opacity-75',
                    'placeholder' => 'Rechercher un produit'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Product::class,
        ]);
    }
}
