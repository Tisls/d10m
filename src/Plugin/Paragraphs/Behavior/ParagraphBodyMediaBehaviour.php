<?php

namespace Drupal\koil_core\Plugin\Paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;
use function Symfony\Component\String\s;

/**
 * Class ParagraphBodyMediaBehaviour
 * @package Drupal\koil_core\Plugin\Paragraphs\Behavior
 * @ParagraphsBehavior (
 *   id="paragraph_body_media",
 *   label = "Body/Media",
 *   description = "Body/Media Settings",
 *   weight=10
 * )
 */
class ParagraphBodyMediaBehaviour extends ParagraphsBehaviorBase
{
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $layout = $this->getLayoutValue($paragraph);
    $build['#attributes']['class'][] = Html::getClass("paragraph-column-".$layout);
    if ($this->getReversValue($paragraph)){
      $build['#attributes']['class'][] = Html::getClass("paragraph-field-revers");
    }
  }

  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
    parent::buildBehaviorForm($paragraph, $form, $form_state); // TODO: Change the autogenerated stub
    $form["layout"] = [
      "#type" => "select",
      "#title" => "Layout",
      "#options" => $this ->getLayouts(),
      "#default_vlue" => $this->getLayoutValue($paragraph),
    ];
    $form["revers"] = [
      "#type" => "checkbox",
      "#title" => "Revers",
      "#default_value" => $this->getReversValue($paragraph),
    ];
  }
  protected function getLayouts(){
    return[
      "1_2" => "50 50",
      "2_3" => "66 33",
      "1_4" => "75 25",
    ];
  }

  protected function getLayoutValue(ParagraphInterface $paragraph){
    return $paragraph->getBehaviorSetting($this->getPluginId(), "layout", "1_2");
  }
  protected function getReversValue(ParagraphInterface $paragraph){
    return $paragraph->getBehaviorSetting($this->getPluginId(), "revers", 0);
  }

  public function settingsSummary(Paragraph $paragraph)
  {
   $layout = $this->getLayoutValue($paragraph);
   $summary = [];
   $summary[] = sprintf("Column: %s", $this->getLayouts()[$layout]);
   $summary[] = sprintf("Revers: %s", $this->getReversValue($paragraph) ? "yes" : "no");
   return $summary;
  }

  public static function isApplicable(ParagraphsType $paragraphs_type)
  {
    return $paragraphs_type->id() == "body_media";
  }

}
