<?php


namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController  extends Controller
{
    public function settings(){
        return view('settings')->with('user', auth()->user());
    }
    public function update(Request $request){
        $role = auth()->user()->role;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:255', 'unique:users,username,'.auth()->user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->user()->id],
            'password' => ['nullable', 'string', 'min:8'],
            'profile_image' => ['nullable', 'image']
        ]);
        $user = Auth::user();
        $input = $request->all();

        if($file=$request->file('profile_image')) {
            $name = time().'_'.uniqid().'.'.$file->extension();
            $file->move(public_path('uploads'), $name);
            $input['profile_image'] = $name;

        }
        $fillable = $user->getFillable();

        foreach ($fillable as $field){

            if($field != "password"){
                if(!array_key_exists($field, $input)){
                    continue;
                }
                $user->$field = $input[$field];
            }elseif ($input['password'] !== NULL && $input['password'] !== ''){
                $user->password = Hash::make($input['password']);
            }
        }
        $user->save();
        $request->session()->flash('success', "Your settings has been updated.");
        return redirect()->back();
    }

    public function search_user($username){
        $user = User::where('username' ,$username)->first();
        if($user == null){
            abort('404');
        }
        $following = false;
        $follow = Follower::where('following', $user->id)->where('followed_by', auth()->user()->id)->first();
        if($follow != null){
            $following = true;
        }
        $total_followers = Follower::where('following', $user->id)->count();
        $total_following = Follower::where('followed_by', $user->id)->count();
        $posts =  Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->limit(10)->get();

        return view('profile')->with('user', $user)->with('posts', $posts)->with('following',$following)->with('total_followers',$total_followers)->with('total_following',$total_following);
    }

    public function follow_user($following){

            $user_id = auth()->user()->id;
            $follow = Follower::where('following', $following)->where('followed_by', $user_id)->first();

            if($follow == null){
                $follow = new Follower();
                $follow->followed_by = $user_id;
                $follow->following = $following;
                $follow->created_at = date('Y-m-d H:i:s');
                $follow->updated_at = date('Y-m-d H:i:s');
                $follow->save();
                return response()->json(['followed' => 1]);
            }else{
                $follow->delete();
                return response()->json(['followed' => 0]);
            }

    }
}
