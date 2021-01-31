<?php

namespace App\Services;

class PuzzleSolverService
{
    protected $solutionLength;
    protected $puzzleString;
    protected $solutionArray;
    protected $answerArray;
    protected $outerIndex;
    protected $innerIndex;
    protected $puzzleArray;

    public function getAnswers($puzzles, $solutions)
    {
        $this->puzzleArray = $this->answerArray = $this->getPuzzleArray($puzzles);

        foreach($solutions as $solution) {
            $solution = trim($solution, ' ');
            $this->solutionLength = strlen($solution);
            $this->solutionArray = str_split($solution);
            $firstLetter = $this->solutionArray[0];
    
            foreach($this->puzzleArray as $outerIndex => $puzzleString) {
                $this->outerIndex = $outerIndex;
                $this->puzzleString = $puzzleString;

                foreach($this->puzzleString as $innerIndex => $puzzleLetter) {
                    $this->innerIndex = $innerIndex;

                    if ($puzzleLetter != $firstLetter) {
                        continue;
                    }

                    $this->forwardTest();

                    $this->backwardTest();

                    $this->horizontalTest();

                    $this->horizontalBackwardTest();

                    $this->diagonalTest();

                    $this->diagonalBackwardTest();
                }
            }
        }

        $this->formatAnswers();

        return $this->answerArray;
    }

    public function getPuzzleArray($puzzles)
    {
        $this->puzzleArray = [];

        foreach($puzzles as $puzzle) {
            $puzzle = trim($puzzle);
            $this->puzzleArray[] = str_split($puzzle);
        }

        return $this->puzzleArray;
    }

    public function forwardTest()
    {
        $possibleSolution = [];

        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleString[$x + $this->innerIndex]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleString[$x + $this->innerIndex];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$this->outerIndex][$x + $this->innerIndex] = $this->answerArray[$this->outerIndex][$x + $this->innerIndex].' answer';
            }
        }
    }

    public function backwardTest()
    {
        $possibleSolution = [];

        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleString[$this->innerIndex - $x]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleString[$this->innerIndex - $x];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$this->outerIndex][$this->innerIndex - $x] = $this->answerArray[$this->outerIndex][$this->innerIndex - $x].' answer';
            }
        }
    }

    public function horizontalBackwardTest()
    {
        $possibleSolution = [];
        
        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleArray[$this->outerIndex - $x][$this->innerIndex]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleArray[$this->outerIndex - $x][$this->innerIndex];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$this->outerIndex - $x][$this->innerIndex] = $this->answerArray[$this->outerIndex - $x][$this->innerIndex].' answer';
            }
        }
    }

    public function horizontalTest()
    {
        $possibleSolution = [];

        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleArray[$x + $this->outerIndex][$this->innerIndex]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleArray[$x + $this->outerIndex][$this->innerIndex];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$x + $this->outerIndex][$this->innerIndex] = $this->answerArray[$x + $this->outerIndex][$this->innerIndex].' answer';
            }
        }
    }

    public function diagonalTest()
    {
        $possibleSolution = [];

        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleArray[$this->outerIndex + $x][$this->innerIndex + $x]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleArray[$this->outerIndex + $x][$this->innerIndex + $x];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$this->outerIndex + $x][$this->innerIndex + $x] = $this->answerArray[$this->outerIndex + $x][$this->innerIndex + $x].' answer';
            }
        }
    }

    public function diagonalBackwardTest()
    {
        $possibleSolution = [];

        for ($x = 0; $x < $this->solutionLength; $x++) {
            if (!isset($this->puzzleArray[$this->outerIndex - $x][$this->innerIndex - $x]) || !isset($this->solutionArray[$x])) {
                break;
            }

            $letter = $this->puzzleArray[$this->outerIndex - $x][$this->innerIndex - $x];

            if ($letter != $this->solutionArray[$x]) {
                break;
            }

            $possibleSolution[] = $this->solutionArray[$x];
        }

        if (count($possibleSolution) == $this->solutionLength) {
            for ($x = 0; $x < $this->solutionLength; $x++) {
                $this->answerArray[$this->outerIndex - $x][$this->innerIndex - $x] = $this->answerArray[$this->outerIndex - $x][$this->innerIndex - $x].' answer';
            }
        }
    }

    public function formatAnswers()
    {
        foreach($this->answerArray as $outerIndex => $answerString) {
            $this->outerIndex = $outerIndex;

            foreach($answerString as $innerIndex => $answer) {
                $this->innerIndex = $innerIndex;

                if (strpos($answer, 'answer') == false) {
                    $this->answerArray[$this->outerIndex][$this->innerIndex] = ' * ';
                    continue;
                }
    
                $this->answerArray[$this->outerIndex][$this->innerIndex] = ' '.substr($answer, 0, 1);
            }

            // $this->answerArray[$this->outerIndex] = implode(' ',$this->answerArray[$this->outerIndex])."<br/>";
            $this->answerArray[$this->outerIndex] = implode(' ',$this->answerArray[$this->outerIndex]);
        }
    }
}