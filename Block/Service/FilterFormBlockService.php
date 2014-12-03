<?php

/*
* This file is part of the Sonata project.
*
* (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Pandora\SyliusFilterBundle\Block\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

class FilterFormBlockService extends BaseBlockService
{
    protected $form;

    public function __construct($type, $templating, $form)
    {
        $this->type = $type;
        $this->templating = $templating;
        $this->form = $form;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'form' => false,
            'template' => 'PandoraSyliusFilterBundle:Block:block_filter_form.html.twig'
        ));
    }

    /**
    * {@inheritdoc}
    */
    // public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    // {
    //     $errorElement
    //         ->with('settings[form]')
    //             ->assertNotNull(array())
    //             ->assertNotBlank()
    //         ->end();
    // }

    /**
    * {@inheritdoc}
    */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        $responseSettings = array(
            'block' => $blockContext->getBlock(),
            'form' => $this->form->createNamed('criteria', $settings['form'])->createView(),
            'settings'  => $settings
        );
        return $this->renderResponse($blockContext->getTemplate(), $responseSettings, $response);
    }
}
