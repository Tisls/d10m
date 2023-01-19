<?php
namespace Drupal\koil_core\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Class MenuUserAnonymous
 * @Block(
 *   id="uv_sicial_network",
 *   admin_label="Social Network",
 *   category="Koil"
 * )
 */
class MenuUserAnonymousBlock extends BlockBase
{
  public function build()
  {
    return[
      '#theme' => 'menu_user_anonymous'
    ];
  }

}
