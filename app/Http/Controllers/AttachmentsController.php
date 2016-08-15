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
                $path = $this->path.$file->getClientOriginalName();
                $attachment = new Attachment(array(
                    'title' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getClientSize(),
                    'path' => $path,
                    'entity_id' => $request->slug,
                    'author_id' => $this->logged_user->id
                ));

                if(Storage::put($this->path . $file->getClientOriginalName(),  file_get_contents($file->getRealPath())))
                {
                    $attachment->save();
                    array_push($initialPreview, asset(Storage::url($this->path . $file->getClientOriginalName())));

                    $type = InitialPreview::getTypePreview($attachment->type);
                    $showZoom = false;
                    if($type == 'image' || $type == 'pdf')
                    {
                        $showZoom = true;
                    }

                    $otherActionButtons = '<a href="/"><button type="button" class="btn btn-xs btn-default" title="Скачать"><i class="fa fa-download" aria-hidden="true"></i></button></a>';

                    $initialPreConfig = ['type' => $type, 'size' => $attachment->size, 'caption' => $attachment->title, 'url' => route('attachments.destroy'), 'key' => $attachment->id, 'showZoom'=>$showZoom, 'dataKey'=>$otherActionButtons];

                    array_push($initialPreviewConfig, $initialPreConfig);

                    $append = true;
                }
            }

            return response(['initialPreview' => $initialPreview , 'initialPreviewConfig' => $initialPreviewConfig, 'append'=>$append]);
        }

        $error_msg = 'Ошибка при загрузке файла!';
        return response( ['error' => $error_msg, 'request' => $request->all()] );
    }

    /*
     * Удаление вложений
     */
    public function destroy(Request $request)
    {
        Storage::delete(Attachment::find($request->key)->path);

        if(Attachment::destroy($request->key))
        {
            return response($request->all());
        }

        return response($request->all(), 401);
    }


    // Получить ссылку для загрузки
    public function getUrl(Request $request)
    {
        //Attachment::find($request->id)->

        return response($request->id);
    }
}
