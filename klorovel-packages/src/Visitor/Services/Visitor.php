<?php

namespace AyatKyo\Klorovel\Visitor\Services;

use AyatKyo\Klorovel\Visitor\Models\Visitor as ModelsVisitor;
use Illuminate\Http\Request;

class Visitor
{
    protected $request;

    protected $statCache;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function ip()
    {
        return $this->request->ip();
    }

    public function route()
    {
        return $this->request->route();
    }

    public function session()
    {
        return $this->request->session()->getId();
    }

    public function visitModel($model, $param = null)
    {
        if (is_a($model, 'Illuminate\Database\Eloquent\Model')) {
            return $this->log([
                "type" => "model",
                "content" => get_class($model) . ":" . $model->{$model->getKeyName()},
            ]);
        } else if (is_string($model) && $param) {
            return $this->log([
                "type" => "model",
                "content" => $model . ':' . $param,
            ]);
        }
    }

    public function visitRoute($routeName)
    {
        
    }

    public function log($params = [
        "type" => "route",
        "content" => ""
    ])
    {
        $lType = $params['type'];
        $visitorData = [];
        if ($lType == 'route') {
            if (($rName = $this->route()->getName())) {
                $visitorData['type']    = 'route';
                $visitorData['content'] = $rName;
            } else {
                $visitorData['type']    = 'url';
                $visitorData['content'] = $this->request->getRequestUri();
            }
        } else {
            $visitorData['type']    = $lType;
            $visitorData['content'] = $params["content"];
        }
        $visitorData['ip'] = $this->ip();
        $visitorData['visit_at'] = now();
        
        $visit = ModelsVisitor::latest()
            ->firstOrCreate(
                [
                    'data'    => $this->session(),
                    // 'ip'      => $visitorData['ip'],
                    'type'    => $visitorData['type'],
                    'content' => $visitorData['content'],
                ],
                $visitorData
            );

        $visit->when(
            $this->canLogVisit($visit),
            function () use ($visit) {
                $visit->replicate()->save();
            }
        );

        return $visit;
    }

    public function canLogVisit($visit)
    {
        return !$visit->wasRecentlyCreated && $visit->visit_at->lt(now()->subDay());
    }

    public function getStat()
    {
        if (! is_null($this->statCache)) {
            return $this->statCache;
        }

        $cSekarang = now();
        $this->statCache = (object) [
            'total' => 0,
            'bulan' => 0,
            'minggu' => 0,
            'hari' => 0,
        ];

        $this->statCache->total = ModelsVisitor::visitCount();
        $this->statCache->hari  = ModelsVisitor::whereDate('visit_at', $cSekarang)
            ->visitCount();
        $this->statCache->bulan = ModelsVisitor::whereMonth('visit_at', $cSekarang->month)
            ->whereYear('visit_at', $cSekarang->year)
            ->visitCount();
        $this->statCache->minggu = ModelsVisitor::where('visit_at', '>=', $cSekarang->startOfWeek()->format('Y-m-d H:m:s'))
            ->where('visit_at', '<=', $cSekarang->endOfWeek()->format('Y-m-d H:m:s'))
            ->visitCount();

        return $this->statCache;
    }

    public function count($type = null, $value = null)
    {
        return ModelsVisitor::query()
            ->when($type, function ($query, $type) {
                return $query->whereType($type);
            })
            ->when($value, function ($query, $value) {
                return $query->whereContent($value);
            })
            ->count('id');
    }

    public function countRoute($value = null)
    {
        return $this->count('route', $value);
    }
}
