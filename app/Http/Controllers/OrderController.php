<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Mail\PosiMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ImageController;

class OrderController extends Controller
{

    protected $imageService;
    public function __construct(ImageController $ImageService)
    {
        $this->imageService = $ImageService;
    }

    public function generateOrder(Request $request)
    {
        $orderAdded = Orders::updateOrCreate([
            'nameWhoPosted' =>  $request->get('nameWhoPosted'),
            'user_id' => $request->get('user_id'),
            'emailToSend' => $request->get('emailToSend'),
            'postInfo' => json_encode($request->get('postInfo')),
            'whoOrdered' => $request->get('whoOrdered'),
        ]);

        $orderAdded->save();
        $post = json_decode($orderAdded->postInfo);
        $orderAdded->postInfo = json_decode($orderAdded->postInfo);
        $imageInfo = $this->imageService->gettingImageByPostId($post->id);
        //Mail::to($orderAdded->emailToSend)->send(new PosiMail($orderAdded->emailToSend));

        return response()->json(
            [
                "image" => $imageInfo,
                "orderAdded" => $orderAdded,
            ]
        );
    }

    public function acceptOrDeclineOrder(Request $request, $id)
    {
        $accept = $request->get('accept');
        $orderUpdated = Orders::where('id', '=', $id)->update(['accept' => $accept]);
        return response()->json($orderUpdated);
    }

    public function listingUser($user_id)
    {
        /*         $ordersUser = Orders::where('user_id', '=', $user_id)->get();
        $ordersUser->postInfo = json_decode($ordersUser->postInfo); */
        return response()->json(Orders::where('user_id', '=', $user_id)->get());
    }
}
