<?php

use Telegram\Bot\Objects\MaskPosition;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Objects\StickerSet;

class StickerTest extends \PHPUnit_Framework_TestCase
{
    public function test_sticker_object()
    {
        $sticker = new Sticker([
            'set_name' => 'animals',
            'mask_position' => [
                'point' => 'eyes',
                'x_shift' => -1.0,
                'y_shift' => 1.0,
                'zoom'    => 2.0,
            ],
        ]);
        $this->assertEquals('animals', $sticker->getSetName());
        $this->assertInstanceOf(MaskPosition::class, $sticker->getMaskPosition());
        $this->assertEquals(2.0, $sticker->getMaskPosition()->getZoom());
    }

    public function test_sticker_set_object()
    {
        $set = new StickerSet([
            'name' => 'animals',
            'title' => 'funny animals',
            'is_masks' => true,
            'stickers' => [
                ['file_id' => 1],
                ['file_id' => 2],
            ],
        ]);
        $this->assertEquals('animals', $set->getName());
        $this->assertEquals('funny animals', $set->getTitle());
        $this->assertTrue($set->getIsMasks());
        $this->assertEquals(\Illuminate\Support\Collection::class, get_class($set->getStickers()));
        $this->assertInstanceOf(Sticker::class, $set->getStickers()[0]);
        $this->assertEquals(1, $set->getStickers()[0]->getFileId());
        $this->assertInstanceOf(Sticker::class, $set->getStickers()[1]);
        $this->assertEquals(2, $set->getStickers()[1]->getFileId());
    }

    public function test_mask_position_object()
    {
        $mask = new MaskPosition([
            'point' => 'eyes',
            'x_shift' => -1.0,
            'y_shift' => 1.0,
            'zoom'    => 2.0,
        ]);
        $this->assertEquals('eyes', $mask->getPoint());
        $this->assertEquals(-1.0, $mask->getXShift());
        $this->assertEquals(1.0, $mask->getYShift());
        $this->assertEquals(2.0, $mask->getZoom());
    }
}
