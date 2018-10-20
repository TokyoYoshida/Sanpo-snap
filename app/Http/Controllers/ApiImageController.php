<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Lib\Image;

class ApiImageController extends Controller
{
    /**
     * upload a photo file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        $this->validator($request->all())->validate();

        $filepath = $request->file->store(config('app.image_tmp_dir'));

        $basename = basename($filepath);
        $image_filename = base_path() . "/public/storage/tmp/{$basename}";
        Image::stripImage($image_filename, $image_filename);

        return response($basename);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        $validator = Validator::make($data, [
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg',
                // 最小縦横120px 最大縦横400px
                'dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            ]
        ]);

        return $validator;
    }
}
