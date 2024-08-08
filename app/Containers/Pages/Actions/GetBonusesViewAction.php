<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Banner\Models\Banner;
use App\Containers\Banner\Tasks\GetActiveBannersTask;
use App\Containers\Contest\Tasks\GetActiveContestsTask;
use App\Containers\Contest\UI\API\Resources\ContestResource;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\BoxUnique\Tasks\GetBoxTimerLastItemPlayerTask;
use App\Containers\BoxUnique\Tasks\GetPromocodableBoxTask;
use App\Containers\BoxUnique\Tasks\GetTimerableBoxTask;
use App\Containers\BoxUnique\UI\API\Resources\BoxPromocodableResource;
use App\Containers\BoxUnique\UI\API\Resources\BoxTimerableResource;
use App\Containers\Settings\Tasks\GetSettingsBoxTask;
use App\Containers\Settings\Tasks\GetSettingsSiteTask;
use App\Containers\Site\Tasks\GetActiveSiteCategoriesTask;
use App\Containers\Site\UI\API\Resources\SiteCategoryResource;
use Illuminate\Support\Facades\View;

final class GetBonusesViewAction
{
    public function run()
    {
        $settings_site = app(GetSettingsSiteTask::class)->run();
        $player = app(GetAuthPlayerTask::class)->run();

        // Boxes
        $settings_box = app(GetSettingsBoxTask::class)->run();
        if ($settings_box->box_timer) {
            $box_timer = app(GetTimerableBoxTask::class)->run();
            $box_timer->time = $player ? app(GetBoxTimerLastItemPlayerTask::class)->run($player)?->created_at : null;
            $box_timer_json = (new BoxTimerableResource($box_timer))->toJson();
        }
        if ($settings_box->box_promocode) $box_promocode_json = (new BoxPromocodableResource(app(GetPromocodableBoxTask::class)->run()))->toJson();

        // Contests
        $contests_json = [];
        $contest_resources = ContestResource::collection(app(GetActiveContestsTask::class)->run(limit:2));
        foreach ($contest_resources as $contest_resource)
            $contests_json[] = $contest_resource->toJson();

        // Bonus for attach vk and telegram
        $bonus_html = '';
        if($player) {
            if(!$player->telegramAccount) $bonus_html .= View::make('bonus::social.telegram');
            if(!$player->vkAccount) $bonus_html .= View::make('bonus::social.vk');
        }

        // Banners
        $banners = app(GetActiveBannersTask::class)->run();
        $top_banners_html = [];
        $left_banners_html = [];
        $right_banners_html = [];

        foreach ($banners as $banner) {
            switch ($banner->type) {
                case Banner::TOP_TYPE:
                    $top_banners_html[] = View::make('banner::banner', ['banner' => $banner]);
                    break;
                case Banner::LEFT_TYPE:
                    $left_banners_html[]= View::make('banner::banner', ['banner' => $banner]);
                    break;
                case Banner::RIGHT_TYPE:
                    $right_banners_html[] = View::make('banner::banner', ['banner' => $banner]);
                    break;
            }
        }

        // Categories sites
        $site_categories = app(GetActiveSiteCategoriesTask::class)->run();
        $site_categories_json = SiteCategoryResource::collection($site_categories)->toJson();

        $params = [
            'bonus_html' => $bonus_html,
            'top_banners_html' => $top_banners_html,
            'left_banners_html' => $left_banners_html,
            'right_banners_html' => $right_banners_html,
            
            'box_timer_json' => $box_timer_json ?? null,
            'box_promocode_json' => $box_promocode_json ?? null,
            'contests_json' => $contests_json,
            'site_categories_json' => $site_categories_json,
            'settings_site' => $settings_site,
        ];
        return View::make("pages::pages.bonuses.index")->with($params)->render();
    }
}
