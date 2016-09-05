<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class SortHelper
{
    // Формируем ссылку для сортировки
    public static function link($parameters)
    {
        if (count($parameters) === 1) {
            $parameters[1] = $parameters[0];
        }

        $sort = $sortOriginal = $parameters[0];
        $title = $parameters[1];

        $formatting_function = Config::get('columnsortable.formatting_function', null);

        if (!is_null($formatting_function) && function_exists($formatting_function)) {
            $title = call_user_func($formatting_function, $title);
        }

        $icon = Config::get('columnsortable.default_icon_set');

        if (Input::get('sort') == $sortOriginal && in_array(Input::get('order'), ['asc', 'desc'])) {
            $asc_suffix = Config::get('columnsortable.asc_suffix', '-asc');
            $desc_suffix = Config::get('columnsortable.desc_suffix', '-desc');
            $icon = $icon . (Input::get('order') === 'asc' ? $asc_suffix : $desc_suffix);
            $order = Input::get('order') === 'desc' ? 'asc' : 'desc';
        } else {
            $icon = Config::get('columnsortable.sortable_icon');
            $order = Config::get('columnsortable.default_order_unsorted', 'asc');
        }

        $parameters = [
            'sort' => $sortOriginal,
            'order' => $order,
        ];

        $queryString = http_build_query(array_merge(array_filter(Request::except('sort', 'order')), $parameters));
        $anchorClass = Config::get('columnsortable.anchor_class', null);
        if ($anchorClass !== null) {
            $anchorClass = 'class="' . $anchorClass . '"';
        }

        $iconAndTextSeparator = Config::get('columnsortable.icon_text_separator', '');

        $clickableIcon = Config::get('columnsortable.clickable_icon', false);
        $trailingTag = $iconAndTextSeparator . '<i class="' . $icon . '"></i>' . '</a>';
        if ($clickableIcon === false) {
            $trailingTag = '</a>' . $iconAndTextSeparator . '<i class="' . $icon . '"></i>';
        }

        return '<a ' . $anchorClass . ' href="' . url(Request::path() . '?' . $queryString) . '"' . '>' . htmlentities($title) . $trailingTag;
    }
}