<?php

/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 10:34
 */
class Common
{
    private $sIp;
    private $sBrowser;
    private $sLastPage;
    private $sContinent;
    private $sCountry;
    private $sProvince;
    private $sCity;
    private $sLatitude;
    private $sLongitude;

    private $cUrl;
    private $cAppCodeName;
    private $cAppName;
    private $cAppVersion;
    private $cLanguage;
    private $cPlatform;
    private $cOSCPU;
    private $cVendor;
    private $cVendorSub;
    private $cProductSub;
    private $cUserAgent;
    private $cLastPage;
    private $cBuildId;
    private $cDoNotTrack;
    private $cJsActive;
    private $cJavaActive;
    private $cCssActive;
    private $cCookiesActive;

    public function __construct(
        $cAppCodeName, $cAppName, $cAppVersion, $cBuildId, $cCssActive, $cCookiesActive, $cDoNotTrack, $cJavaActive,
        $cJsActive, $cLanguage, $cLastPage, $cOSCPU, $cPlatform, $cProductSub, $cUrl, $cUserAgent, $cVendor, $cVendorSub)
    {
        $this->cUrl = $cUrl;
        $this->cAppCodeName = $cAppCodeName;
        $this->cAppName = $cAppName;
        $this->cAppVersion = $cAppVersion;
        $this->cLanguage = $cLanguage;
        $this->cPlatform = $cPlatform;
        $this->cOSCPU = $cOSCPU;
        $this->cVendor = $cVendor;
        $this->cVendorSub = $cVendorSub;
        $this->cProductSub = $cProductSub;
        $this->cUserAgent = $cUserAgent;
        $this->cLastPage = $cLastPage;
        $this->cBuildId = $cBuildId;
        $this->cDoNotTrack = $cDoNotTrack;
        $this->cJsActive = $cJsActive;
        $this->cJavaActive = $cJavaActive;
        $this->cCssActive = $cCssActive;
        $this->cCookiesActive = $cCookiesActive;
    }

    public function getSIp()
    {
        return $this->sIp;
    }

    public function setSIp($sIp)
    {
        $this->sIp = $sIp;
    }

    public
    function getSBrowser()
    {
        return $this->sBrowser;
    }

    public
    function setSBrowser($sBrowser)
    {
        $this->sBrowser = $sBrowser;
    }

    public
    function getSLastPage()
    {
        return $this->sLastPage;
    }

    public
    function setSLastPage($sLastPage)
    {
        $this->sLastPage = $sLastPage;
    }

    public
    function getSContinent()
    {
        return $this->sContinent;
    }

    public
    function setSContinent($sContinent)
    {
        $this->sContinent = $sContinent;
    }

    public
    function getSCountry()
    {
        return $this->sCountry;
    }

    public
    function setSCountry($sCountry)
    {
        $this->sCountry = $sCountry;
    }

    public
    function getSProvince()
    {
        return $this->sProvince;
    }

    public
    function setSProvince($sProvince)
    {
        $this->sProvince = $sProvince;
    }

    public
    function getSCity()
    {
        return $this->sCity;
    }

    public
    function setSCity($sCity)
    {
        $this->sCity = $sCity;
    }

    public
    function getSLatitude()
    {
        return $this->sLatitude;
    }

    public
    function setSLatitude($sLatitude)
    {
        $this->sLatitude = $sLatitude;
    }

    public
    function getSLongitude()
    {
        return $this->sLongitude;
    }

    public
    function setSLongitude($sLongitude)
    {
        $this->sLongitude = $sLongitude;
    }

    public
    function getCUrl()
    {
        return $this->cUrl;
    }

    public
    function setCUrl($cUrl)
    {
        $this->cUrl = $cUrl;
    }

    public
    function getCAppCodeName()
    {
        return $this->cAppCodeName;
    }

    public
    function setCAppCodeName($cAppCodeName)
    {
        $this->cAppCodeName = $cAppCodeName;
    }

    public
    function getCAppName()
    {
        return $this->cAppName;
    }

    public
    function setCAppName($cAppName)
    {
        $this->cAppName = $cAppName;
    }

    public
    function getCAppVersion()
    {
        return $this->cAppVersion;
    }

    public
    function setCAppVersion($cAppVersion)
    {
        $this->cAppVersion = $cAppVersion;
    }

    public
    function getCLanguage()
    {
        return $this->cLanguage;
    }

    public
    function setCLanguage($cLanguage)
    {
        $this->cLanguage = $cLanguage;
    }

    public
    function getCPlatform()
    {
        return $this->cPlatform;
    }

    public
    function setCPlatform($cPlatform)
    {
        $this->cPlatform = $cPlatform;
    }

    public
    function getCOSCPU()
    {
        return $this->cOSCPU;
    }

    public
    function setCOSCPU($cOSCPU)
    {
        $this->cOSCPU = $cOSCPU;
    }

    public
    function getCVendor()
    {
        return $this->cVendor;
    }

    public
    function setCVendor($cVendor)
    {
        $this->cVendor = $cVendor;
    }

    public
    function getCVendorSub()
    {
        return $this->cVendorSub;
    }

    public
    function setCVendorSub($cVendorSub)
    {
        $this->cVendorSub = $cVendorSub;
    }

    public
    function getCProductSub()
    {
        return $this->cProductSub;
    }

    public
    function setCProductSub($cProductSub)
    {
        $this->cProductSub = $cProductSub;
    }

    public
    function getCUserAgent()
    {
        return $this->cUserAgent;
    }

    public
    function setCUserAgent($cUserAgent)
    {
        $this->cUserAgent = $cUserAgent;
    }

    public
    function getCLastPage()
    {
        return $this->cLastPage;
    }

    public
    function setCLastPage($cLastPage)
    {
        $this->cLastPage = $cLastPage;
    }

    public
    function getCBuildId()
    {
        return $this->cBuildId;
    }

    public
    function setCBuildId($cBuildId)
    {
        $this->c = $cBuildId;
    }

    public
    function getCDoNotTrack()
    {
        return $this->cDoNotTrack;
    }

    public
    function setCDoNotTrack($cDoNotTrack)
    {
        $this->cDoNotTrack = $cDoNotTrack;
    }

    public
    function getCJsActive()
    {
        return $this->cJsActive;
    }

    public
    function setCJsActive($cJsActive)
    {
        $this->cJsActive = $cJsActive;
    }

    public
    function getCJavaActive()
    {
        return $this->cJavaActive;
    }

    public
    function setCJavaActive($cJavaActive)
    {
        $this->cJavaActive = $cJavaActive;
    }

    public
    function getCCssActive()
    {
        return $this->cCssActive;
    }

    public
    function setCCssActive($cCssActive)
    {
        $this->cCssActive = $cCssActive;
    }

    public
    function getCCookiesActive()
    {
        return $this->cCssActive;
    }

    public
    function setCCookiesActive($cCssActive)
    {
        $this->cCssActive = $cCssActive;
    }
}