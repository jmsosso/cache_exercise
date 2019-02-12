<?php

namespace Drupal\dropsolid_cache_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a 'ShowQueryArgBlockTwig' block.
 *
 * @Block(
 *  id = "show_query_arg_block_twig",
 *  admin_label = @Translation("Show query arg block twig"),
 * )
 */
class ShowQueryArgBlockTwig extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RequestStack $request_stack) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('request_stack')
    );
  }

  /**
   * {@inheritdoc}
   * Create a url with the following parameters: ?drop=notsosolid&change=unchanged
   *
   */
  public function build() {

    $elements['drop'] = [
      '#markup' => $this->requestStack->getCurrentRequest()->query->get('drop'),
    ];

    $elements['change'] = [
      '#markup' => $this->requestStack->getCurrentRequest()->query->get('change'),
    ];

    $build = [];
    $build['show_query_arg_block_twig']['twig'] = [
      '#theme' => 'showqueryarg',
      '#elements' => $elements,
    ];

    return $build;

  }

}
