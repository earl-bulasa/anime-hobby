<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\ThemeSong;
use GuzzleHttp\Client;
use DB;

class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $anime = new Anime;
        if($this->setAnime($anime, $request)) {
            foreach($request->theme_songs as $theme_song) {
                $this->addAnimeSong($anime->id, $theme_song);
            }
            return response()->json(['success' => true, 'msg' => 'Anime Added Successfully'], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Anime Not Added'], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anime = Anime::select('title', 'description', 'myanimelist_id', 'id')->with(['theme_songs' => function($query) {
            $query->orderBy('type', 'asc');
        }])->find($id);
        return response()->json(['anime' => $anime], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $anime = Anime::find($id);
        if($this->setAnime($anime, $request)) {
            $song_ids = collect($request->theme_songs)->map(function($theme_song) {
                if(isset($theme_song['id']) && !empty($theme_song['id'])) {
                    return $theme_song['id'];
                }
            })->filter()->all();
            $this->removeAnimeSongs($anime->id, $song_ids);
            foreach($request->theme_songs as $theme_song) {
                if(isset($theme_song['id']) && !empty($theme_song['id'])) {
                    if(in_array($theme_song['id'], $song_ids)) {
                        $this->updateAnimeSongs($theme_song);
                    }
                } else {
                    $this->addAnimeSong($anime->id, $theme_song);
                }
            }
            return response()->json(['success' => true, 'msg' => 'Anime Updated Successfully'], 200);
        } else {
            return response()->json(['success' => false,'msg' => 'Anime Not Updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Anime::find($id)->delete()) {
            return response()->json(['msg' => 'Anime Deleted Successfully'], 200);
        } else {
            return response()->json(['msg' => 'Anime Not Deleted'], 400);
        }
    }

    private function addAnimeSong($anime, $theme_song) 
    {
        $song = new ThemeSong;
        $song->anime_id = $anime;
        $song->type = $theme_song['type'];
        $song->title = $theme_song['title'];
        $song->save();
    }

    private function removeAnimeSongs($anime, $theme_songs)
    {
        ThemeSong::whereNotIn('id', $theme_songs)->where('anime_id', $anime)->delete();
    }

    private function updateAnimeSongs($theme_song) 
    {
        $song = ThemeSong::find($theme_song['id']);
        $song->type = $theme_song['type'];
        $song->title = $theme_song['title'];
        $song->save();
    }

    private function setAnime($anime, $request)
    {
        $anime->title = $request->title;
        $anime->description = $request->description;
        $anime->myanimelist_id = $request->myanimelist_id;
        return $anime->save();   
    }

    public function listAll(Request $request)
    {
        $animes = Anime::select('id', 'myanimelist_id', 'title', 'description')
            ->where($request->attribute, 'like', '%'.$request->text.'%')->get();
        // $animes = Anime::select('id', 'myanimelist_id', 'title', 'description')
        //     ->where(DB::raw('lower('.$request->attribute.')'), 'like', '%'.strtolower($request->text).'%')->get();
        return response()->json(['animes' => $animes], 200);
    }

    public function getCast($anime) 
    {
        $client = new Client;
        $response = $client->request('GET', 'https://api.jikan.moe/v3/anime/'.$anime.'/characters_staff');
        $res = json_decode($response->getBody(),true);
        return response()->json(['res' => $res], 200);
    }
}
