<?php

namespace App\Http\Controllers;

use App\Attachment;
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
            $i = 0;
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

                    $initialPreview = array(
                        "<img src='".Storage::url($this->path . $file->getClientOriginalName())."' class='file-preview-image' alt='' title=''>",
                    );

                    $link = "<a href='".Storage::url($this->path . $file->getClientOriginalName())."'>Скачать!</a>";


                    //$initialPreviewConfig = array();
                }
                $i++;
            }

            return response([$initialPreview, $link, $i]);
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
