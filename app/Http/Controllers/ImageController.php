<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use Illuminate\Support\Arr;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageController extends Controller
{
    public function creatingNewImage(Request $request)
    {

        $postId = $request->get('post_id');
        $nameImage =  $request->get('nameImage');
        $imageAdded = new Images([
            'nameImage' => $nameImage,
            'post_id' => $postId,
        ]);

        $imageAdded->save();
        return response()->json($imageAdded);
    }

    public function updateImageCreated(Request $request, $id, $postId)
    {
        if (!$request->hasFile('image')) {
            return response()->json([
                'message' => 'need a file image.'
            ]);
        }

        $arrExtention = ['jpeg', 'png', 'git', 'jpg'];
        $ext = $request->file('image')->extension();
        $exists = Arr::exists($arrExtention, $ext);

        if ($exists) {
            return response()->json([
                'message' => 'invalid extention.'
            ]);
        }

        $imageUploaded = $request->file('image')->storeOnCloudinary();
        Images::where('id', '=', $id)->where('post_id', '=', $postId)->update([
            'single_url_image' => $imageUploaded->getSecurePath(),
            'public_id' => $imageUploaded->getPublicId(),
            'created_date_image' => $imageUploaded->getTimeUploaded(),
        ]);

        return response()->json(Images::find($id));
    }

    public function updateManyImages(Request $request, $id)
    {
        if ($request->hasFile('images')) {
            return response()->json([
                'message' => 'There is not images.'
            ]);
        }

        $imagesArray = [];
        $images = $request->file('images')->storeOnCloudinary();
        foreach ($images as $image) {
            array_push($imagesArray, (object)[
                'single_url_image' => $image->getSecurePath(),
                'public_id' => $image->getPublicId(),
                'created_date_image' => $image->getTimeUploaded(),
            ]);
        }

        Images::where('id', '=', $id)->update([
            'several_url_images' => $imagesArray
        ]);
        return response()->json(Images::find($id));
    }

    public function deleteImage($id)
    {
        $image = Images::where('id', '=', $id)->get();
        if (count($image) <= 0) return response()->json([]);

        $imageDeleted = Images::find($image[0]->id)->delete();
        $this->deleteImageFromCloudinary($image[0]->public_id);

        return response()->json($imageDeleted);
    }

    private function deleteImageFromCloudinary($public_id)
    {
        Cloudinary::destroy($public_id);
    }


    public function gettingImageById(Request $request, $id)
    {
        $fieldSelected = $request->input('fieldSelected');
        $image = Images::where('id', '=', $id)
            ->select($fieldSelected)->get();
        return $image;
    }

    public function gettingImageByPostId($postId)
    {
        $postImage = Images::where('post_id', '=', (int)$postId)
            ->select('id', 'nameImage', 'post_id', 'public_id', 'single_url_image')->get();
        return $postImage;
    }
}
