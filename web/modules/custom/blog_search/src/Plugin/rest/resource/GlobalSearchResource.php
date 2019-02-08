<?php

namespace Drupal\blog_search\Plugin\rest\resource;

use Drupal\Component\Plugin\DependentPluginInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\search_api\ParseMode\ParseModePluginManager;
use Drupal\search_api\Query\QueryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Represents Global search records as resources.
 *
 * @RestResource (
 *   id = "blog_search_global_index",
 *   label = @Translation("Global search"),
 *   uri_paths = {
 *     "canonical" = "/api/search/global",
 *   }
 * )
 */
class GlobalSearchResource extends ResourceBase implements DependentPluginInterface {

  protected $request;

  protected $indexStorage;

  protected $parseModeManager;

  /**
   * Constructs a Drupal\rest\Plugin\rest\resource\EntityResource object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @peram \Drupal\search_api\ParseMode\ParseModePluginManager
   *   $parse_mode_plugin_panager The Search API parse mode plugin manager.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionExeption
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    Request $request,
    EntityTypeManagerInterface $entity_type_manager,
    ParseModePluginManager $parse_mode_plugin_panager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

    $this->request = $request;
    $this->indexStorage = $entity_type_manager->getStorage('search_api_index');
    $this->parseModeManager = $parse_mode_plugin_panager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('request_stack')->getCurrentRequest(),
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.search_api.parse_mode')
    );
  }

  /**
   * Responds to GET requests.
   */
  public function get() {

    if ($this->request->query->has('text')) {
      $text = $this->request->query->get('text');
      $result = [
        'text' => $text,
        'items' => [],
      ];

      /** @var \Drupal\search_api\IndexInterface $index */
      $index = $this->indexStorage->load('global');

      /** @var \Drupal\search_api\ParseMode\ParseModeInterface $parse_mode */
      $parse_mode = $this->parseModeManager->createInstance('terms');

      /** @var \Drupal\search_api\Plugin\views\query\SearchApiQuery $query */
      $query = $index->query();
      $query->setParseMode($parse_mode);
      $query->keys($text);
      $query->setFulltextFields();
      $query->range(0, 5);
      $query->sort('search_api_relevance', QueryInterface::SORT_DESC);

      $search_result = $query->execute();

       if ($search_result->getResultCount()) {
         /** @var \Drupal\search_api\Item\ItemInterface $item */
         foreach ($search_result as $item) {

           $entity = $item->getOriginalObject()->getValue();

           $result['items'][] = [
             'label' => $entity->label(),
             'url' => $entity->toUrl('canonical', [
               'absolute' => TRUE,
             ])->toString(TRUE)->getGeneratedUrl(),
           ];
         }
       }

       $cache = BubbleableMetadata::createFromRenderArray([
         '#cache' => [
           'contexts' => ['url.query_args:text'],
           'max-age' => 60*60*24,
         ]
       ]);

       $response = new ResourceResponse($result);
       $response->addCacheableDependency($cache);
      return $response;
    }
    else {
      return new ResourceResponse(['message:' => 'Text query is missing'], 400);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    return [];
  }

}
