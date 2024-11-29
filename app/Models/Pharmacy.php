<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cash_balance',
        'opening_hours',
    ];

    public function masks()
    {
        return $this->hasMany(Mask::class);
    }

    public static function parseOpeningHours($openingHours)
    {
        // 定義星期對應陣列
        $daysMap = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        // 分割時段
        $timeRanges = explode('/', $openingHours);
        $result = [];

        foreach ($timeRanges as $range) {
            // 正則匹配：天數範圍與時間範圍
            preg_match('/([A-Za-z, -]+) (\d{2}:\d{2}) - (\d{2}:\d{2})/', trim($range), $matches);

            if (!empty($matches)) {
                [$fullMatch, $daysRange, $openTime, $closeTime] = $matches;
                // 處理天數範圍
                $dayRanges = explode(',', $daysRange);
                $daysOfWeek = [];
                foreach ($dayRanges as $dayRange) {
                    $dayRange = trim($dayRange);
                    if (strpos($dayRange, '-') !== false) {
                        // 展開範圍，如 Mon-Fri
                        [$startDay, $endDay] = explode(' - ', $dayRange);
                        $startIndex = array_search($startDay, $daysMap);
                        $endIndex = array_search($endDay, $daysMap);

                        if ($startIndex !== false && $endIndex !== false) {
                            if ($startIndex <= $endIndex) {
                                // 普通範圍
                                $daysOfWeek = array_merge($daysOfWeek, array_slice($daysMap, $startIndex, $endIndex - $startIndex + 1));
                            } else {
                                // 跨週範圍
                                $daysOfWeek = array_merge($daysOfWeek, array_slice($daysMap, $startIndex), array_slice($daysMap, 0, $endIndex + 1));
                            }
                        }
                    } else {
                        // 單一天
                        $daysOfWeek[] = $dayRange;
                    }
                }
                // 組合結果
                $result[] = [
                    'day_of_week' => $daysOfWeek,
                    'open_time' => $openTime,
                    'close_time' => $closeTime,
                ];
            }
        }
        return $result;
    }
}
