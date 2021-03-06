<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Datepicker class
 *
 * Formatic field plugin
 *
 * Populate a select field dynamically via AJAX, based on the 
 *
 * @package		Formatic
 * @license 	MIT Licence (http://opensource.org/licenses/mit-license.php) 
 * @author  	Mark Croxton
 * @copyright  	Mark Croxton, hallmarkdesign (http://www.hallmark-design.co.uk)
 * @version 	1.0.0
 */

class Datepicker extends Formatic_plugin {
	
	protected static $init = TRUE;
			
	/**
	 * Run
	 *
	 * @access	public
	 * @param	string	$f The field name
	 * @param	array	$param An array of parameters
	 * @return	string
	 */
	function run($f, $param)
	{
		$formatic =& $this->CI->formatic;	
		$js ='';
	
		$config = array_merge(
			$formatic->get_plugin_config('datepicker'), 
			$formatic->get_field_config($f)
		);
		
		// create a standard text input
		$data = array(
						'name'        => $f,
              			'id'          => $config['id'],
              			'value'       => set_value($f, isset($_POST[$f]) ? $_POST[$f] : $config['default'])
					);			
		$data = isset($config['attr']) ? $data + $config['attr'] : $data;
		$r = call_user_func('form_input', $data);
		
		$config['startDate'] 		= isset($config['startDate']) 		? $config['startDate'] 		: '01/01/1750';
		$config['firstDayOfWeek']	= isset($config['firstDayOfWeek'])  ? $config['firstDayOfWeek'] : '0';
		$config['format']	 		= isset($config['format'])    		? $config['format']    		: 'dd/mm/yyyy';
		
		// add the js call
		$js = <<<JAVASCRIPT
		<script type="text/javascript">
		//<![CDATA[ 
			$(function() {
				Date.firstDayOfWeek = {$config['firstDayOfWeek']};
				Date.format = '{$config['format']}';
				$('#{$config['id']}').datePicker({
					startDate:'{$config['startDate']}'
				});
				$('.content-sidebar #{$config['id']}').dpSetPosition($.dpConst.POS_TOP, $.dpConst.POS_RIGHT);
			});
		//]]>
		</script>
JAVASCRIPT;

		return $r.$js;
	}
}