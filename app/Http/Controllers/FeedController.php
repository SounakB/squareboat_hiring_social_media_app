<?php


namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class FeedController extends Controller
{
    public function  index(){
        $posts =  Post::orderBy('created_at', 'DESC')->limit(10)->get();
        return view('feed')->with('posts', $posts);
    }

    public function add_post(Request $request){

        if($file=$request->file('image')) {
            $request->validate([ 'image' =>  'image']);
        }else{
            $request->validate([ 'text' => ['required', 'string']]);
        }
        $post = new Post;
        $post->text = $request->input('text');
        if($file=$request->file('image')) {
            $name = time().'_'.uniqid().'.'.$file->extension();
            //echo $file->move('images', $name);
            //Storage::put('images/'.$name, $file);
            $file->move(public_path('uploads'), $name);
            $post->image = $name;
        }
        $post->user_id= auth()->user()->id;
        $post->created_at = $post->updated_at = date('Y-m-d H:i:s');
        $post->save();
        $request->session()->flash('success', "Your status has been posted.");
        return redirect()->back();

    }

    public function add_comment(Request $request){
        error_log("Comment");
        error_log( $request->comment);
        error_log( $request->id);
        $user_id = auth()->user()->id;
        $comment_obj = new Comment();
        $comment_obj->comment = $request->comment;//input('comment');
        $comment_obj->user_id = $user_id;
        $comment_obj->post_id = $request->id;//input('id');
        $comment_obj->created_at = date('Y-m-d H:i:s');
        $comment_obj->save();
        return response()->json(['status' => "success"]);
    }

    public function delete_comment(){

    }

    public function like($id){
        $user_id = auth()->user()->id;
        $like = Like::where('post_id', $id)->where('user_id', $user_id)->first();

        if($like == null){
            $like = new Like();
            $like->user_id = $user_id;
            $like->post_id = $id;
            $like->created_at = date('Y-m-d H:i:s');
            $like->save();
            return response()->json(['liked' => 1]);
        }else{
            $like->delete();
            return response()->json(['liked' => 0]);
        }
    }
}
