<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    /**
     * BukuController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buku()
    {
        return view('buku.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request) {
        Auth::logout();
        return redirect(route('login'));
    }


    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);
        return view('buku.index', compact('bukus'));
    }

        /**
    * create
    *
    * @return void
    */
    public function create()
    {
        return view('buku.create');
    }


    /**
    * store
    *
    * @param  mixed $request
    * @return void
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'title'     => 'required',
            'penulis'     => 'required',
            'penerbit'     => 'required',
            'content'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/bukus', $image->hashName());

        $buku = buku::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'penulis'     => $request->penulis,
            'penerbit'     => $request->penerbit,
            'content'   => $request->content
        ]);

        if($buku){
            //redirect dengan pesan sukses
            return redirect()->route('buku.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('buku.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

        /**
    * edit
    *
    * @param  mixed $buku
    * @return void
    */
    public function edit(buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }


    /**
    * update
    *
    * @param  mixed $request
    * @param  mixed $buku
    * @return void
    */
    public function update(Request $request, buku $buku)
    {
        $this->validate($request, [
            'title'     => 'required',
            'penulis'     => 'required',
            'penerbit'     => 'required',
            'content'   => 'required'
        ]);

        //get data buku by ID
        $buku = buku::findOrFail($buku->id);

        if($request->file('image') == "") {

            $buku->update([
                'title'     => $request->title,
                'penulis'     => $request->penulis,
                'penerbit'     => $request->penerbit,
                'content'   => $request->content
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/bukus/'.$buku->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/bukus', $image->hashName());

            $buku->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'penulis'     => $request->penulis,
                'penerbit'     => $request->penerbit,
                'content'   => $request->content
            ]);

        }

        if($buku){
            //redirect dengan pesan sukses
            return redirect()->route('buku.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('buku.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

        /**
    * destroy
    *
    * @param  mixed $id
    * @return void
    */
    public function destroy($id)
    {
    $buku = Buku::findOrFail($id);
    Storage::disk('local')->delete('public/bukus/'.$buku->image);
    $buku->delete();

    if($buku){
        //redirect dengan pesan sukses
        return redirect()->route('buku.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('buku.index')->with(['error' => 'Data Gagal Dihapus!']);
    }
    }
}