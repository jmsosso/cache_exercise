<?php

namespace Drupal\dropsolid_cache_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'InfoBlock' block.
 *
 * @Block(
 *  id = "info_block",
 *  admin_label = @Translation("Info block"),
 * )
 */
class InfoBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple([1, 2]);
    $build['nodes'] = [
      '#theme' => 'item_list'
    ];
    foreach ($nodes as $node) {
      /** @var NodeInterface $node */
      $build['nodes']['#items'][] = $node->label();
    }

    return $build;
  }

}
