<?php

namespace Drupal\blog_hero\Generator;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class BlogHeroPluginGenerator extends BaseGenerator {

  protected $name = 'plugin-blog-hero';

  protected $alias = 'dh';

  protected $description = 'Generates BlogHero plugin.';

  protected $templatePath = __DIR__ . '/templates';

  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, string $name = NULL) {
    parent::__construct($name);

    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();
    $this->askForPluginType($questions);

    $questions['is_title'] = new ConfirmationQuestion(t('Do you want to customize title?'), FALSE);
    $questions['is_subtitle'] = new ConfirmationQuestion(t('Do you want to add subtitle?'), FALSE);
    $questions['is_image'] = new ConfirmationQuestion(t('Do you want to specify image?'), FALSE);
    $questions['is_video'] = new ConfirmationQuestion(t('Do you want to specify video?'), FALSE);

    $vars = &$this->collectVars($input, $output, $questions);
  }

  public function askForPluginType(&$question) {
    $blog_hero_plugin_types = [
      'path' => 'BlogHero Path plugin',
      'entity' => 'BlogHero Entity plugin',
    ];

    $question['blog_hero_plugin_type'] = new ChoiceQuestion(
      t('What plugin type do you want to create?'),
      $blog_hero_plugin_types
    );

  }
}