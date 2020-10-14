<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menus = Menu::all()->sortByDesc('created_at');

        return view('menu.index', compact(['menus']))->with('no', 1);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.show', compact(['menu']));
    }

    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image',
        ]);


        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $dir = 'img/menu/' . $menu->id . '/';
        $extension = strtolower($request->file('image')->getClientOriginalExtension()); // get image extension
        $fileName = str_random() . '.' . $extension; // rename image
        $request->file('image')->move($dir, $fileName);
        $menu->image = $dir . $fileName;
        $menu->save();

        return redirect()->route('menu.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', compact(['menu']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('image')) {
            $dir = 'img/menu/' . $id . '/';
            if (($menu->image != '') && (File::exists($menu->image))){
                File::delete($menu->image);
            }
            $extension = strtolower($request->file('image')->getClientOriginalExtension()); // get image extension
            $fileName = str_random() . '.' . $extension; // rename image
            $request->file('image')->move($dir, $fileName);
            $menu->image = $dir . $fileName;
        }

        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->save();

        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index');
    }
}
