<?php

declare(strict_types=1);

namespace App\Application\Form\Wishlist\WishlistGroup\WishlistGroupMember;

use App\Action\Command\Wishlist\WishlistGroup\AddMemberToWishlistGroupCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

final class AddWishlistGroupMemberForm extends AbstractType
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudonym', TextType::class, [
                'required' => $options['pseudonym_mandatory'],
                'label' => $this->translator->trans('form.pseudonym')
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => $this->translator->trans('form.email')
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
                /** @var AddMemberToWishlistGroupCommand $data */
                $data = $event->getData();

                $reflectionClass = new \ReflectionClass(AddMemberToWishlistGroupCommand::class);
                if(
                    $data->getEmail()
                    && !$reflectionClass->getProperty('pseudonym')->isInitialized($data)
                ) {
                    $event->getForm()->get('pseudonym')->addError(new FormError('Pseudonym is required'));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddMemberToWishlistGroupCommand::class,
            'pseudonym_mandatory' => true
        ]);
    }
}
