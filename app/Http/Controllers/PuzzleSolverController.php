<?php

namespace App\Http\Controllers;

use App\Services\PuzzleSolverService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PuzzleSolverController extends Controller
{
    private $puzzleSolver;

    public function __construct(PuzzleSolverService $puzzleSolver) {
        $this->puzzleSolver = $puzzleSolver;
    }

    public function solvePuzzle(Request $request)
    {
        $puzzles = json_decode($request->get('puzzle'));
        $solutions = json_decode($request->get('solutions'));

        $answers = $this->puzzleSolver->getAnswers($puzzles, $solutions);

        return response()->json($answers);
    }
}