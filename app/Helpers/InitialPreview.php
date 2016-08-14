<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;


// Класс для работы с file-input (plugin)

class InitialPreview
{
    public static function getInitialPreview($files, $entity_type)
    {
        $path = $entity_type.'/'.$files[0]->entity_id. '/';
        $initialPreview = array();

        foreach ($files as $file)
        {
            array_push($initialPreview, asset(Storage::url($path . $file->title)));
        }

        //dd($initialPreview);

        return $initialPreview;
    }

    public static function getinitialPreviewConfig($files)
    {

        $initialPreConfig = array();

        foreach ($files as $file)
        {
            $config = ['type' => InitialPreview::getTypePreview($file->type), 'size' => $file->size, 'caption' => $file->title, 'url' => '#'];

            array_push($initialPreConfig, $config);
        }

        //dd($initialPreConfig);
        return $initialPreConfig;
    }

    public static function getTypePreview($mime)
    {
        switch ($mime)
        {
            case 'image/png':
                $type = 'image';
                break;
            case 'image/jpeg':
                $type = 'image';
                break;
            case 'application/pdf':
                $type = 'pdf';
                break;
                // case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                // case 'application/msword':
                // case 'application/vnd.oasis.opendocument.spreadsheet':
                // case 'application/vnd.ms-excel':
            default:
                $type = 'other';
                break;
        }

        return $type;
    }
}