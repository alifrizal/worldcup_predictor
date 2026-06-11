<?php

namespace Tests\Unit;

use App\Services\PredictionScoringService;
use PHPUnit\Framework\TestCase;

class ScoringTest extends TestCase
{
    private PredictionScoringService $scorer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scorer = new PredictionScoringService();
    }

    public function test_exact_score(): void
    {
        [$points, $type] = $this->scorer->calculate(2, 1, 2, 1);
        $this->assertEquals(3.0, $points);
        $this->assertEquals('exact', $type);
    }

    public function test_close_non_draw(): void
    {
        [$points, $type] = $this->scorer->calculate(2, 1, 3, 2);
        $this->assertEquals(1.5, $points);
        $this->assertEquals('close', $type);
    }

    public function test_close_margin_diff_one(): void
    {
        [$points, $type] = $this->scorer->calculate(2, 1, 2, 0);
        $this->assertEquals(1.5, $points);
        $this->assertEquals('close', $type);
    }

    public function test_result_not_close(): void
    {
        [$points, $type] = $this->scorer->calculate(2, 1, 3, 0);
        $this->assertEquals(1.0, $points);
        $this->assertEquals('result', $type);
    }

    public function test_wrong_result(): void
    {
        [$points, $type] = $this->scorer->calculate(2, 1, 0, 1);
        $this->assertEquals(0.0, $points);
        $this->assertEquals('wrong', $type);
    }

    public function test_draw_close(): void
    {
        [$points, $type] = $this->scorer->calculate(1, 1, 2, 2);
        $this->assertEquals(1.5, $points);
        $this->assertEquals('close', $type);
    }

    public function test_draw_close_zero(): void
    {
        [$points, $type] = $this->scorer->calculate(1, 1, 0, 0);
        $this->assertEquals(1.5, $points);
        $this->assertEquals('close', $type);
    }

    public function test_draw_not_close(): void
    {
        [$points, $type] = $this->scorer->calculate(1, 1, 3, 3);
        $this->assertEquals(1.0, $points);
        $this->assertEquals('result', $type);
    }
}
