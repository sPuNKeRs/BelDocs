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
            switch ($request->entity_type)
            {
                case 'App\Order':
                    $entity_folder = 'orders';
                    break;
                case 'App\OutboxOrder':
                    $entity_folder = 'outbox_orders';
                    break;            
            }

            $files = $request->file('upload_files');
            $this->path = $entity_folder.'/'.$request->id. '/';

            $initialPreview = array();
            $initialPreviewConfig = array();

            foreach ($files as $file)
            {
                $url = asset(Storage::url($this->path . $file->getClientOriginalName()));
                $path = $this->path.$file->getClientOriginalName();
                $attachment = new Attachment(array(
                    'title' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getClientSize(),
                    'path' => $path,
                    'url' => $url,
                    'entity_id' => $request->entity_id,
                    'entity_type' => $request->entity_type,
                    'author_id' => $this->logged_user->id
                ));

                if(Storage::put($this->path . $file->getClientOriginalName(),  file_get_contents($file->getRealPath())))
                {
                    $attachment->save();
                    array_push($initialPreview, $url);

                    $type = InitialPreview::getTypePreview($attachment->type);
                    $showZoom = false;
                    if($type == 'image' || $type == 'pdf')
                    {
                        $showZoom = true;
                    }

                    //$otherActionButtons = '<a href="/"><button type="button" class="btn btn-xs btn-default" title="Скачать"><i class="fa fa-download" aria-hidden="true"></i></button></a>';
                    //$initialPreConfig = ['type' => $type, 'size' => $attachment->size, 'caption' => $attachment->title, 'url' => route('attachments.destroy'), 'key' => $attachment->id, 'showZoom'=>$showZoom, 'dataKey'=>$otherActionButtons];

                    $initialPreConfig = ['type' => $type, 'size' => $attachment->size, 'caption' => $attachment->title, 'url' => route('attachments.destroy'), 'key' => $attachment->id, 'showZoom'=>$showZoom];

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
        return response(Attachment::find($request->id)->url);
    }
}
