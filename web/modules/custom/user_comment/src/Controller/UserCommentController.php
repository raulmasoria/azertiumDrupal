<?php

declare(strict_types=1);

namespace Drupal\user_comment\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for user_comment routes.
 */
final class UserCommentController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
