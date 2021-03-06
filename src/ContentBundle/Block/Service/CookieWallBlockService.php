<?php

namespace Opifer\ContentBundle\Block\Service;

use Opifer\ContentBundle\Entity\CookieWallBlock;
use Opifer\ContentBundle\Block\Service\AbstractBlockService;
use Opifer\ContentBundle\Block\Service\BlockServiceInterface;
use Opifer\ContentBundle\Block\Tool\Tool;
use Opifer\ContentBundle\Block\Tool\ToolsetMemberInterface;
use Opifer\ContentBundle\Model\BlockInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Opifer\CmsBundle\Form\Type\CKEditorType;

/**
 * CoockieWall Block Service
 */
class CookieWallBlockService extends AbstractBlockService implements BlockServiceInterface, ToolsetMemberInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildManageForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildManageForm($builder, $options);

        $builder->add(
            $builder->create('default', FormType::class, ['virtual' => true])
                ->add('value', CKEditorType::class, [
                    'label' => 'label.message',
                ])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createBlock()
    {
        return new CookieWallBlock;
    }

    /**
     * {@inheritDoc}
     */
    public function getTool(BlockInterface $block = null)
    {
        $tool = new Tool('CookieWall', 'cookiewall');

        $tool->setIcon('info')
            ->setDescription('Cookiewall');

        return $tool;
    }
}
