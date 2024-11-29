<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOpeningHour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pharmacy_id',
        'day_of_week',
        'open_time',
        'close_time',
    ];

    protected $casts = [
        'day_of_week' => 'array',
    ];

    /**
     * 解析開放時間字串
     * @param string $openingHours
     * @return array day_of_week[],open_time,close_time
     */
    public static function parseOpeningHours($openingHours)
    {
        // 定義星期對應陣列
        $daysMap = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];

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

    /**
     * 開放時間格式化成字串
     * @param array $openingHours
     * @return string
     */
    public static function formatOpeningHours($openingHours)
    {
        $daysMap = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
        $result = [];

        foreach ($openingHours as $entry) {
            $dayOfWeek = $entry['day_of_week'];
            $openTime = (new DateTime($entry['open_time']))->format('H:i');
            $closeTime = (new DateTime($entry['close_time']))->format('H:i');

            // 按天數排序，避免錯誤順序
            usort($dayOfWeek, function ($a, $b) use ($daysMap) {
                return array_search($a, $daysMap) - array_search($b, $daysMap);
            });

            // 壓縮連續天數為範圍
            $compressedDays = [];
            $startDay = null;
            $previousIndex = -1;

            foreach ($dayOfWeek as $day) {
                $currentIndex = array_search($day, $daysMap);

                if ($startDay === null) {
                    $startDay = $day;
                } elseif ($currentIndex !== $previousIndex + 1) {
                    // 非連續，結束當前範圍
                    $compressedDays[] = ($startDay === $daysMap[$previousIndex])
                        ? $startDay
                        : "$startDay - {$daysMap[$previousIndex]}";
                    $startDay = $day;
                }

                $previousIndex = $currentIndex;
            }

            // 添加最後一段
            if ($startDay !== null) {
                $compressedDays[] = ($startDay === $daysMap[$previousIndex])
                    ? $startDay
                    : "$startDay - {$daysMap[$previousIndex]}";
            }

            // 組合文字
            $result[] = implode(', ', $compressedDays) . " $openTime - $closeTime";
        }

        // 用 `/` 連接多段時間
        return implode(' / ', $result);
    }
}
