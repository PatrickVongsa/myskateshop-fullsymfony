<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class OrderType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->add('total');
        // ->add('reference')
        // ->add('user')
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('state', ChoiceType::class, [
                'label' => 'Etat',
                'choices' => [
                    'En cours de validation' => 'En cours de validation',
                    'Validée' => 'Validée',
                    'Envoyée' => 'Envoyée',
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
