<?php
/**
 * Created by PhpStorm.
 * User: xiaoyukarl
 * Date: 2019-07-17
 */

namespace Xlog\Lib;


use Xlog\Entities\Log;
use Xlog\Entities\LogCollection;

class Xlog
{


    public function dash()
    {
        $logCollection = new LogCollection();
        $stats = $logCollection->stats();
        $percents = $this->calcPercentages($stats);
        $chartData = $this->prepareChartData($percents);

        return [
            'chartData' => $chartData,
            'percents' => $percents
        ];
    }

    public function logList()
    {
        $logCollection = new LogCollection();
        $paginate = $logCollection->paginate();

        return [
            'paginate' => $paginate
        ];
    }

    public function show($date)
    {
        $log = new Log($date, Heplers::getFilePathByDate($date));
        $paginate = $log->getEntries()->paginate();

        return [
            'log' => $log,
            'paginate' => $paginate
        ];
    }


    /**
     * 仪表盘统计数据
     * @param $stats
     * @return array
     */
    protected function calcPercentages($stats)
    {
        $levels = Config::get('levels');
        $percents = [];
        $countData = [];
        foreach ($stats as $date => $stat) {
            $itemTotal = count($stat->entries->items);
            $countData['all']['count'] = isset($countData['all']['count']) ?  $countData['all']['count'] + $itemTotal : $itemTotal;
            $countData['all']['percent'] = 100;
            $countData['all']['name'] = 'all';

            foreach ($levels as $level => $levelName){
                if($level == 'all') continue;
                $items = $stat->entries->filterByLevel($level);
                $levelItemCount =  count($items);
                $countData[$level]['count'] = isset($countData[$level]['count']) ? $countData[$level]['count'] + $levelItemCount : $levelItemCount;
                $countData[$level]['percent'] = 0;
                $countData[$level]['name'] = $level;
            }
        }
        foreach ($countData as $level => $count){
            $percents[$level]['count'] = $count['count'];
            $percents[$level]['name'] = $level;
            $percents[$level]['percent'] = round(($count['count']/$countData['all']['count'])*100 , 2);
        }

        return $percents;
    }

    /**
     * 仪表盘统计数据其他信息
     * @param $percents
     * @return false|string
     */
    protected function prepareChartData($percents)
    {
        $levels = Config::get('levels');
        $colors = Config::get('colors');
        $datasets = [];
        unset($levels['all']);//去除all
        foreach ($levels as $level => $levelName) {
            if($level == 'all')continue;//去除all
            $datasets['data'][] = isset($percents[$level]['count']) ? $percents[$level]['count'] : 0;
            $datasets['backgroundColor'][] = $colors['levels'][$level];
            $datasets['hoverBackgroundColor'][] = $colors['levels'][$level];
        }
        return json_encode([
            'labels'   => array_keys($levels),
            'datasets' => [$datasets],
        ]);
    }


}