<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    #get all users
    public function index() {
        $all_users = $this->user->withTrashed()->latest()->paginate(5);
        // paginate() - takes care of setting the query's "limit" based on the current page being viewed by the user.
        // withTrashed() - include the soft deleted records in a query's result
        return view('admin.users.index')->with('all_users', $all_users);
    }

    #deactivate a user
    public function deactivate($id) {
        $this->user->destroy($id);//delete a user
        return redirect()->back();
    }

    #activate a user
    public function activate($id) {
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrashed() -retrieves soft deleted records only
        // restore() - This will "un-delete" aa soft deleted data. This will set the "delete_at" column to null
        return redirect()->back();
    }

}

