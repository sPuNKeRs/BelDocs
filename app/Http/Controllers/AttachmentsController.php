<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Helpers\InitialPreview;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class AttachmentsController extends Controller
{
    protected $logged_user;
    protected $path;

    /*
     * Конструктор класса
     */
    public function __construct()
    {
        $this->logged_user = \App::make('authenticator')->getLoggedUser();
    }

    /*
     * Сохранение вложений
     */
    public function store(Request $request)
    {
        if($request->hasFile('upload_files'))
        {
            $files = $request->file('upload_files');
            $this->path = $request->entity_type.'/'.$request->slug. '/';

            //$initialPreview = InitialPreview::getInitialPreview($files, $this->path);



            $initialPreview = array();
            $initialPreviewConfig = array();

            foreach ($files as $file)
            {
                $attachment = new Attachment(array(
                    'title' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getClientSize(),
                    'entity_id' => $request->slug,
                    'author_id' => $this->logged_user->id
                ));

                if(Storage::put($this->path . $file->getClientOriginalName(),  file_get_contents($file->getRealPath())))
                {
                    $attachment->save();
                    $type = '';

                    array_push($initialPreview, asset(Storage::url($this->path . $file->getClientOriginalName())));

                    switch ($attachment->type)
                    {
                        case 'image/png':
                            $type = 'image';
                            break;
                        case 'image/jpeg':
                            $type = 'image';
                            break;
//                        case 'application/vnd.ms-excel':
//                            $type = 'other';
//                            break;
//
//                        case 'application/vnd.oasis.opendocument.spreadsheet':
//                            $t
                        case 'application/pdf':
                            $type = 'pdf';
                            break;
//                        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
//                            $type = 'other';
//                            break;
//                        case 'application/msword':
//                            $type = 'other';
//                            break;
                        default:
                            $type = 'other';
                            break;
                    }

                    $initialPreConfig = ['type' => $type, 'size' => $attachment->size, 'caption' => $attachment->title, 'url' => '#'];

                    array_push($initialPreviewConfig, $initialPreConfig);

                    $append = true;
                }
            }

            //, 'initialPreviewConfig' => $initialPreviewConfig

            return response(['initialPreview' => $initialPreview , 'initialPreviewConfig' => $initialPreviewConfig, $attachment]);
        }


        //{error: 'You have faced errors in 4 files.', errorkeys: [0, 3, 4, 5]}

        $error_msg = 'Ошибка при загрузке файла!';
        return response( ['error' => $error_msg, 'request' => $request->all()] );
    }

    /*
     * Удаление вложений
     */
    public function destroy()
    {
        return response('Удаляем');
    }

    /*
     * Получить вложения
     */
    public function getAttachments($filename)
    {
//        $file = Storage::get('uploads/'.$filename);
//
//        $url = Storage::url('uploads/'.$filename);
//        return response($file);
    }
}
