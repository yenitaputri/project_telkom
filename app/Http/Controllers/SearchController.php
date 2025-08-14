<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Interfaces\SearchInterface;

class SearchController extends Controller
{
    protected SearchInterface $searchRepository;

    public function __construct(SearchInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('q');

        if (!$keyword) {
            return redirect()->back()->with('error', 'Masukkan kata kunci pencarian.');
        }

        $results = $this->searchRepository->search($keyword);

        return view('search.result', compact('results', 'keyword'));
    }
}
