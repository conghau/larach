<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 4:37 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use TCH\LaraXMenu;
use App\Http\Foundation;
use Carbon;

/**
 * Class BaseAdminController
 *
 * @package App\Http\Controllers\Admin
 */
class BaseAdminController extends Controller {

    use Foundation\FlashMessage;
    protected $menuRepository;
    protected $adminPath;
    protected $routeLink;
    protected $defaultLanguageId;
    protected $bodyClass;
    protected $currentMenuActive;
    protected $data = [];
    protected $defaultSkin = 'default';
    protected $settingRepository;

    public function __construct($currentMenuActive = 'dashboard') {
        $this->adminPath = Config::get('app.admin_path');
        $this->currentMenuActive = $currentMenuActive;
        $this->bodyClass = '';
        $this->loadAdminMenu($currentMenuActive);
        $this->setSettingRepository(app(SettingRepositoryInterface::class));

        if (!Session::has('default_skin')) {
            $this->defaultSkin = $this->getSettingConfig('default_skin', 'default');
            Session::set('default_skin', $this->defaultSkin);
        }
        else {
            $this->defaultSkin = Session::get('default_skin', 'default');
        }


        view()->share([
            'adminPath' => $this->adminPath,
            'defaultLanguageId' => 1,
            'defaultSkin' => $this->defaultSkin,
        ]);
    }

    protected function initVariable() {
        $this->adminPath = Config::get('app.admin_path');
        $this->defaultLanguageId = 1;
        $this->bodyClass = '';
        $this->currentMenuActive = 'Dashboard';
    }


    /**
     * Set current menu active
     *
     * @param string $menuClassActive
     *
     * @return string
     */
    protected function setCurrentMenuActive($menuClassActive = '') {
        return $this->currentMenuActive = $menuClassActive;
    }

    /**
     * Set custom body class
     *
     * @param string $class
     *
     * @return string
     */
    protected function setBodyClass($class = '') {
        return $this->bodyClass = $class;
    }

    /**
     * Set page title
     *
     * @param $title
     * @param string $subTitle
     */
    protected function setPageTitle($title, $subTitle = '') {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }

    /**
     * Set menu Repository
     *
     * @param MenuRepositoryInterface $_menuRepository
     *
     * @return MenuRepositoryInterface
     */
    protected function setMenuRepository(MenuRepositoryInterface $_menuRepository) {
        return $this->menuRepository = $_menuRepository;
    }

    protected function setSettingRepository(SettingRepositoryInterface $settingRepository) {
        return $this->settingRepository = $settingRepository;
    }

    protected function getSettingConfig($key, $default_value = '') {
        $result = $this->settingRepository->getSetting($key);
        if (laraX_isNullOrEmpty($result)) {
            return $default_value;
        }
        return $result;
    }

    /**
     * Load admin menu
     *
     * @param string $menuActive
     */
    protected function loadAdminMenu($menuActive = '') {
        $menu = app(LaraXMenu::class);
        $menu->setArgs([
                'languageId' => 1,
                'menuName' => 'admin-menu',
                'menuClass' => 'page-sidebar-menu page-header-fixed',
                'container' => 'div',
                'containerClass' => 'page-sidebar navbar-collapse collapse',
                'containerId' => '',
                'containerTag' => 'ul',
                'childTag' => 'li',
                'itemHasChildrenClass' => 'menu-item-has-children',
                'subMenuClass' => 'sub-menu',
                'menuActive' => [
                    'type' => 'custom-link',
                    'related_id' => $menuActive,
                ],
                'activeClass' => 'active',
                'isAdminMenu' => TRUE,
            ]);

        $expiresAt = Carbon::now()->addMinutes(30);
        if (Cache::has('cache_admin_menu')) {
            $data = Cache::get('cache_admin_menu');;
        }
        else {
            $data = $menu->getNavMenu1();
            Cache::put('cache_admin_menu', $data, $expiresAt);
        }
        $data = $menu->getNavMenu1();
        view()->share('CMSMenuHtml', $data);
    }

    /**
     * Build condition
     *
     * @param $request
     * @param array $target_eq_filters
     * @param array $target_like_filters
     *
     * @return array $conditions
     */
    protected function buildCondition($request, array $target_eq_filters = [], array $target_like_filters = []) {
        $conditions = [];
        foreach ($target_like_filters as $like_filter) {
            if ($fv = laraX_get_value($request, $like_filter, FALSE)) {
                $conditions[] = [$like_filter, 'LIKE', "%$fv%"];
            }
        };
        foreach ($target_eq_filters as $eq_filter) {
            if ($fv = laraX_get_value($request, $eq_filter, FALSE)) {
                $conditions[] = [$eq_filter, '=', $fv];
            }
        };
        return $conditions;
    }

    /**
     * Build order b
     *
     * @param $request
     * @param array $target_orderBy
     * @return array
     */
    protected function buildOrderBy($request, array $target_orderBy = []) {
        $order_by = [];
        //build order by
        foreach ($items = laraX_get_value($request, 'order', []) as $item) {
            $order_by[array_key_exists($item['column'], $target_orderBy) ? $target_orderBy[$item['column']] : 'created_at'] = $item['dir'];
        };
        return $order_by;
    }
}