<?php

namespace Tests\Unit;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function test_it_normalizes_skincare_and_clothes_aliases(): void
    {
        $this->assertSame('skincare', Category::normalizeSlug('Skincare'));
        $this->assertSame('skincare', Category::normalizeSlug('Skin care'));
        $this->assertSame('clothes', Category::normalizeSlug('Clotes'));
        $this->assertSame('beauty', Category::normalizeSlug('Beauty'));
    }
}
