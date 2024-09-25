<?php

declare(strict_types=1);

namespace Drupal\user_comment\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

/**
 * Provides a block_comments block.
 *
 * @Block(
 *   id = "user_comment_block_comments",
 *   admin_label = @Translation("block_comments"),
 *   category = @Translation("Custom"),
 * )
 */
final class BlockCommentsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'example' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['example'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Example'),
      '#default_value' => $this->configuration['example'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['example'] = $form_state->getValue('example');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {       

    //obtengo la url y compruebo si pertene a un usuario, sino utilizo el usuario actual
    $route_match = \Drupal::service('current_route_match');
    if($route_match->getParameter('user')){
      $user_id = $route_match->getParameter('user')->id();
      $user_name = $route_match->getParameter('user')->getAccountName();
    } else {
      $user_id = \Drupal::currentUser()->id(); 
      $user_name = \Drupal::currentUser()->getAccountName();
    } 
    //dump($user_id);

    //obtener los 5 últimos comentarios filtrando por usurio
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('comment');
    $ids = $nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('comment_type', 'comment') 
      ->condition('uid', $user_id)
      ->sort('created', 'DESC')
      ->pager(5) 
      ->accessCheck(TRUE)
      ->execute();

    $lastComments = $nodeStorage->loadMultiple($ids);
    //dump($lastComments);

    //obtener el total de comentarios filtrando por usurio
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('comment');
    $ids = $nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('comment_type', 'comment') 
      ->condition('uid', $user_id)
      ->accessCheck(TRUE)
      ->execute();

    $allComments = $nodeStorage->loadMultiple($ids);
    //dump(count($allComments));
    
    //obtener contenido del comentario
    $allWords = ''; 
    foreach ($allComments as $comment) {
      $data = $comment->get('comment_body')->value;      
      $allWords .=  $data;
    }

    $countWords = strlen(strip_tags($allWords));

    //dump(strlen(strip_tags($countWords)));

    $build = [      
      '#userName' => $user_name,
      '#countWords' => $countWords,
      '#NumberComments' => count($allComments),
      '#lastComments' => $lastComments,
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account): AccessResult {
    // @todo Evaluate the access condition here.
    return AccessResult::allowedIf(TRUE);
  }

}
