<?php

namespace Drupal\dropsolid_cache_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a 'ShowQueryArgBlock' block.
 *
 * @Block(
 *  id = "show_query_arg_block",
 *  admin_label = @Translation("Show query arg block"),
 * )
 */
class ShowQueryArgBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   */
  public function build() {
    $drop  = $this->requestStack->getCurrentRequest()->query->get('drop');
    $build = [];

    if (isset($drop)) {
      $build['show_query_arg_block'] = [
        '#markup' => "<h1>Drop-" . $drop . "</h1>",
        '#cache' => [
          'contexts' => [
            'url.query_args:drop',
          ],
        ],
      ];
    }

    return $build;
  }

}
