<?php

namespace Tests\Unit;

use App\Services\PuzzleSolverService;
use PHPUnit\Framework\TestCase;

class PuzzleTest extends TestCase {
    protected $puzzleData = [
        'GQLVMISSIOSSTUDVUWMSE',
        ' AEGLUSVICTRIXSDUCUNIA',
        ' RUNQAEMIMPERIPHPUMADI',
        ' YRIASBJLUMINCUBICULEM',
        ' ASSIVDVSERGTSOPERENRH',
    ];

    protected $solutionData = [
        'VUEJS',
        ' PHP',
        ' REDIS',
        ' POSTGRES',
        ' GARY',
        ' BALL',
    ];

    public function getPuzzleSolver()
    {
        return new PuzzleSolverService();
    }

    public function testPuzzleConstruction()
    {
        $puzzleArray = $this->getPuzzleSolver()->getPuzzleArray($this->puzzleData);

        $this->assertCount(5, $puzzleArray);

        foreach($puzzleArray as $puzzle) {
            $this->assertCount(21, $puzzle);
        }
    }

    public function testAnswerArray()
    {
        $answerArray = $this->getPuzzleSolver()->getAnswers($this->puzzleData, $this->solutionData);

        $this->assertCount(5, $answerArray);

        foreach($answerArray as $outerIndex => $answers) {
            $answers = explode(" ", trim(preg_replace('/\s+/', ' ', $answers)));
            $this->assertCount(21, $answers);

            foreach($answers as $innerIndex => $answer) {
                if ($outerIndex == 0) {
                    if (in_array($innerIndex, [0, 2, 3, 19])) {
                        $this->assertStringNotContainsString('*', $answer);
                        continue;
                    }

                    $this->assertStringContainsString('*', $answer);
                }

                //And so on....
            }
        }
    }
}