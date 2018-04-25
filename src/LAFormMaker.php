<?php
namespace Dwij\Laraadmin;

use Schema;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFieldTypes;

use App\Models\LanguageMeta;
use Gma\Api\LanguageTransportor;

class LAFormMaker
{
	/**
	* Print input field enclosed within form-group
	**/
	public static function input($module, $field_name, $default_val = null, $required2 = null, $class = 'form-control', $params = [])
	{
		// Check Field Write Aceess
		if(Module::hasFieldAccess($module->id, $module->fields[$field_name]['id'], $access_type = "write")) {
			
			$row = null;
			if(isset($module->row)) {
				$row = $module->row;
			}

			$lang = LanguageTransportor::getFromAndLang();
			if(!empty($lang)) {
				$lang_data = $lang;
			}
			//get lang
			//$lang_data = property_exists($module, "lang") ? $module->lang : "" ;

			//print_r($module->fields);
			$label = $module->fields[$field_name]['label'];
			$field_type = $module->fields[$field_name]['field_type'];
			$unique = $module->fields[$field_name]['unique'];
			$defaultvalue = $module->fields[$field_name]['defaultvalue'];
			$minlength = $module->fields[$field_name]['minlength'];
			$maxlength = $module->fields[$field_name]['maxlength'];
			$required = $module->fields[$field_name]['required'];
			$popup_vals = $module->fields[$field_name]['popup_vals'];
			$filter_expressions = $module->fields[$field_name]['filter_expressions'];

			
			if($required2 != null) {
				$required = $required2;
			}
			
			$field_type = ModuleFieldTypes::find($field_type);
			
			$out = '<div class="form-group"><div class="fg-line">';
			$required_ast = "";
			
			if(!isset($params['class'])) {
				$params['class'] = $class;
			}
			if(!isset($params['placeholder'])) {
				$params['placeholder'] = 'Enter '.$label;
			}
			if($minlength) {
				$params['data-rule-minlength'] = $minlength;
			}
			if($maxlength) {
				$params['data-rule-maxlength'] = $maxlength;
			}
			if($unique && !isset($params['unique'])) {
				$params['data-rule-unique'] = "true";
				$params['field_id'] = $module->fields[$field_name]['id'];
				$params['adminRoute'] = config('laraadmin.adminRoute');
				if(isset($row)) {
					$params['isEdit'] = true;
					$params['row_id'] = $row->id;
				} else {
					$params['isEdit'] = false;
					$params['row_id'] = 0;
				}
				$out .= '<input type="hidden" name="_token_'.$module->fields[$field_name]['id'].'" value="'.csrf_token().'">';
			}
			
			if($required && !isset($params['required'])) {
				$params['required'] = $required;
				$required_ast = "*";
			}
			
			
			switch ($field_type->name) {
				case 'Address':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					// $params['cols'] = 30;
					$params['rows'] = 1;
					$params['class'] = 'form-control auto-size';

					$out .= Form::textarea($field_name, $default_val, $params);
					break;
				case 'Checkbox':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					$out .= '<input type="hidden" value="false" name="'.$field_name.'_hidden">';
					
					// ############### Remaining
					unset($params['placeholder']);
					unset($params['data-rule-maxlength']);
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$out .= Form::checkbox($field_name, $field_name, $default_val, $params);
					$out .= '<div class="Switch Round On" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>';
					break;
				case 'Currency':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					unset($params['data-rule-maxlength']);
					$params['data-rule-currency'] = "true";
					$params['min'] = "0";
					$out .= Form::number($field_name, $default_val, $params);
					break;
				case 'Date':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					$dval = $default_val;
					if($default_val != "") {
						$dval = date("d/m/Y", strtotime($default_val));
					}
					
					unset($params['data-rule-maxlength']);
					// $params['data-rule-date'] = "true";
					
					$out .= "<div class='input-group dtp-container date'>";
					
					$params['class'] = 'form-control date-picker';
					$out .= Form::text($field_name, $dval, $params);
					

					$out .= "<span class='input-group-addon'><span class='fa fa-calendar'></span></span></div>";
					// $out .= Form::date($field_name, $default_val, $params);
					break;
				case 'Datetime':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					// ############### Remaining
					$dval = $default_val;
					if($default_val != "") {
						$dval = date("d/m/Y h:i A", strtotime($default_val));
					}
					$out .= "<div class='input-group dtp-container datetime'>";
					$params['class'] = 'form-control date-time-picker';
					$out .= Form::text($field_name, $dval, $params);
					$out .= "<span class='input-group-addon'><span class='fa fa-calendar'></span></span></div>";
					break;
				case 'Decimal':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					unset($params['data-rule-maxlength']);
					$out .= Form::number($field_name, $default_val, $params);
					break;
				case 'Dropdown':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					$out .= '<div class="select">';
					unset($params['data-rule-maxlength']);
					$params['data-placeholder'] = $params['placeholder'];
					unset($params['placeholder']);
					$params['rel'] = "select2";
					
					//echo $defaultvalue;
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$tmp_popup_vals = $popup_vals;
					
					if($popup_vals != "") {
						
						$popup_vals = LAFormMaker::process_values($popup_vals, $lang_data, $filter_expressions );
						// echo "<pre>";
						// var_dump($module);
						if(!empty($default_val)){
							if(!empty($lang['curr_from'])){
								$currFrom = $lang['curr_from'];
								$mapData = LAFormMaker::mapDataDropdown($tmp_popup_vals, $lang_data['lang'], 
																		$module->model,$currFrom, $field_name);
								//fix: if don't have on metadata language
								if ($mapData != false) {
									$default_val = $mapData;
								}
							}
						}
					} else {
						$popup_vals = array();
					}

					$out .= Form::select($field_name, $popup_vals, $default_val, $params);
					$out .= '</div>';
					break;
				case 'Email':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$params['data-rule-email'] = "true";
					$out .= Form::email($field_name, $default_val, $params);
					break;
				case 'File':
					$out .= '<label for="'.$field_name.'" style="display:block;">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					if(!is_numeric($default_val)) {
						$default_val = 0;
					}
					$out .= Form::hidden($field_name, $default_val, $params);

					if($default_val != 0) {
						$upload = \App\Models\Upload::find($default_val);
					}
					if(isset($upload->id)) {
						$out .= "<a class='btn btn-default btn_upload_file hide' file_type='file' selecter='".$field_name."'>Upload <i class='fa fa-cloud-upload'></i></a>
							<a class='uploaded_file' target='_blank' href='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name)."'><i class='fa fa-file-o'></i><i title='Remove File' class='fa fa-times'></i></a>";
					} else {
						$out .= "<a class='btn btn-default btn_upload_file' file_type='file' selecter='".$field_name."'>Upload <i class='fa fa-cloud-upload'></i></a>
							<a class='uploaded_file hide' target='_blank'><i class='fa fa-file-o'></i><i title='Remove File' class='fa fa-times'></i></a>";
					}
					break;

				case 'Files':
					$out .= '<label for="'.$field_name.'" style="display:block;">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					if(is_array($default_val)) {
						$default_val = json_encode($default_val);
					}
					
					$default_val_arr = json_decode($default_val);
					
					if(is_array($default_val_arr) && count($default_val_arr) > 0) {
						$uploadIds = array();
						$uploadImages = "";
						foreach ($default_val_arr as $uploadId) {
							$upload = \App\Models\Upload::find($uploadId);
							if(isset($upload->id)) {
								$uploadIds[] = $upload->id;
								$fileImage = "";
								if(in_array(strtolower($upload->extension), ["jpg", "png", "gif", "jpeg"])) {
									$fileImage = "<img src='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name."?s=90")."'>";
								} else {
									$fileImage = "<i class='fa fa-file-o'></i>";
								}
								$uploadImages .= "<a class='uploaded_file2' upload_id='".$upload->id."' target='_blank' href='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name)."'>".$fileImage."<i title='Remove File' class='fa fa-times'></i></a>";
							}
						}
						
						$out .= Form::hidden($field_name, json_encode($uploadIds), $params);
						if(count($uploadIds) > 0) {
							$out .= "<div class='uploaded_files'>".$uploadImages."</div>";
						}
					} else {
						$out .= Form::hidden($field_name, "[]", $params);
						$out .= "<div class='uploaded_files'></div>";
					}
					$out .= "<a class='btn btn-default btn_upload_files' file_type='files' selecter='".$field_name."' style='margin-top:5px;'>Upload <i class='fa fa-cloud-upload'></i></a>";
					break;

				case 'Float':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					unset($params['data-rule-maxlength']);
					$out .= Form::number($field_name, $default_val, $params);
					break;
				case 'HTML':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					// ############### Remaining
					$out .= '<div class="htmlbox" id="htmlbox_'.$field_name.'" contenteditable>'.$default_val.'</div>';
					$out .= Form::hidden($field_name, $default_val, $params);
					break;
				case 'Image':
					$out .= '<label for="'.$field_name.'" style="display:block;">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					if(!is_numeric($default_val)) {
						$default_val = 0;
					}
					$out .= Form::hidden($field_name, $default_val, $params);

					if($default_val != 0) {
						$upload = \App\Models\Upload::find($default_val);
					}
					if(isset($upload->id)) {
						$out .= "<a class='btn btn-default btn_upload_image hide' file_type='image' selecter='".$field_name."'>Upload <i class='fa fa-cloud-upload'></i></a>
							<div class='uploaded_image'><img src='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name."?s=150")."'><i title='Remove Image' class='fa fa-times'></i></div>";
					} else {
						$out .= "<a class='btn btn-default btn_upload_image' file_type='image' selecter='".$field_name."'>Upload <i class='fa fa-cloud-upload'></i></a>
							<div class='uploaded_image hide'><img src=''><i title='Remove Image' class='fa fa-times'></i></div>";
					}
					
					break;
				case 'Integer':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					unset($params['data-rule-maxlength']);
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					// $params['min'] = "0"; // Required for Non-negative numbers
					$out .= Form::number($field_name, $default_val, $params);
					break;
				case 'Mobile':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$out .= Form::text($field_name, $default_val, $params);
					break;
				case 'Multiselect':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					unset($params['data-rule-maxlength']);
					$params['data-placeholder'] = "Select multiple ".str_plural($label);
					unset($params['placeholder']);
					$params['multiple'] = "true";
					$params['rel'] = "select2";
					if($default_val == null) {
						if($defaultvalue != "") {
							$default_val = json_decode($defaultvalue);
						} else {
							$default_val = "";
						}
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = json_decode($row->$field_name);
					}
					
					if($popup_vals != "") {
						$tmp_popup_vals = $popup_vals;

						$popup_vals = LAFormMaker::process_values($popup_vals, $lang_data, $filter_expressions);
				
						if(!empty($default_val)){
							if(!empty($lang['curr_from'])){
								$currFrom = $lang['curr_from'];
								$default_val = LAFormMaker::mapDataMultiSelect($tmp_popup_vals, $lang_data['lang'], 
																			$module->model,$currFrom, $field_name);
								
							}
						}
					} else {
						$popup_vals = array();
					}

					$out .= Form::select($field_name."[]", $popup_vals, $default_val, $params);
					break;
				case 'Name':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$out .= Form::text($field_name, $default_val, $params);
					break;
				case 'Password':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					$out .= Form::password($field_name, $params);
					break;
				case 'Radio':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' : </label><br>';
					
					// ############### Remaining
					unset($params['placeholder']);
					unset($params['data-rule-maxlength']);
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					if(starts_with($popup_vals, "@")) {
						//LamLe -- add filter language_data
						$popup_vals = LAFormMaker::process_values($popup_vals,$lang_data, $filter_expressions);
						$out .= '<div class="">';
						foreach ($popup_vals as $key => $value) {
							$sel = false;
							if($default_val != "" && $default_val == $value) {
								$sel = true;
							}
							$out .= '<label class="radio radio-inline m-r-20">'.(Form::radio($field_name, $key, $sel)).' <i class="input-helper"></i> '.$value.' </label>';
						}
						$out .= '</div>';
						break;
					} else {
						if($popup_vals != "") {
							$popup_vals = array_values(json_decode($popup_vals));
						} else {
							$popup_vals = array();
						}
						$out .= '<div class="">';
						foreach ($popup_vals as $value) {
							$sel = false;
							if($default_val != "" && $default_val == $value) {
								$sel = true;
							}
							$out .= '<label class="radio radio-inline m-r-20">'.(Form::radio($field_name, $value, $sel)).' <i class="input-helper"></i> '.$value.' </label>';
						}
						$out .= '</div>';
						break;
					}
				case 'String':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					$out .= Form::text($field_name, $default_val, $params);
					break;
				case 'Taginput':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if(isset($params['data-rule-maxlength'])) {
						$params['maximumSelectionLength'] = $params['data-rule-maxlength'];
						unset($params['data-rule-maxlength']);
					}
					$params['multiple'] = "true";
					$params['rel'] = "taginput";
					$params['data-placeholder'] = "Add multiple ".str_plural($label);
					unset($params['placeholder']);
					
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = json_decode($row->$field_name);
					}
					
					if($default_val == null) {
						$defaultvalue2 = json_decode($defaultvalue);
						if(is_array($defaultvalue2)) {
							$default_val = $defaultvalue;
						} else if(is_string($defaultvalue)) {
							if (strpos($defaultvalue, ',') !== false) {
								$default_val = array_map('trim', explode(",", $defaultvalue));
							} else {
								$default_val = [$defaultvalue];
							}
						} else {
							$default_val = array();
						}
					}
					$default_val = LAFormMaker::process_values($default_val, $lang_data, $filter_expressions);
					$out .= Form::select($field_name."[]", $default_val, $default_val, $params);
					
					break;
				case 'Textarea':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					// $params['cols'] = 30;
					$params['rows'] = 1;
					$params['class'] = 'form-control auto-size';
					
					
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$out .= Form::textarea($field_name, $default_val, $params);
					break;
				case 'TextField':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$out .= Form::text($field_name, $default_val, $params);
					break;
				case 'URL':
					$out .= '<label for="'.$field_name.'">'.$label.$required_ast.' :</label>';
					
					if($default_val == null) {
						$default_val = $defaultvalue;
					}
					// Override the edit value
					if(isset($row) && isset($row->$field_name)) {
						$default_val = $row->$field_name;
					}
					
					$params['data-rule-url'] = "true";
					$out .= Form::text($field_name, $default_val, $params);
					break;
			}
			$out .= '</div></div>';
			return $out;
		} else {
			return "";
		}
	}
	
	public static function process_filter_expressions($filter_expressions = "") {

		$expression[] = explode("=",$filter_expressions);

		return  $expression;
	}
	/**
	* Processes the populated values for Multiselect / Taginput / Dropdown
	* get data from module / table whichever is found if starts with '@'
	**/
	// $values = LAFormMaker::process_values($data);
	public static function process_values($json, $lang_data=null, $filter_expressions = "") {
		$out = array();
		// Check if populated values are from Module or Database Table
		if(is_string($json) && starts_with($json, "@")) {
			
			// Get Module / Table Name
			$json = str_ireplace("@", "", $json);
			$table_name = strtolower(str_plural($json));
			$filter = self::process_filter_expressions($filter_expressions);

			// Search Module
			$module = Module::getByTable($table_name);
			if(isset($module->id)) {
				$out = Module::getDDArray($module->name, $lang_data, $filter);
			} else {
				// Search Table if no module found
				if (Schema::hasTable($table_name)) {
					$model = "App\\".ucfirst(str_singular($table_name));

					//LamLe - Filter language
					if ($lang_data != null) {
						$lang = $lang_data['lang'];
						$result = $model::where('lang', $lang);
						
						if (count($filter) > 0) {
							foreach ($filter as $ex) {
								if (count($ex) > 1) {
									$filterCol = trim($ex[0]);
									$filterValue = trim($ex[1]);
									$result = $result->where($filterCol, $filterValue);
								}
							}
						}
						
						$result = $result->get();
						
					} else {
						$result = $model::all();
					}
					

					//$result = $model::all();
					// find view column name
					$view_col = "";
					// Check if atleast one record exists
					if(isset($result[0])) {
						$view_col_test_1 = "name";
						$view_col_test_2 = "title";
						if(isset($result[0]->$view_col_test_1)) {
							// Check whether view column name == "name"
							$view_col = $view_col_test_1;
						} else if(isset($result[0]->$view_col_test_2)) {
							// Check whether view column name == "title"
							$view_col = $view_col_test_2;
						} else {
							// retrieve the second column name which comes after "id"
							$arr2 = $result[0]->toArray();
							$arr2 = array_keys($arr2);
							$view_col = $arr2[1];
							// if second column not exists
							if(!isset($result[0]->$view_col)) {
								$view_col = "";
							}
						}
						// If view column name found successfully through all above efforts
						if($view_col != "") {
							// retrieve rows of table
							foreach ($result as $row) {
								$out[$row->id] = $row->$view_col;
							}
						} else {
							// Failed to find view column name
						}
					} else {
						// Skipped efforts to detect view column name
					}
				} else if(Schema::hasTable($json)) {
					// $array = \DB::table($table_name)->get();
				}
			}
		} else if(is_string($json)) {
			$array = json_decode($json);
			if(is_array($array)) {
				foreach ($array as $value) {
					$out[$value] = $value;
				}
			} else {
				// TODO: Check posibility of comma based pop values.
			}
		} else if(is_array($json)) {
			foreach ($json as $value) {
				$out[$value] = $value;
			}
		}
		return $out;
	}
	
	/**
	* Display field using blade directive @la_display
	**/
	public static function display($module, $field_name, $class = 'form-control')
	{
		// Check Field View Aceess
		if(Module::hasFieldAccess($module->id, $module->fields[$field_name]['id'], $access_type = "view")) {
			
			$lang = LanguageTransportor::getFromAndLang();

			$fieldObj = $module->fields[$field_name];
			$label = $module->fields[$field_name]['label'];
			$field_type = $module->fields[$field_name]['field_type'];
			$filter_expressions = $module->fields[$field_name]['filter_expressions'];

			$field_type = ModuleFieldTypes::find($field_type);
			
			$row = null;
			if(isset($module->row)) {
				$row = $module->row;
				$lang["lang"] = $row->lang != "" ? $row->lang : $lang["lang"];
			}
			
			$out = '<div class="form-group">';
			$out .= '<label for="'.$field_name.'" class="col-md-2">'.$label.' :</label>';
			
			$value = $row->$field_name;
			
			switch ($field_type->name) {
				case 'Address':
					if($value != "") {
						$value = $value.'<a target="_blank" class="pull-right btn btn-xs btn-primary btn-circle" href="http://maps.google.com/?q='.$value.'" data-toggle="tooltip" data-placement="left" title="Check location on Map"><i class="fa fa-map-marker"></i></a>';
					}
					break;
				case 'Checkbox':
					if($value == 0) {
						$value = "<div class='label label-danger'>False</div>";
					} else {
						$value = "<div class='label label-success'>True</div>";
					}
					break;
				case 'Currency':
					
					break;
				case 'Date':
					if (!empty($value)) {
						$value = format_date($value);
					}
					
					//$dt = strtotime($value);
					//$value = date("d M Y", $dt);
					break;
				case 'Datetime':
					if (!empty($value)) {
						$dt = strtotime($value);
						$value = format_datetime($value);

						if ($field_name == 'start_time' || 
							$field_name == 'end_time') {
							$value = format_time($value);
						}
					}
					
					//$dt = strtotime($value);
					//$value = date("d M Y, h:i A", $dt);
					break;
				case 'Decimal':
					
					break;
				case 'Dropdown':
					if ($field_name == 'sex') {
						$value = format_sex_type ($value, true);
					} else {
						$values = LAFormMaker::process_values($fieldObj['popup_vals'], $lang, $filter_expressions);
						if(starts_with($fieldObj['popup_vals'], "@")) {
							if($value != 0) {
								$moduleVal = Module::getByTable(str_replace("@", "", $fieldObj['popup_vals']));

								$value_label = "";
								if (is_array($values) && array_key_exists($value, $values)) {
									$value_label = $values[$value];
								} else {
									$value_label = $value;
								}

								if(isset($moduleVal->id)) {
									$value = "<a href='".url(config("laraadmin.adminRoute")."/".$moduleVal->name_db."/".$value)."' class='label label-primary'>".$value_label."</a> ";
								} else {
									$value = "<a class='label label-primary'>".$value_label."</a> ";
								}
							} else {
								$value = "None";
							}
						}
					}
					
					break;
				case 'Email':
					$value = '<a href="mailto:'.$value.'">'.$value.'</a>';
					break;
				case 'File':
					if($value != 0) {
						$upload = \App\Models\Upload::find($value);
						if(isset($upload->id)) {
							$value = '<a class="preview" target="_blank" href="'.url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name).'">
							<span class="fa-stack fa-lg"><i class="fa fa-square fa-stack-2x"></i><i class="fa fa-file-o fa-stack-1x fa-inverse"></i></span> '.$upload->name.'</a>';
						} else {
							$value = 'Upload file not found.';
						}
					} else {
						$value = 'No file.';
					}
					break;
				case 'Files':
					if($value != "" && $value != "[]" && $value != "null" && starts_with($value, "[")) {
						$uploads = json_decode($value);
						$uploads_html = "";

						foreach ($uploads as $uploadId) {
							$upload = \App\Models\Upload::find($uploadId);
							if(isset($upload->id)) {
								$uploadIds[] = $upload->id;
								$fileImage = "";
								if(in_array(strtolower($upload->extension), ["jpg", "png", "gif", "jpeg"])) {
									$fileImage = "<img src='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name."?s=90")."'>";
								} else {
									$fileImage = "<i class='fa fa-file-o'></i>";
								}
								// $uploadImages .= "<a class='uploaded_file2' upload_id='".$upload->id."' target='_blank' href='".url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name)."'>".$fileImage."<i title='Remove File' class='fa fa-times'></i></a>";
								$uploads_html .= '<a class="preview" target="_blank" href="'.url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name).'" data-toggle="tooltip" data-placement="top" data-container="body" style="display:inline-block;margin-right:5px;" title="'.$upload->name.'">
										'.$fileImage.'</a>';
							}
						}
						$value = $uploads_html;
					} else {
						$value = 'No files found.';
					}
					break;
				case 'Float':
					
					break;
				case 'HTML':
					break;
				case 'Image':
					if($value != 0) {
						$upload = \App\Models\Upload::find($value);
					}
					if(isset($upload->id)) {
						$value = '<a class="preview" target="_blank" href="'.url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name).'"><img src="'.url("files/".$upload->hash.DIRECTORY_SEPARATOR.$upload->name."?s=150").'"></a>';
					} else {
						$value = 'Uplaoded image not found.';
					}
					break;
				case 'Integer':
					
					break;
				case 'Mobile':
					$value = '<a target="_blank" href="tel:'.$value.'">'.$value.'</a>';
					break;
				case 'Multiselect':
					$valueOut = "";
					$values = LAFormMaker::process_values($fieldObj['popup_vals'], $lang, $filter_expressions);
					if(is_array($value) && count($values)) {//fixbug null  on core
						if(starts_with($fieldObj['popup_vals'], "@")) {
							$moduleVal = Module::getByTable(str_replace("@", "", $fieldObj['popup_vals']));
							$valueSel = json_decode($value);

							foreach ($values as $key => $val) {
								if($valueSel != null && in_array($key, $valueSel)) {
									$valueOut .= "<a href='".url(config("laraadmin.adminRoute")."/".$moduleVal->name_db."/".$key)."' class='label label-primary'>".$val."</a> ";
								}
							}
						} else {
							$valueSel = json_decode($value);
							foreach ($values as $key => $val) {
								if(in_array($key, $valueSel)) {
									$valueOut .= "<span class='label label-primary'>".$val."</span> ";
								}
							}
						}
					}
					$value = $valueOut;
					break;
				case 'Name':
					
					break;
				case 'Password':
					$value = '<a href="#" data-toggle="tooltip" data-placement="top" data-container="body" title="Cannot be declassified !!!">********</a>';
					break;
				case 'Radio':
					
					break;
				case 'String':
					if ($field_name =='color' || $field_name == 'background_color' || $field_name == 'text_color') {
						$value = "<span class='label' style='background-color:".$value."'>".$value."</span> ";
					} 
					break;
				case 'Taginput':
					$valueOut = "";
					$values = LAFormMaker::process_values($fieldObj['popup_vals'], $lang, $filter_expressions);
					if(count($values)) {
						if(starts_with($fieldObj['popup_vals'], "@")) {
							$moduleVal = Module::getByTable(str_replace("@", "", $fieldObj['popup_vals']));
							$valueSel = json_decode($value);
							foreach ($values as $key => $val) {
								if(in_array($key, $valueSel)) {
									$valueOut .= "<a href='".url(config("laraadmin.adminRoute")."/".$moduleVal->name_db."/".$key)."' class='label label-primary'>".$val."</a> ";
								}
							}
						} else {
							$valueSel = json_decode($value);
							foreach ($valueSel as $key => $val) {
								$valueOut .= "<span class='label label-primary'>".$val."</span> ";
							}
						}
					} else {
						$valueSel = json_decode($value);
						foreach ($valueSel as $key => $val) {
							$valueOut .= "<span class='label label-primary'>".$val."</span> ";
						}
					}
					$value = $valueOut;
					break;
				case 'Textarea':
					
					break;
				case 'TextField':
					
					break;
				case 'URL':
					$value = '<a target="_blank" href="'.$value.'">'.$value.'</a>';
					break;
			}
			
			$out .= '<div class="col-md-10 fvalue">'.$value.'</div>';
			$out .= '</div>';
			return $out;
		} else {
			return "";
		}
	}
	
	/**
	* Print form using blade directive @la_form
	**/
	public static function form($module, $fields = [])
	{
		if(count($fields) == 0) {
			$fields = array_keys($module->fields);
		}
		$out = "";
		foreach ($fields as $field) {
			$out .= LAFormMaker::input($module, $field);
		}
		return $out;
	}
	
	/**
	* Check Whether User has Module Access
	**/
	public static function la_access($module_id, $access_type = "view", $user_id = 0)
	{
		return Module::hasAccess($module_id, $access_type, $user_id);
	}
	
	/**
	* Check Whether User has Module Field Access
	**/
	public static function la_field_access($module_id, $field_id, $access_type = "view", $user_id = 0)
	{
		return Module::hasFieldAccess($module_id, $field_id, $access_type, $user_id);
	}

	/**
	* Map Data Lang to other data lang.
	* get data from module / table whichever is found if starts with '@'
	* @param $value of fromLang.
	
	**/
	// $values = LAFormMaker::mapDataDropdown($data);
	public static function mapDataDropdown($json, $toLang, $parentModel, $parentValue, $fieldName) {

		$parentModel = "App\\Models\\".$parentModel;
		$parentData = $parentModel::where("_id", mongo_id($parentValue))->first();
		if(empty($parentData)) {
			return false;
		}
		$fieldValue = $parentData->$fieldName;

		// Check if populated values are from Module or Database Table
		if(is_string($json) && starts_with($json, "@")) {
			// Get Module / Table Name
			$json = str_ireplace("@", "", $json);
			$table_name = strtolower(str_plural($json));
			
			// Search Module
			$module = Module::getByTable($table_name);
			$model = "App\\Models\\".ucfirst(str_singular($table_name));

			$dataMeta = LanguageTransportor::getInfoLanguageMeta(['content_id'=>$fieldValue,
		                                           'reference' => $module->name]);
			if(empty($dataMeta)){
				return false;
			}

			$origin = $dataMeta->origin;
			$dataMetaes = LanguageTransportor::getInfoLanguageMetaFromOrigin(['origin' => $origin,
																			  'reference' => $module->name]);
			if(empty($dataMetaes)) {
				return false;
			}
			foreach($dataMetaes as $key => $value) {
				if($value->lang == $toLang) {
					return mongo_id_string($value->content_id);
				}
			}
			return false;
		}
	}

	/**
	* Map Data Lang to other data lang.
	* get data from module / table whichever is found if starts with '@'
	* @param $value of fromLang.
	
	**/
	// $values = LAFormMaker::mapDataMultiSelect($data);
	public static function mapDataMultiSelect($json, $toLang, $parentModel, $parentValue, $fieldName) {
		
		$parentModel = "App\\Models\\".$parentModel;

		$parentData = $parentModel::where("_id", mongo_id($parentValue))->first();
		if(empty($parentData)) {
			return [];
		}
		

		$fieldData = $parentData->$fieldName;

		// Check if populated values are from Module or Database Table
		if(is_string($json) && starts_with($json, "@")) {
			// Get Module / Table Name
			$json = str_ireplace("@", "", $json);
			$table_name = strtolower(str_plural($json));
			
			// Search Module
			$module = Module::getByTable($table_name);
			$model = "App\\Models\\".ucfirst(str_singular($table_name));

			$field_values = json_decode($fieldData);
			$map_values = [];

			if (!is_array($field_values)) {
				return [];
			}

			foreach($field_values as $key => $fieldValue) {
				$dataMeta = LanguageTransportor::getInfoLanguageMeta(['content_id'=>$fieldValue,
													'reference' => $module->name]);
								
				if(empty($dataMeta)){
					return [];
				}

				$origin = $dataMeta->origin;
				$dataMetaes = LanguageTransportor::getInfoLanguageMetaFromOrigin(['origin' => $origin,
																					'reference' => $module->name]);

				if(empty($dataMetaes)) {
					return [];
				}

				foreach($dataMetaes as $key => $value) {
					if($value->lang == $toLang) {
						$map_values[] = mongo_id_string($value->content_id);
					}
				}
			}

			if (count($map_values) > 0) {
				return  $map_values;
			}

			//dd($map_values);
			return [];
		}
	}

}