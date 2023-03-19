<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client(['base_uri' => 'https://pokeapi.co/api/v2/']);
        if($request->page == NULL or $request->page ==""){
            $request->page = 1; 
        }
        if($request->limit == NULL or $request->limit ==""){
            $request->limit = 10; 
        }
        if($request->sort == NULL or $request->sort ==""){
            $request->sort = "-created_at"; 
        }
        if($request->search == NULL or $request->search ==""){
            $request->search = ""; 
        }
        $page = $request->query('page', $request->page);
        $limit = $request->query('limit', $request->limit);
        $sort = $request->query('sort', $request->sort);
        $search = $request->search;

        $response = $client->request('GET', 'pokemon', [
            'query' => [
                'offset' => ($page - 1) * $limit,
                'limit' => $limit,
                'order_by' => $sort,
                'search' => $search,
            ]
        ]);

        $data = json_decode($response->getBody()); 
        $results = array_filter($data->results, function ($item) use ($search) {
            return (strpos(strtolower($item->name), strtolower($search)) !== false) || (strpos(strtolower($item->url), strtolower($search)) !== false);
        });
        return response()->json([
            'data' => $results,
            'page' => $page,
            'limit' => $limit,
            'total' => count($results),
            'sort' => $sort,
            'search' => $search,
        ]);
    }
}



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Cache;

// class PokemonController extends Controller
// {
//     private $client;

//     public function __construct()
//     {
//         $this->client = new Client([
//             'base_uri' => 'https://pokeapi.co/api/v2/',
//         ]);
//     }

//     public function index(Request $request)
//     {
//         $perPage = $request->input('perPage', 20);
//         $page = $request->input('page', 1);
//         $sort = $request->input('sort', '-created_at');
//         $search = $request->input('search');

//         $cacheKey = "pokeapi_pokemon_page_{$page}_perPage_{$perPage}_sort_{$sort}_search_{$search}";

//         $pokemon = Cache::remember($cacheKey, 60, function () use ($perPage, $page, $sort, $search) {
//             $query = [];

//             if ($search) {
//                 $query['name'] = $search;
//                 $query['OR'] = [
//                     'url' => $search,
//                 ];
//             }

//             $response = $this->client->get('pokemon', [
//                 'query' => array_merge([
//                     'limit' => $perPage,
//                     'offset' => ($page - 1) * $perPage,
//                     'order_by' => $sort,
//                 ], $query),
//             ]);

//             $data = json_decode($response->getBody()->getContents(), true);

//             $data['page'] = $page;
//             $data['limit'] = $perPage;
//             $data['sort'] = $sort;
//             $data['search'] = $search;

//             return $data;
//         });

//         return response()->json($pokemon);
//     }
// }
