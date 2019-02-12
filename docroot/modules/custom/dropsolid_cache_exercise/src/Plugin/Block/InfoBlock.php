<?php

namespace Drupal\dropsolid_cache_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;

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
    $items     = [];
    $cacheTags = [];
    $nodes     = $this->entityTypeManager->getStorage('node')->loadMultiple([1, 2]);

    foreach ($nodes as $node) {
      /** @var \Drupal\node\NodeInterface $node */
      $items[] = $node->label();
      $cacheTags = Cache::mergeTags($cacheTags, $node->getCacheTags());
    }

    return [
      'nodes' => [
        '#theme' => 'item_list',
        '#items' => $items,
        '#cache' => [
          'tags' => $cacheTags,
        ],
      ],
    ];
  }

}
