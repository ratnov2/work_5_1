<?php

namespace App\Containers\Pages\Actions;

use App\Containers\BoxUnique\Tasks\GetBoxTimerLastItemPlayerTask;
use App\Containers\BoxUnique\Tasks\GetPromocodableBoxTask;
use App\Containers\BoxUnique\Tasks\GetTimerableBoxTask;
use App\Containers\BoxUnique\UI\API\Resources\BoxPromocodableResource;
use App\Containers\BoxUnique\UI\API\Resources\BoxTimerableResource;
use App\Containers\BoxLimit\Tasks\GetPlayerActiveBoxLimitTask;
use App\Containers\BoxLimit\Tasks\GetActiveBoxesLimitTask;
use App\Containers\BoxLimit\UI\API\Resources\BoxLimitResource;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Settings\Tasks\GetSettingsBoxTask;
use App\Containers\Settings\Tasks\GetSettingsSiteTask;
use Illuminate\Support\Facades\View;

final class GetBoxesViewAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();

        // Boxes limit
        $boxes_limit = $player ? app(GetPlayerActiveBoxLimitTask::class)->run($player) : app(GetActiveBoxesLimitTask::class)->run();
        $boxes_limit_resources = BoxLimitResource::collection($boxes_limit);

        $boxes_limit_json = [];
        foreach ($boxes_limit_resources as $boxes_limit_resource)
            $boxes_limit_json[] = $boxes_limit_resource->toJson();

        // Boxes
        $settings_site = app(GetSettingsSiteTask::class)->run();
        $settings_box = app(GetSettingsBoxTask::class)->run();

        if ($settings_box->box_timer) {
            $box_timer = app(GetTimerableBoxTask::class)->run();
            $box_timer->time = $player ? app(GetBoxTimerLastItemPlayerTask::class)->run($player)?->created_at : null;
            $box_timer_json = (new BoxTimerableResource($box_timer))->toJson();
        }

        if ($settings_box->box_promocode) {
            $box_promocode_json = (new BoxPromocodableResource(app(GetPromocodableBoxTask::class)->run()))->toJson();
        }

        // Render
        $params = [
            'boxes_limit_json' => $boxes_limit_json,
            'box_timer_json' => $box_timer_json ?? null,
            'box_promocode_json' => $box_promocode_json ?? null,
            'settings_site' => $settings_site
        ];

        return View::make("pages::pages.boxes.index")->with($params)->render();
    }
}
