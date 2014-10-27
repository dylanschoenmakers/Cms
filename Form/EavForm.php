<?php

namespace Opifer\EavBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\RouterInterface;

use Opifer\EavBundle\Form\Type\ValueSetType;

class EavForm extends AbstractType
{
    /** @var RouterInterface */
    protected $router;

    /**
     * Constructor
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction(
            $this->router->generate('opifer.eav.form.submit', ['valueId' => $options['valueId']])
        );

        $builder->add('valueset', new ValueSetType());
        $builder->add('save', 'submit');
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'valueId',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'eav_form';
    }
}
