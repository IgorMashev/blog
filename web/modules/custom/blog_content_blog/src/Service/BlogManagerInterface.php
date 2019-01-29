<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.01.19
 * Time: 9:13
 */

namespace Drupal\blog_content_blog\Service;


use Drupal\node\NodeInterface;

interface BlogManagerInterface {

  /**
   * @param \Drupal\node\NodeInterface $node
   * @param int $limit
   *
   * @return mixed
   */
  public function getRelatedPostsWithExactSameTags(NodeInterface $node, $limit = 2);

  /**
   * @param \Drupal\node\NodeInterface $node
   * @param array $exclude_ids
   * @param int $limit
   *
   * @return mixed
   */
  public function getRelatedPostsWithSameTags(NodeInterface $node, array $exclude_ids = [], $limit = 2);

  /**
   * @param int $limit
   * @param array $exclude_ids
   *
   * @return mixed
   */
  public function getRandomPosts($limit = 2, array $exclude_ids = []);

  /**
   * @param \Drupal\node\NodeInterface $node
   * @param int $max
   * @param int $exact_tags
   *
   * @return mixed
   */
  public function getRelatedPosts(NodeInterface $node, $max = 4, $exact_tags = 2);
}