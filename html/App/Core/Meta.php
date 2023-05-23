<?php

namespace App\Core;

use App\Core\DotEnv;

class Meta
{
  protected $meta = array();

  public function __construct($args = array())
  {
    $this->meta = self::loadMeta();
    self::setMeta($args);
  }

  protected function loadMeta()
  {
    (new DotEnv(PATH_ENV . 'meta.env'))->load();


    $company_name = getenv('COMPANY_NAME');
    $company_description = getenv('COMPANY_DESCRIPTION');
    $company_keywords = getenv('COMPANY_KEYWORDS');
    $company_domain_name = getenv('COMPANY_DOMAIN_NAME');
    $company_url = getenv('COMPANY_URL');
    $company_img = getenv('COMPANY_IMG');

    $google_verification_code = getenv('GOOGLE_VERIFICATION_CODE');

    $twitter_handle = getenv('TWITTER_HANDLE');
    $twitter_domain = getenv('TWITTER_DOMAIN');

    $pintRest_verification_code = getenv('PINTREST_VERIFICATION_CODE');

    date_default_timezone_set('Europe/Brussels');

    $html_encoding = "UTF-8";
    $html_type = "website";

    $copy_right_years = '2000';
    $copy_right_years .= " - ";
    $copy_right_years .= date("Y");
    $copy_right_years .= " - ";

    $copy_right_link = $company_url;

    $scorpio = 'do we need this';

    return array(

      'scMetaLanguage'                =>    '', //gets modified by the requested controller
      'scMetaNamespace'               =>    '', //gets modified by the requested controller
      'scMetaController'              =>    '', //gets modified by the requested controller
      'scMetaAction'                  =>    '', //gets modified by the requested controller
      'scMetaPath'                    =>    '', //gets modified by the requested controller
      'scMetaCharset'                 =>    $html_encoding,
      'scMetaGoogleSiteVerification'  =>    $google_verification_code,
      'scMetaDescription'             =>    $company_description,
      'scMetaKeywords'                =>    $company_keywords,
      'scMetaCopyright'               =>    $company_name,
      'scMetaOgSiteName'              =>    $company_name,
      'scMetaOgUrl'                   =>    $company_url,
      'scMetaOgType'                  =>    $html_type,
      'scMetaOgTitle'                 =>    '', //gets modified by the requested controller
      'scMetaOgDescription'           =>    $company_description,
      'scMetaOgImage'                 =>    $company_img,
      'scTwitterSite'                 =>    $twitter_handle,
      'scTwitterDomain'               =>    $twitter_domain,
      'scPintRestKey'                 =>    $pintRest_verification_code,
      'scMetaScorpio'                 =>    $scorpio,
      'scMetaCopyYears'               =>    $copy_right_years,
      'scMetaCopyLink'                =>    $copy_right_link,
    );
  }

  protected function setMeta($args = array())
  {
    //IN here we set the different controller information

    $lang = isset($args['lang']) ? $args['lang'] : $this->meta['scMetaLanguage'];

    $this->meta['scMetaOgUrl'] = $this->meta['scMetaOgUrl'];
    $this->meta['scMetaOgUrl'] .= '/' . $lang;
    $this->meta['scMetaOgUrl'] .= '/' . $args['controller'];
    $this->meta['scMetaOgUrl'] .= '/' . $args['action'];

    $this->meta['scMetaRoute']  = strtolower($args['controller']);


    $this->meta['scPathCss']  .= strtolower($args['module']);
    $this->meta['scPathCss']  .= '/css/';
    $this->meta['scPathCss']  .= strtolower($args['controller']);

    $this->meta['scPathTempCss']  .= strtolower($args['module']);
    $this->meta['scPathTempCss']  .= '/css/';
    $this->meta['scPathTempCss']  .= strtolower($args['template']);

    $this->meta['scPathJs']  .= strtolower($args['module']);
    $this->meta['scPathJs']  .= '/js/';
    $this->meta['scPathJs']  .= strtolower($args['controller']);


    $this->meta['scPathTempJs']  .= strtolower($args['module']);
    $this->meta['scPathTempJs']  .= '/js/';
    $this->meta['scPathTempJs']  .= strtolower($args['template']);


    $this->meta['scMetaLanguage']       = $lang;
    $this->meta['scMetaNamespace']     = ucfirst($args['namespace']);
    $this->meta['scMetaController']     = ucfirst($args['controller']);
    $this->meta['scMetaAction']         = $args['action'];

    $this->meta['scMetaOgTitle']        = ucfirst($args['controller']);
    $this->meta['scMetaOgDescription']  .= ' ';
  }

  public function getMeta()
  {
    return $this->meta;
  }
}
