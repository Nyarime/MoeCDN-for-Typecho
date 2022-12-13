<?php
if(!defined("__TYPECHO_ROOT_DIR__")) exit;

/**
* MoeCDN for Typecho
* 
* @package MoeCDN
* @author Nyarime
* @version 1.0
* @link https://idc.moe
*/
class MoeCDN_Plugin implements Typecho_Plugin_Interface
{
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常。
	 * 
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Abstract_Comments')->gravatar = array('MoeCDN_Plugin', 'gravatar');
		Typecho_Plugin::factory('Widget_Archive')->beforeRender = array('MoeCDN_Plugin', 'gapis');
	}

	/**
	* 禁用插件方法,如果禁用失败,直接抛出异常。
	* 
	* @static
	* @access public
	* @return void
	* @throws Typecho_Plugin_Exception
	*/
	public static function deactivate(){}

	/**
	* 获取插件配置面板
	* 
	* @access public
	* @param Typecho_Widget_Helper_Form $form 配置面板
	* @return void
	*/
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$gravatar =  new Typecho_Widget_Helper_Form_Element_Radio('gravatar' , array('1'=>_t('开启'),'0'=>_t('关闭')),'1',_t('Gravatar 头像加速'),_t('会帮您把默认的 Gravatar 源替换到 MoeCDN 源。'));
		$form->addInput($gravatar);
		$gapi =  new Typecho_Widget_Helper_Form_Element_Radio('gapi' , array('1'=>_t('开启'),'0'=>_t('关闭')),'1',_t('Google API 加速'),_t('使用谷歌公共库可以加快网页加载速度，由于国内特殊原因一直复发正常加载。'));
		$form->addInput($gapi);		
	}

	/**
	* 个人用户的配置面板，对于本插件来说，还是没有什么卵用。
	* 
	* @access public
	* @param Typecho_Widget_Helper_Form $form
	* @return void
	*/
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}

	/**
	 * 使用 MoeCDN 提供的 Gravatar 服务替换：接口模式。
	 * 此模式会接管 Widget_Abstract_Comments 类输出评论的接口以获得最佳兼容性，参见 issues #1
	 * 
	 * @param  int $size
	 * @param  string $rating
	 * @param  int $default
	 * @param  object $widget
	 * @return void 
	 */
	public static function gravatar($size, $rating, $default, $widget) 
	{
		$gravatarOption = Typecho_Widget::widget('Widget_Options')->Plugin('MoeCDN')->gravatar;
		if ($gravatarOption == 1) {
			$url = $widget->request->isSecure() ? 'https://gravatar.idc.moe/avatar/' : 'http://gravatar.idc.moe/avatar/';
		}
		if(!empty($widget->mail))
			$url .= md5(strtolower(trim($widget->mail)));
		$url .= '?s=' . $size;
		$url .= '&amp;r=' . $rating;
		$url .= '&amp;d=' . $default;
		echo '<img class="avatar" src="' . $url . '" alt="' .
		$widget->author . '" width="' . $size . '" height="' . $size . '" />';
	}

	/**
	 * 替换 Google APIs
	 * 
	 * @param  object $archive
	 * @return void
	 */
	public static function gapis($archive)
	{
		if(Typecho_Widget::widget('Widget_Options')->Plugin('MoeCDN')->gapi == 1)
			ob_start(array(__CLASS__, "moecdn_google_api_buffer"));
	}

	/**
	 * 在 Typecho 全局中自由调用头像，适用范围参考 issues #3
	 * 
	* @param object $widget
	* @param string $mail
	* @return void
	 */
	public static function getavatar($widget, $mail = NULL, $size = 40, $rating = 'X', $default = NULL, $class = NULL)
	{
		$mail = empty($mail) ? $widget->author->mail : $mail;
		echo '<img' . (empty($class) ? '' : ' class="' . $class . '"') . ' src="//gravatar.idc.moe/avatar/' .
		md5($mail) . '?s=' . $size . '&amp;r=' . $rating . '&amp;d=' . $default . '" alt="' .
		$widget->author->screenName . '" width="' . $size . '" height="' . $size . '" />';
	}

	/**
	 * moecdn_google_api_buffer
	 * 
	 * @param  string $html
	 * @return void
	 */
	private static function moecdn_google_api_buffer($html)
	{
		$html = str_replace("//fonts.googleapis.com",  "//fonts.googleapis.cn", $html);
		$html = str_replace("//ajax.googleapis.com",  "//ajax.idc.moe", $html);
		return $html;
	}
}
