<?php
namespace AppBundle\Form;

use AppBundle\Model\CardPick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CardPickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taskId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('vote', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CardPick::class
        ]);
    }

    public function getName()
    {
        return 'card_pick';
    }
}