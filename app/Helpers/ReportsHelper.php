<?php
/**
 * Набор функций для работы с отчетами
 */

namespace App\Helpers;

class ReportsHelper
{
  // Массив с типами документов
  public static function getEntityType()
  {
    return array(
            'io_orders' => 'Приказы',
            'i_orders' => 'Входящие приказы',
            'o_orders' => 'Исходящие приказы',
            'io_documents' => 'Документы',
            'i_documents' => 'Входящие документы',
            'o_documents' => 'Исходящие документы',
            // 'io_dsp' => 'ДСП',
            // 'i_dsp' => 'Входящие ДСП',
            // 'o_dsp' => 'Исходящие ДСП'
        );
  }

  public static function typeToName($entity)
  {
    $type = get_class($entity);

    switch ($type) {
      case 'App\Order':
        $typeName = 'ВП';
        break;
      case 'App\OutboxOrder':
        $typeName = 'ИП';
        break;
      case 'App\InboxDocument':
        $typeName = 'ВД';
      break;

      case 'App\OutboxDocument':
        $typeName = 'ИД';
      break;

      case 'App\InboxDsp':
        $typeName = 'ВДСП';
      break;

      case 'App\OutboxDsp':
        $typeName = 'ИДСП';
      break;

      default:
        $typeName = '--';
        break;
    }

    return $typeName;
  }

}