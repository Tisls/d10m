<?php
namespace Drupal\koil_core\Plugin\Paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * Class Paragraph
 * @package Drupal\koil_core\Plugin\Paragraphs\Behavior
 * @ParagraphsBehavior (
 *   id="paragraph_gallery",
 *   label = "Gallery Settings",
 *   description = "Gallery Description",
 *   weight=10
 * )
 */

class Paragraph extends ParagraphsBehaviorBase

{

  public function view(array &$build, \Drupal\paragraphs\Entity\Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $column = $this->getColumnValue($paragraph);
    if($column != "none"){
      $build['#attributes']['class'][]= Html::getClass($column);
    }
    $build['#attached']["library"][] = "koil_core/paragraph_gallery_behavior";
  }

  public function settingsSummary(\Drupal\paragraphs\Entity\Paragraph $paragraph)
  {
    $column = $this->getColumnValue($paragraph);
    $summary = [];
    if($column != "none"){
      $summary[] = "Column: " .$this->getColumns()[$column];
    }
    return $summary;
  }
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
     parent::buildBehaviorForm($paragraph, $form, $form_state);
     $form["column"] = [
       '#type' => "select",
       "#title" => "Columns",
       "#options" => $this->getColumns(),
       "#default_value" => $this->getColumnValue($paragraph)
     ];
  }
    protected function getColumns(){
    return[
      "none" => "None",
      "column_2" => "Column 2",
      "column_3" => "Column 3"
    ];
  }
protected function getColumnValue(ParagraphInterface $paragraph){
    return $paragraph->getBehaviorSetting($this->getPluginId(), "column", "none");

}
  public static function isApplicable(ParagraphsType $paragraphs_type)
  {
    return $paragraphs_type->id() == "gallery";
  }

}
