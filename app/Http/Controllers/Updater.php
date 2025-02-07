<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use Artisan;

//database migration
use DB;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class Updater extends Controller
{
    public function update(Request $request)
    {
        $addons_parent_id = null;

        $rules = array('file' => 'required|file|mimes:zip');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error', get_phrase('Select a valid zip file'));
        }

        //Create update directory
        $dir = 'upload';
        if (!is_dir($dir) && !file_exists($dir)) {

            mkdir($dir, 0777, true);
        }

        //Uploaded file name
        $file_name = $request->file->getClientOriginalName();
        $path = $dir . '/' . $file_name;

        if (class_exists('ZipArchive')) {
            //File uploading..
            FileUploader::upload($request->file, '../'.$path);

            // Unzip uploaded update file and remove zip file.
            $zip = new ZipArchive;
            $res = $zip->open(base_path($path));
            $zip->extractTo(base_path($dir));
            $zip->close();
            unlink(base_path($path));
        } else {
            return redirect()->back()->with('error', get_phrase('Your server is unable to extract the zip file') . '. ' . get_phrase('Please enable the zip extension to the server, then try again'));
        }

        $uploaded_folder_name = substr($file_name, 0, -4);
        $version_ = substr($file_name, 0, -4);

        // Exicute php or laravel's code
        $step1Exicution = file_get_contents(base_path($dir . '/' . $uploaded_folder_name . '/step1_pre_checker.php'));
        if ($step1Exicution) {
            eval($step1Exicution);
        }

        //check required version
        $product_current_version = DB::table('settings')->where('type', 'version')->value('description');
        
        $config = file_get_contents(base_path($dir . '/' . $uploaded_folder_name . '/step2_config.json'));
        if ($config) {
            $config = json_decode($config, true);
        }

        //check ias addon or main product update
        if (array_key_exists('is_addon', $config) && strval($config['is_addon']) == "1") {

            //check required main product version to install this addon
            if ($config['product_version']['minimum_required_version'] > $product_current_version) {
                return redirect()->back()->with('error', get_phrase("You have to update your main application's version.") . '(' . $config['product_version']['minimum_required_version'] . ') ' . get_phrase(' to install the addon'));
            }

            $addons_current_version = DB::table('addons')->where('unique_identifier', $config['addons'][0]['unique_identifier']);
            if ($addons_current_version->get()->count() > 0) {
                $addons_current_version = $addons_current_version->value('version');
            } else {
                $addons_current_version = "0";
            }

            //check required addon version to update this addon
            if (strval($config['addon_version']['minimum_required_version']) != strval($addons_current_version)) {
                return redirect()->back()->with('error', get_phrase('It looks like you are skipping a version') . '. ' . get_phrase('Please update version') . ' ' . $config['addon_version']['minimum_required_version'] . ' ' . get_phrase('first'));
            }

            foreach ($config['addons'] as $addon) {
                $data['unique_identifier'] = $addon['unique_identifier'];
                $data['title'] = $addon['title'];
                $data['version'] = $config['addon_version']['update_version'];
                $data['features'] = $addon['features'];
                $data['status'] = 1;
                $data['parent_id'] = $addons_parent_id;

                $parent_id = DB::table('addons')->insertGetId($data);

                if ($addons_parent_id == null) {
                    $addons_parent_id = $parent_id;
                }
            }
        } else {
            //check required main product version
            if (strval($config['product_version']['minimum_required_version']) != strval($product_current_version)) {
                return redirect()->back()->with('error', get_phrase('It looks like you are skipping a version') . '. ' . get_phrase('Please update version') . ' ' . $config['product_version']['minimum_required_version'] . ' ' . get_phrase('first'));
            }
        }

        //Update files, folders and libraries
        $this->fileAndFolderDistributor($uploaded_folder_name);

        //run SQL file
        $sql = file_get_contents(base_path($dir . '/' . $uploaded_folder_name . '/step3_database.sql'));
        if ($sql) {
            DB::unprepared($sql);
        }

        // Exicute php or laravel's code
        $step4Exicution = file_get_contents(base_path($dir . '/' . $uploaded_folder_name . '/step4_update_data.php'));
        if ($step4Exicution) {
            eval($step4Exicution);
        }

        if (array_key_exists('is_addon', $config) && strval($config['is_addon']) == "1") {
            if ($config['addon_version']['minimum_required_version'] == "0") {
                return redirect()->back()->with('success', get_phrase('Addon installed successfully'));
            } else {
                return redirect()->back()->with('success', get_phrase('Addon updated successfully'));
            }
        } else {
            DB::table('settings')->where('type', 'version')->update(['description' => $config['product_version']['update_version']]);
            return redirect()->back()->with('success', get_phrase('Version updated successfully'));
        }
    }

    public function fileAndFolderDistributor($param1, $param2 = "")
    {
        if ($param2 == "") {
            $param2 = $param1;
            $uploaded_dir_path = base_path('upload/' . $param1 . '/sources');
        } else {
            $uploaded_dir_path = $param1;
        }

        $uploaded_dir_paths = glob($uploaded_dir_path . '/*');

        foreach ($uploaded_dir_paths as $uploaded_sub_dir_path) {

            if (is_dir($uploaded_sub_dir_path)) {

                $all_available_sub_paths = count(glob($uploaded_sub_dir_path . '/*'));

                if ($all_available_sub_paths == 0) {
                    //Create directory
                    $application_dir_path = str_replace('upload/' . $param2 . '/sources/', "", $uploaded_sub_dir_path);
                    if (!is_dir($application_dir_path) && !file_exists($application_dir_path)) {
                        mkdir($application_dir_path, 0777, true);
                    }
                } else {
                    $this->fileAndFolderDistributor($uploaded_sub_dir_path, $param2);
                }
            } else {
                $application_file_path = str_replace('upload/' . $param2 . '/sources/', "", $uploaded_sub_dir_path);

                //Check dir. If not exist then created
                $file_path_arr = explode("/", $application_file_path);
                $file_name = $file_path_arr[count($file_path_arr) - 1];
                $application_dir_path = str_replace('/' . $file_name, "", $application_file_path);
                if (!is_dir($application_dir_path) && !file_exists($application_dir_path)) {

                    mkdir($application_dir_path, 0777, true);
                }

                //Copy file to application path
                copy($uploaded_sub_dir_path, $application_file_path);

                //Zip file extract for any big size libraries
                if (pathinfo($file_name, PATHINFO_EXTENSION) == 'zip') {
                    // PATH OF EXTRACTING LIBRARY FILE
                    array_pop($file_path_arr);
                    $extract_to = implode('/', $file_path_arr);
                    $library_zip = new ZipArchive;
                    $library_result = $library_zip->open($application_file_path);
                    $library_zip->extractTo($extract_to);
                    $library_zip->close();
                    unlink($application_file_path);
                }
            }
        }
    }
}
