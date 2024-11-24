<?php

namespace App\Library;

use App\Models\Board;
use App\Models\ComplainType;
use App\Models\Unit;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;

class DropDownHelper
{

    private static int $cacheTime = 600; // 10 minutes

    public static function getSscBoards()
    {
        $ssc_board = Cache::remember('ssc_board', self::$cacheTime, function () {

            return Board::where('exam', '=', 'SSC')
                // ->orderby('board_name','asc')
                ->pluck('display_name', 'board_name')->toArray();
        });

        return $ssc_board;
    }


    public static function getHscBoards()
    {
        $hsc_board = Cache::remember('hsc_board', self::$cacheTime, function () {

            return Board::where('exam', '=', 'HSC')
                // ->orderby('board_name','asc')
                ->pluck('display_name', 'board_name')->toArray();
        });

        return $hsc_board;
    }


    public static function getSscYears()
    {
        $ssc_year = Cache::remember('ssc_year', self::$cacheTime, function () {

            return Year::exam('SSC')->pluck('display_name', 'year')->toArray();
        });

        return $ssc_year;
    }


    public static function getHscYears()
    {

        $hsc_year = Cache::remember('hsc_year', self::$cacheTime, function () {

            return Year::exam('HSC')->pluck('display_name', 'year')->toArray();
        });

        return $hsc_year;
    }

    public static function getUnits()
    {
        $quotas = Cache::remember('unitNames', self::$cacheTime, function () {
            return Unit::all()->pluck('description', 'unit_name');
        });

        return $quotas;
    }

    public static function getComplainTypes()
    {
        $complainTypes = Cache::remember('complainTypes', self::$cacheTime, function () {
            return ComplainType::all()->pluck('name', 'id');
        });

        return $complainTypes;
    }


}
