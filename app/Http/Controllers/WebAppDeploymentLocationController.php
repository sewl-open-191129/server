<?php
/**
 * Created by PhpStorm.
 * User: bz302
 * Date: 2018/8/28
 * Time: 10:18
 */

/**
 * {
    app_name
 *  longitude
 *  latitude
 *  radius_m
 *  launch_params_json
 *  display_name
 * }
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PharData;

class WebAppDeploymentLocationController extends Controller {
    public function deploy(Request $request) {
        \DB::beginTransaction();

        $app = \App\WebApp::whereName($request->app_name)->first();
        if(!$app) {
            $successful = false;
            $info = 'App not found, please check the app name.';
            return compact('successful', 'info');
        }

        $web_app_id=$app->id;
        $app_location = new \App\WebAppDeploymentLocation();
        $app_location->web_app_id = $web_app_id;
        $app_location->latitude = $request->latitude;
        $app_location->longitude = $request->longitude;
        $app_location->radius_m = $request->radius_m;
        $app_location->launch_params_json = $request->launch_params_json;
        $app_location->display_name = $request->display_name;
        $app_location->save();


        $test_data = \App\WebAppDeploymentLocation::whereWebAppId($web_app_id)->get();
        \DB::commit();
        $successful = true;
        return compact('successful', 'app', 'test_data');
    }

    public function withdraw(Request $request) {
        $deployment_id = $request->deployment_id;

        \DB::beginTransaction();

        $deployment = \App\WebAppDeploymentLocation::whereId($deployment_id)->first();

        if(!$deployment) {
            $successful = false;
            $info = 'Deployment does not exist.';
            return compact('successful', 'info');
        }

        $deployment->delete();

        \DB::commit();

        $successful = true;
        return compact('successful');
    }
}