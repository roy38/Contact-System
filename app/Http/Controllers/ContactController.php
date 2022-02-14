<?php

namespace App\Http\Controllers;

use App\Models\Contact;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

		// $contacts = Contact::where('user_id', Auth::user()->id)->paginate(5);
		// dd($contacts->links());
		// exit();

    	// $contacts = Contact::all()->where();

    	// get all contacts with user id

    	// echo Auth::user()->id;
    	// exit();

    	$user_id = Auth::user()->id;

    	$contacts = Contact::where('user_id', Auth::user()->id)->paginate(2);

    	// $contacts = Contact::where('user_id', Auth::user()->id)->paginate(10)->get();

    	// $contacts = Contact::query()->where('id', $user_id)
    	// 					->get();

		// $contacts = Contact::all();

		// $contacts = Contact::paginate(5);

        return view('/home', ['contacts' => $contacts]);
    }

    public function registration_success()
    {
    	return view('/registration_success');
    }

    public function create() {

    	return view('/create');

    }

    public function store() {

    	request()->validate([
    		'name' => 'required',
    		'company' => 'required',
    		'phone' => 'required',
    		'email' => 'required',
    	]);

    	// echo request('name');

    	Contact::create([
    		'user_id' => Auth::user()->id,
    		'name' => request('name'),
    		'company' => request('company'),
    		'phone' => request('phone'),
    		'email' => request('email'),
    	]);

    	// return;
    	return redirect('/home');

    }

    public function edit(Contact $contact) {

    	return view('/edit', ['contact' => $contact]);

    }

    public function update(Contact $contact) {

    	request()->validate([
    		'name' => 'required',
    		'company' => 'required',
    		'phone' => 'required',
    		'email' => 'required',
    	]);

    	$contact->update([
    		'name' => request('name'),
    		'company' => request('company'),
    		'phone' => request('phone'),
    		'email' => request('email'),
    	]);

    	return redirect('/home');
    }

    public function destroy(Contact $contact) {

    	$contact->delete();
    	return redirect('/home');

    }

    public function search(Request $request) {

    	$output = '';
    	if ($request->ajax()) {

    		// $data = Contact::where('user_id', Auth::user()->id)//->paginate(10);
    						// ->orwhere('phone', 'like', '%'.request('search').'%')->paginate(10);
    						// ->orwhere('id','like', '%'.request('search').'%')
    						// ->orwhere('name', 'like', '%'.request('search').'%')
    						// ->orwhere('company', 'like', '%'.request('search').'%')
    						// ->orwhere('phone', 'like', '%'.request('search').'%')
    						// ->orwhere('email', 'like', '%'.request('search').'%')->paginate(10);


    		// $data = Contact::where('user_id', Auth::user()->id)
    		// 				->orwhere('name', 'like', '%'.request('search').'%')->paginate(5);
    						// ->where('name', 'like', '%'.request('search').'%')
    						// ->where('company', 'like', '%'.request('search').'%')
    						// ->where('phone', 'like', '%'.request('search').'%')
    						// ->where('email', 'like', '%'.request('search').'%')->paginate(10);

    		// $statement = "select * from contacts where user_id = ".Auth::user()->id;
    		// $data = DB::statement($statement)->get();

			// $data = DB::statement("'select * from contacts where user_id = ".Auth::user()->id."'");

    		$search = '%'.request('search').'%';
    		// $data = DB::select('SELECT * from contacts WHERE name LIKE :search OR company LIKE :search OR phone LIKE :search OR email LIKE :search AND user_id = :user_id', ['user_id' => Auth::user()->id, 'search' => $search]);
    		$data = DB::select('SELECT * from contacts WHERE (name LIKE :search OR company LIKE :search2 OR phone LIKE :search3 OR email LIKE :search4) AND user_id = :user_id LIMIT 5', ['user_id' => Auth::user()->id, 'search' => $search, 'search2' => $search, 'search3' => $search, 'search4' => $search]);

			// $data = DB::select(
			// 	'SELECT * from contacts 
			// 		WHERE (name LIKE :search OR company LIKE :search2 OR phone LIKE :search3 OR email LIKE :search4) 
			// 		AND user_id = :user_id LIMIT 5', 
			// 		['user_id' => Auth::user()->id, 'search' => $search, 'search2' => $search, 'search3' => $search, 'search4' => $search]
			// 	)->paginate(5);

			// $data = Contact::where(function ($query){
			// 					$query->orWhere('name', 'like', '%'.request('search').'%')
			// 					->orWhere('company', 'like', '%'.request('search').'%')
			// 					->orWhere('phone', 'like', '%'.request('search').'%')
			// 					->orWhere('email', 'like', '%'.request('search').'%');
			// 				})->where('user_id', Auth::user()->id)->paginate(5);

			// // $data = DB::table('contacts')->where('name', 'like', '%'.request('search').'%')->orWhere(function ($query){
			// // 			$query->orWhere('company', 'like', '%'.request('search').'%')
			// // 			->orWhere('phone', 'like', '%'.request('search').'%')
			// // 			->orWhere('email', 'like', '%'.request('search').'%')
			// // 		})->where('user_id', Auth::user()->id)->paginate(5);

			// $output .= $data;

			// return $output;

    		if ( count($data) > 0) {

    			$token = csrf_token();

    			$csrf_method = '<input type="hidden" name="_token" value="'.$token.'">';
    			$csrf_method .= '<input type="hidden" name="_method" value="DELETE">';

	            foreach ($data as $contact) {
	      
	            $output .= '<tr>';
		            $output .= '<td>' .$contact->name. '</td>';
		            $output .= '<td>' .$contact->company. '</td>';
		            $output .= '<td>' .$contact->phone. '</td>';
		            $output .= '<td>' .$contact->email. '</td>';
		            $output .= '<td>' .'<a class="action-text" href="/edit/'.$contact->id.'"><button class="btn btn-success">EDIT</button></a>';
		            $output .= '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal'.$contact->id.'">DELETE</button>';
	                // $output .= '<form method="POST" action = "'. route('delete', $contact->id).'"> '. $csrf_method .' <button class="btn btn-danger">DELETE</button></form>';


	                $output .= '<div id="myModal'.$contact->id.'" class="modal fade" role="dialog">';
	                $output .= '<div class="modal-dialog">';
	                $output .= '<div class="modal-content">';
	                $output .= '<div class="modal-body">';
	                $output .= '<p style="font-size: 20px;">Are you sure you want to DELETE?</p>';
	                $output .= '<form class="delete-ni" method="POST" action = "'.route('delete', $contact->id).'"> '.$csrf_method.' <button class="btn btn-danger">YES'.$contact->id.'</button></form>
	                        <button class="btn btn-success" data-dismiss="modal">NO</button>';
	                $output .= '</div>';
	                $output .= '</div>';
	                $output .= '</div>';
	                $output .= '</div>';

		            $output .= '<td>';
	            $output .= '</tr>';
	            }

    		} else {
    			$output .= '<tr><td><p class="no-results">No Results</p></tr></td>';
    		}
    	}

    	// return $output = '<tr><td><p class="no-results">No Results</p></tr></td>';
    	// return 'SELECT * from contacts WHERE name LIKE "'.$search.'" OR company LIKE "'.$search.'" AND user_id = "'.Auth::user()->id.'"';
    	return $output;
    }
}
