<?php
ssr2surge();

function ssr2surge(){
	$url = $_GET["url"];
	if ($url == "") { echo "请输入参数";return -1;}
	//echo $url;
	$hosts = get_ssr_hosts($url);
	get_general();
	get_proxy($hosts);
	get_proxy_group($hosts);
	get_rule();
	get_url_rewrite();
	get_host();
	get_mitm();
	return 0;
}

function get_proxy_group($hosts) {

        $i = 0;
        foreach ($hosts as $host) {
                $hostarr = explode(PHP_EOL,$host);
		//print_r ($hostarr);
		$prcloud[$i] = substr($hostarr[0],0,strpos($hostarr[0],"="));
		$i++;
        }
        $prstr = "";
        foreach ($prcloud as $tmp){
		if ($tmp == "") {break;}
		$prstr = $prstr.$tmp.",";
        }
        echo <<<eof

[Proxy Group]

eof;
        echo "prCloud = select,".$prstr;
	echo PHP_EOL;
	echo "Stream Services = select,prCloud,".$prstr;
        echo <<<eof

Apple Services = select,prCloud,DIRECT

eof;

}


function get_general () {
	echo <<<head
[General]
bypass-system = true
skip-proxy = 127.0.0.1,192.168.0.0/16,10.0.0.0/8,172.16.0.0/12,100.64.0.0/10,17.0.0.0/8,localhost,*.local,169.254.0.0/16,224.0.0.0/4,240.0.0.0/4
dns-server = 119.29.29.29, 119.28.28.28, 1.2.4.8, 1.1.1.1, 1.0.0.1, system
loglevel = notify
replica = false
ipv6 = true
show-error-page-for-reject = true
exclude-simple-hostnames = true
enhanced-mode-by-rule = false

head;
}
function get_proxy($hosts){
	echo <<<proxy

[Proxy]

proxy;
	foreach ($hosts as $host) {
		echo $host.PHP_EOL;
	}
}
function get_rule() {
	echo <<<rule
[Rule]

RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/Stream.list,Stream Services
RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/Anti-GFW+.list,prCloud
RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/Anti-GFW.list,prCloud
RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/Apple.list,Apple Services
RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/China.list,DIRECT
RULE-SET,https://cdn.rixcloud.io/surge/Rules-Set/Reject.list,REJECT

RULE-SET,LAN,DIRECT

GEOIP,CN,DIRECT
FINAL,prCloud,dns-failed

rule;

}

function get_url_rewrite(){
	echo <<<url_rewrite

[URL Rewrite]
# Redirect Google Service
^https?:\/\/(www.)?g\.cn https://www.google.com 302
^https?:\/\/(www.)?google\.cn https://www.google.com 302

# Redirect HTTP to HTTPS
^https?:\/\/(www.)?taobao\.com\/ https://www.taobao.com/ 302
^https?:\/\/(www.)?jd\.com\/ https://www.jd.com/ 302
^https?:\/\/(www.)?mi\.com\/ https://www.mi.com/ 302
^https?:\/\/you\.163\.com\/ https://you.163.com/ 302
^https?:\/\/(www.)?suning\.com/ https://suning.com/ 302
^https?:\/\/(www.)?yhd\.com https://yhd.com/ 302

# Redirect False to True
# >> IGN China to IGN Global
^https?:\/\/(www.)?ign\.xn--fiqs8s\/ http://cn.ign.com/ccpref/us 302
# >> Fake Website Made By Makeding
^https?:\/\/(www.)?abbyychina\.com\/ http://www.abbyy.cn/ 302
^https?:\/\/(www.)?bartender\.cc\/ https://cn.seagullscientific.com 302
^https?:\/\/(www.)?betterzip\.net\/ https://macitbetter.com/ 302
^https?:\/\/(www.)?beyondcompare\.cc\/ https://www.scootersoftware.com/ 302
^https?:\/\/(www.)?bingdianhuanyuan\.cn\/ http://www.faronics.com/zh-hans/ 302
^https?:\/\/(www.)?chemdraw\.com\.cn\/ http://www.cambridgesoft.com/ 302
^https?:\/\/(www.)?codesoftchina\.com\/ https://www.teklynx.com/ 302
^https?:\/\/(www.)?coreldrawchina\.com\/ https://www.coreldraw.com/cn/ 302
^https?:\/\/(www.)?crossoverchina\.com\/ https://www.codeweavers.com/ 302
^https?:\/\/(www.)?easyrecoverychina\.com\/ https://www.ontrack.com/ 302
^https?:\/\/(www.)?ediuschina\.com\/ https://www.grassvalley.com/ 302
^https?:\/\/(www.)?flstudiochina\.com\/ https://www.image-line.com/flstudio/ 302
^https?:\/\/(www.)?formysql\.com\/ https://www.navicat.com.cn 302
^https?:\/\/(www.)?guitarpro\.cc\/ https://www.guitar-pro.com/ 302
^https?:\/\/(www.)?huishenghuiying\.com\.cn\/ https://www.corel.com/cn/ 302
^https?:\/\/(www.)?iconworkshop\.cn\/ https://www.axialis.com/iconworkshop/ 302
^https?:\/\/(www.)?imindmap\.cc\/ https://imindmap.com/zh-cn/ 302
^https?:\/\/(www.)?jihehuaban\.com\.cn\/ https://sketch.io/ 302
^https?:\/\/(www.)?keyshot\.cc\/ https://www.keyshot.com/ 302
^https?:\/\/(www.)?mathtype\.cn\/ http://www.dessci.com/en/products/mathtype/ 302
^https?:\/\/(www.)?mindmanager\.cc\/ https://www.mindjet.com/ 302
^https?:\/\/(www.)?mindmapper\.cc\/ https://mindmapper.com 302
^https?:\/\/(www.)?mycleanmymac\.com\/ https://macpaw.com/cleanmymac 302
^https?:\/\/(www.)?nicelabel\.cc\/ https://www.nicelabel.com/ 302
^https?:\/\/(www.)?ntfsformac\.cc\/ https://www.tuxera.com/products/tuxera-ntfs-for-mac-cn/ 302
^https?:\/\/(www.)?ntfsformac\.cn\/ https://www.paragon-software.com/ufsdhome/zh/ntfs-mac/ 302
^https?:\/\/(www.)?overturechina\.com\/ https://sonicscores.com/overture/ 302
^https?:\/\/(www.)?passwordrecovery\.cn\/ https://cn.elcomsoft.com/aopr.html 302
^https?:\/\/(www.)?pdfexpert\.cc\/ https://pdfexpert.com/zh 302
^https?:\/\/(www.)?ultraiso\.net\/ https://cn.ezbsystems.com/ultraiso/ 302
^https?:\/\/(www.)?vegaschina\.cn\/ https://www.vegas.com/ 302
^https?:\/\/(www.)?xmindchina\.net\/ https://www.xmind.cn/ 302
^https?:\/\/(www.)?xshellcn\.com\/ https://www.netsarang.com/products/xsh_overview.html 302
^https?:\/\/(www.)?yuanchengxiezuo\.com\/ https://www.teamviewer.com/zhcn/ 302
^https?:\/\/(www.)?zbrushcn\.com\/ http://pixologic.com/ 302

# JD Protection
^https?:\/\/coupon\.m\.jd\.com\/ https://coupon.m.jd.com/ 302
^https?:\/\/h5\.m\.jd\.com\/ https://h5.m.jd.com/ 302
^https?:\/\/item\.m\.jd\.com\/ https://item.m.jd.com/ 302
^https?:\/\/m\.jd\.com\/ https://m.jd.com/ 302
^https?:\/\/newcz\.m\.jd\.com\/ https://newcz.m.jd.com/ 302
^https?:\/\/p\.m\.jd\.com\/ https://p.m.jd.com/ 302
^https?:\/\/so\.m\.jd\.com\/ https://so.m.jd.com/ 302
^https?:\/\/union\.click\.jd\.com\/jda? http://union.click.jd.com/jda?adblock= header
^https?:\/\/union\.click\.jd\.com\/sem.php? http://union.click.jd.com/sem.php?adblock= header
^https?:\/\/www.jd.com\/ https://www.jd.com/ 302

# Wiki
^https://zh.(m.)?wikipedia.org/zh(-\w*)?(?=/) http://www.wikiwand.com/zh$2 302
^https://(\w*).(m.)?wikipedia.org/wiki http://www.wikiwand.com/$1 302

# Advertising Block
# >> 58同城
^https?:\/\/app\.58\.com\/api\/home\/advertising\/ - reject
^https?:\/\/app\.58\.com\/api\/home\/appadv\/ - reject
^https?:\/\/app\.58\.com\/api\/home\/invite\/popupAdv - reject
^https?:\/\/app\.58\.com\/api\/log\/ - reject

# >> 爱回收
^https?:\/\/gw\.aihuishou\.com\/app-portal\/home\/getadvertisement - reject

# >> AcFun
^https?:\/\/aes\.acfun\.cn\/s\?adzones - reject

# >> 百词斩
^http:\/\/7n\.bczcdn\.com\/launchad\/ - reject

# >> Baidu
^https?:\/\/update\.pan\.baidu\.com\/statistics - reject
^https?:\/\/issuecdn\.baidupcs\.com\/issue\/netdisk\/guanggao\/ - reject

# >> 抱抱
^https?:\/\/www\.myhug\.cn\/ad\/ - reject

# >> ByteDance
^https?:\/\/.+\.pstatp\.com\/img\/ad - reject
^https?:\/\/.+\.snssdk\.com\/api\/ad\/ - reject
^https?:\/\/dsp\.toutiao\.com\/api\/xunfei\/ads\/ - reject

# >> China CITIC Bank
^https?:\/\/creditcard\.ecitic\.com\/citiccard\/wtk\/piwik\/piwik\.php - reject
^https?:\/\/m\.creditcard\.ecitic\.com\/citiccard\/mbk\/appspace-getway\/getWay\/appspace-system-web\/cr\/v5\/appStartAdv - reject

# >> China Merchants Bank
^https?:\/\/mlife\.cmbchina\.com/ClientFaceService\/preCacheAdvertise\.json - reject
^https?:\/\/mlife\.cmbchina\.com\/ClientFaceService\/getAdvertisement\.json - reject

# >> China Minsheng Bank
^https?:\/\/www\.cmbc\.com\.cn\/m\/image\/loadingpage\/ - reject

# >> ChinaMobile
^https?:\/\/app\.10086\.cn\/biz-orange\/DN\/homeSale\/getsaleAdver - reject
^https?:\/\/app\.10086\.cn\/biz-orange\/DH\/findSale\/getsaleAdver - reject

# >> ChinaUnicom
^https?:\/\/m\.client\.10010\.com\/mobileService\/customer\/accountListData\.htm - reject
^https?:\/\/m\.client\.10010\.com\/uniAdmsInterface\/(getWelcomeAd|getHomePageAd) - reject

# >> CNTV
^https?:\/\/cntv\.hls\.cdn\.myqcloud\.com\/.+\?maxbr=850 - reject
^https?:\/\/asp\.cntv\.myalicdn\.com\/.+\?maxbr=850 - reject
^https?:\/\/www\.cntv\.cn\/nettv\/adp\/ - reject
^https?:\/\/v\.cctv\.com\/.+850 - reject

# >> 车来了
^https?:\/\/(api|atrace)\.chelaile\.net\.cn\/adpub\/ - reject
^https?:\/\/api\.chelaile\.net\.cn\/goocity\/advert\/ - reject
^https?:\/\/atrace\.chelaile\.net\.cn\/exhibit\?&adv_image - reject
^https?:\/\/pic1\.chelaile\.net\.cn\/adv\/ - reject

# >> Douban
^https?:\/\/api\.douban\.com\/v2\/app_ads\/ - reject
^https?:\/\/erebor\.douban\.com\/count\/\?ad= - reject
^https?:\/\/frodo\.douban\.com\/.+ad - reject
^https?:\/\/.+\.doubanio\.com\/view\/dale-online\/dale_ad/ - reject

# >> 斗鱼
^https?:\/\/rtbapi\.douyucdn\.cn\/japi\/sign\/app\/getinfo - reject

# >> 当当
^https?:\/\/mapi\.dangdang\.com\/index\.php\?action=init - reject

# >> Facebook
^https?:\/\/www\.facebook\.com\/.+video_click_to_advertiser_site - reject

# >> Foodie
^https?:\/\/foodie-api\.yiruikecorp\.com\/v1\/(banner|notice)\/overview - reject

# >> FOTOABLE
^https?:\/\/cdn\.api\.fotoable\.com\/Advertise\/ - reject


# >> Google
^https?:\/\/.+\.youtube\.com\/get_midroll - reject
^https?:\/\/premiumyva\.appspot\.com\/vmclickstoadvertisersite - reject
^https?:\/\/.+\.youtube\.com\/api\/stats\/ads - reject
^https?:\/\/.+\.youtube\.com\/api\/stats\/.+adformat - reject
^https?:\/\/.+\.youtube\.com\/pagead\/ - reject
^https?:\/\/.+\.youtube\.com\/ptracking\? - reject
^https?:\/\/youtubei\.googleapis\.com/.+ad_break - reject

# >> 杭州公交
^https?:\/\/m\.ibuscloud.com\/v2\/app\/getStartPage - reject

# >> 杭州市·市民卡
^https?:\/\/smkmp\.96225.com\/smkcenter\/ad/ - reject

# >> 虎扑
^https?:\/\/games\.mobileapi\.hupu\.com\/.+\/status\/init - reject
^https?:\/\/games\.mobileapi\.hupu\.com\/.+\/interfaceAdMonitor\/ - reject

# >> 花生地铁
^https?:\/\/cmsapi\.wifi8\.com\/v1\/emptyAd\/info - reject
^https?:\/\/cmsapi\.wifi8\.com\/v2\/adNew\/config - reject

# >> iFlytek
^https?:\/\/imeclient\.openspeech\.cn\/adservice\/ - reject

# >> iQiyi
^https?:\/\/iface\.iqiyi\.com\/api\/getNewAdInfo - reject
^https?:\/\/t7z\.cupid\.iqiyi\.com\/mixer\? - reject

# >> JD
^https?:\/\/api\.m\.jd.com\/client\.action\?functionId=start - reject
^https?:\/\/(bdsp-x|dsp-x)\.jd\.com\/adx\/ - reject
^https?:\/\/ms\.jr\.jd\.com\/gw\/generic\/base\/na\/m\/adInfo - reject

# >> 界面新闻
^https?:\/\/img\.jiemian\.com\/ads\/ - reject

# >> 快看漫画
^https?:\/\/api\.kkmh\.com\/.+(ad|advertisement)\/ - reject

# >> Keep
^https?:\/\/static1\.keepcdn\.com\/.+\d{3}x\d{4} - reject

# >> 肯德基
^https?:\/\/res\.kfc\.com\.cn\/advertisement\/ - reject

# >> Kingsoft
^https?:/\/\counter\.ksosoft.com\/ad\.php - reject
^https?:\/\/ios\.wps\.cn\/ad-statistics-service - reject
^https?:\/\/mobile-pic\.cache\.iciba\.com\/feeds_ad\/ - reject
^https?:\/\/.+\.kingsoft-office-service\.com\/ad - reject
^https?:\/\/dict-mobile\.iciba\.com\/interface\/index\.php\?.+(c=ad|collectFeedsAdShowCount|KSFeedsAdCardViewController) - reject
^https?:\/\/service\.iciba\.com\/popo\/open\/screens\/v3\?adjson - reject

# >> Le
^https?:\/\/.+\/letv-gug\/ - reject

# >> 麻花影视
^https?:\/\/.+\/api\/app\/member\/ver2\/user\/login\/ - reject

# >> 埋堆堆
^https?:\/\/mob\.mddcloud\.com\.cn\/api\/(ad|advert)\/ - reject

# >> 漫画人
^https?:\/\/mangaapi\.manhuaren\.com\/v1\/public\/getStartPageAds - reject


# >> 美团
^https?:\/\/img\.meituan\.net\/midas\/ - reject
^https?:\/\/p([0-9])\.meituan\.net\/(mmc|wmbanner)\/ - reject

# >> 美味不用等
^https?:\/\/capi.mwee.cn/app-api/V12/app/getstartad - reject

# >> MI
^https?:\/\/api\.m\.mi\.com\/v1\/app\/start - reject
^https?:\/\/api\.jr\.mi\.com\/v1\/adv\/ - reject

# >> MI Fit
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/homepage_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/sleep_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/sport_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/sport_summary_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/sport_training_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/step_detail_ad\? - reject
^https?:\/\/api-mifit\.huami\.com\/discovery\/mi\/discovery\/training_video_ad\? - reject

# >> 咪咕
^https?:\/\/.+\/v1\/iflyad\/ - reject
^https?:\/\/.+\/cdn-adn\/ - reject
^https?:\/\/ggic\.cmvideo\.cn\/ad\/ - reject
^https?:\/\/ggic2\.cmvideo\.cn\/ad\/ - reject
^https?:\/\/.+/img\/ad\.union\.api\/ - reject

# >> 秒拍
^https?:\/\/b-api\.ins\.miaopai\.com\/1\/ad/ - reject

# >> MogoRenter
^https?:\/\/api\.mgzf\.com\/renter-operation\/home\/startHomePage - reject

# >> MojiWeather
^https?:\/\/cdn\.moji\.com\/(adoss|adlink)\/ - reject

# >> 墨迹天气
^https?:\/\/cdn\.moji\.com\/adoss\/ - reject
^https?:\/\/cdn\.moji\.com\/adlink\/ - reject

# >> NetEase
^https?:\/\/oimage([a-z])([0-9])\.ydstatic\.com\/.+adpublish - reject
^https?:\/\/dsp-impr2\.youdao\.com\/adload.s\? - reject
^https?:\/\/c\.m\.163\.com\/nc\/gl\/ - reject
^https?:\/\/client\.mail\.163\.com\/apptrack\/confinfo\/searchMultiAds - reject
^https?:\/\/.+\/eapi\/(ad|log)\/ - reject
^https?:\/\/sp\.kaola\.com\/api\/openad - reject
^https?:\/\/support\.you\.163\.com\/xhr\/boot\/getBootMedia\.json - reject

# >> ofo
^https?:\/\/supportda\.ofo\.com\/adaction\? - reject
^https?:\/\/ma\.ofo\.com\/ads\/ - reject
^https?:\/\/activity2\.api\.ofo\.com\/ofo\/Api\/v2\/ads - reject
^https?:\/\/ma\.ofo\.com\/adImage\/ - reject

# >> Qdaily
^https?:\/\/app3\.qdaily\.com\/app3\/boot_advertisements\.json - reject
^https?:\/\/notch\.qdaily\.com\/api\/v2\/boot_ad - reject

# >> 穷游
^https?:\/\/open\.qyer\.com\/qyer\/startpage\/ - reject
^https?:\/\/open\.qyer.com\/qyer\/config\/get - reject
^https?:\/\/media\.qyer\.com\/ad\/ - reject

# >> 什么值得买
^https?:\/\/api\.smzdm\.com\/v1\/util\/loading - reject

# >> 四季線上影視4gTV
^https?:\/\/service\.4gtv\.tv\/4gtv\/Data\/GetAD - reject
^https?:\/\/service\.4gtv\.tv\/4gtv\/Data\/ADLog - reject

# >> 肆客足球
^https?:\/\/api\.qiuduoduo\.cn\/guideimage - reject

# >> Sina
^https?:\/\/edit\.sinaapp\.com\/ua\?t=adv - reject

# >> Sina 天气通
^https?:\/\/tqt\.weibo\.cn\/overall\/redirect\.php\?r=tqt_sdkad - reject
^https?:\/\/tqt\.weibo\.cn\/overall\/redirect\.php\?r=tqtad - reject
^https?:\/\/tqt\.weibo\.cn\/.+advert\.index - reject

# >> Sina Weibo
^https?:\/\/sdkapp\.uve\.weibo\.com\/interface\/sdk\/sdkad\.php - reject
^https?:\/\/wbapp\.uve\.weibo\.com\/wbapplua\/wbpullad\.lua - reject
^https?:\/\/sdkapp\.uve\.weibo\.com/\interface\/sdk\/actionad\.php - reject

# >> Sohu
^https?:\/\/api\.k\.sohu\.com\/api\/news\/adsense - reject
^https?:\/\/pic\.k\.sohu\.com\/img8\/wb\/tj\/ - reject
^https?:\/\/hui\.sohu\.com\/predownload2/\? - reject

# >> 太平洋
^https?:\/\/agent-count\.pconline\.com\.cn\/counter\/adAnalyse\/ - reject
^https?:\/\/mrobot\.pconline\.com\.cn\/v3\/ad2p - reject
^https?:\/\/mrobot\.pconline\.com\.cn\/s\/onlineinfo\/ad\/ - reject
^https?:\/\/mrobot\.pcauto\.com\.cn\/v3\/ad2p - reject
^https?:\/\/mrobot\.pcauto\.com\.cn\/xsp\/s\/auto\/info\/preload\.xsp - reject

# >> Tencent Futu Securities
^https?:\/\/api5\.futunn\.com\/ad\/ - reject

# >> Tencent Maps
^https?:\/\/newsso\.map\.qq\.com\/\?&attime= - reject

# >> Tencent QQLive
^https?:\/\/btrace.qq.com - reject
^https?:\/\/vv\.video\.qq\.com\/getvmind\? - reject
^https?:\/\/.+\.mp4\?cdncode=.+&guid= - reject

# >> QQNews
^https?:\/\/r\.inews\.qq\.com\/getFullScreenPic - reject
^https?:\/\/r\.inews\.qq\.com\/adsBlacklist - reject
^https?:\/\/r\.inews\.qq\.com\/getQQNewsRemoteConfig - reject

# >> Tencent WeChat
^https?:\/\/mp\.weixin\.qq.com\/mp\/ad_complaint - reject
^https?:\/\/mp\.weixin\.qq.com\/mp\/advertisement_report - reject
^https?:\/\/mp\.weixin\.qq.com\/mp\/ad_video - reject

# >> Thunder
^https?:\/\/images\.client\.vip\.xunlei\.com\/.+\/advert\/ - reject

# >> TV_Home
^https?:\/\/api\.gaoqingdianshi\.com\/api\/v2\/ad\/ - reject

# >> 太平洋
^https?:\/\/agent-count\.pconline\.com\.cn\/counter\/adAnalyse\/ - reject
^https?:\/\/mrobot\.pconline\.com\.cn\/v3\/ad2p - reject
^https?:\/\/mrobot\.pconline\.com\.cn\/s\/onlineinfo\/ad\/ - reject
^https?:\/\/mrobot\.pcauto\.com\.cn\/v3\/ad2p - reject
^https?:\/\/mrobot\.pcauto\.com\.cn\/xsp\/s\/auto\/info\/preload\.xsp - reject

# >> UC
^https?:\/\/huichuan\.sm\.cn\/jsad - reject
^https?:\/\/iflow\.uczzd\.cn\/log\/ - reject

# >> WeDoctor
^https?:\/\/app\.wy\.guahao\.com\/json\/white\/dayquestion\/getpopad - reject

# >> Weico
^https?:\/\/overseas\.weico\.cc/portal\.php\?a=get_coopen_ads - reject

# >> 下厨房
^https?:\/\/api\.xiachufang\.com\/v2\/ad/ - reject

# >> 虾米
^https?:\/\/acs\.m\.taobao\.com\/gw\/mtop\.alimusic\.common\.mobileservice\.startinit\/ - reject

# >> 闲鱼
^https?:\/\/gw\.alicdn\.com\/mt\/ - reject
^https?:\/\/gw\.alicdn\.com\/tfs\/.+\d{3,4}-\d{4} - reject
^https?:\/\/gw\.alicdn\.com\/tps\/.+\d{3,4}-\d{4} - reject

# >> 喜马拉雅
^https?:\/\/adse.+\.com\/[a-z]{4}\/loading\?appid= - reject
^https?:\/\/adse\.ximalaya\.com\/ting\/feed\?appid= - reject
^https?:\/\/adse\.ximalaya\.com\/ting\/loading\?appid= - reject
^https?:\/\/adse\.ximalaya\.com\/ting\?appid= - reject
^https?:\/\/fdfs\.xmcdn\.com\/group21\/M03\/E7\/3F\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group21\/M0A\/95\/3B\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group22\/M00\/92\/FF\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group22\/M05\/66\/67\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group22\/M07\/76\/54\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group23\/M01\/63\/F1\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group23\/M04\/E5\/F6\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group23\/M07\/81\/F6\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group23\/M0A\/75\/AA\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group24\/M03\/E6\/09\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group24\/M07\/C4\/3D\/ - reject
^https?:\/\/fdfs\.xmcdn\.com\/group25\/M05\/92\/D1\/ - reject

# >> Yahoo!
^https?:\/\/m\.yap\.yahoo\.com\/v18\/getAds\.do - reject

# >> 萤石云视频
^https?:\/\/i\.ys7\.com\/api\/ads - reject

# >> Youtube++
^http:\/\/api\.catch\.gift\/api\/v3\/pagead\/ - reject

# >> YOUKU
^https?:\/\/.+\.mp4\?ccode=0902 - reject
^https?:\/\/.+\.mp4\?sid= - reject

# >> 运动世界
^https?:\/\/.+\.iydsj\.com\/api\/.+\/ad - reject

# >> YYeTs
^https?:\/\/ctrl\.(playcvn|zmzapi)\.(com|net)\/app\/(ads|init) - reject

# >> 直播吧
^https?:\/\/a\.qiumibao\.com\/activities\/config\.php - reject
^https?:\/\/.+\/allOne\.php\?ad_name - reject

# >> 知乎
^https?:\/\/www\.zhihu\.com\/api\/v4\/community-ad\/ - reject
^https?:\/\/api\.zhihu\.com\/real_time_launch - reject
^https?:\/\/api\.zhihu\.com\/launch - reject

# >> 追书神器
^https?:\/\/api\.zhuishushenqi\.com\/advert - reject
^https?:\/\/api\.zhuishushenqi\.com\/notification\/shelfMessage - reject
^https?:\/\/api\.zhuishushenqi\.com\/recommend - reject
^https?:\/\/api\.zhuishushenqi\.com\/splashes\/ios - reject
^https?:\/\/mi\.gdt\.qq\.com\/gdt_mview\.fcg - reject
^https?:\/\/dspsdk\.abreader\.com\/v2\/api\/ad\? - reject

url_rewrite;
}

function get_host(){
	echo <<<host
[Host]
ip6-localhost = ::1
ip6-loopback = ::1
taobao.com = server:223.6.6.6
*.taobao.com = server:223.6.6.6
tmall.com = server:223.6.6.6
*.tmall.com = server:223.6.6.6
jd.com = server:119.29.29.29
*.jd.com = server:119.28.28.28
*.qq.com = server:119.28.28.28
*.tencent.com = server:119.28.28.28
*.alicdn.com = server:223.5.5.5
aliyun.com = server:223.5.5.5
*.aliyun.com = server:223.5.5.5
weixin.com = server:119.28.28.28
*.weixin.com = server:119.28.28.28
bilibili = server:119.29.29.29
*.bilibili = server:119.29.29.29
163.com = server:119.29.29.29
*.163.com = server:119.29.29.29
126.com = server:119.29.29.29
*.126.com = server:119.29.29.29
*.126.net = server:119.29.29.29
*.127.net = server:119.29.29.29
*.netease.com = server:119.29.29.29
mi.com = server:119.29.29.29
*.mi.com = server:119.29.29.29
xiaomi.com = server:119.29.29.29
*.xiaomi.com = server:119.29.29.29



host;

}
function get_mitm(){
	echo <<<mitm
[MITM]
hostname = *.chelaile.net.cn,*.douban.com,*.doubanio.com,*.iydsj.com,*.k.sohu.com,*.kingsoft-office-service.com,*.meituan.net,*.ofo.com,*.snssdk.com,*.uve.weibo.com,*.ydstatic.com,*.youdao.com,*.youtube.com,a.qiumibao.com,*.pstatp.com,api.jr.mi.com,api.kkmh.com,api.m.jd.com,api.smzdm.com,api.weibo.cn,api.xiachufang.com,api.zhihu.com,api5.futunn.com,app.10086.cn,app.58.com,app.wy.guahao.com,c.m.163.com,capi.mwee.cn,cdn.moji.com,client.mail.163.com,creditcard.ecitic.com,huichuan.sm.cn,i.ys7.com,iface.iqiyi.com,img.jiemian.com,ios.wps.cn,m.client.10010.com,m.creditcard.ecitic.com,m.ibuscloud.com,m.yap.yahoo.com,media.qyer.com,mlife.cmbchina.com,mob.mddcloud.com.cn,mp.weixin.qq.com,mrobot.pcauto.com.cn,mrobot.pconline.com.cn,ms.jr.jd.com,newsso.map.qq.com,open.qyer.com,r.inews.qq.com,rtbapi.douyucdn.cn,service.4gtv.tv,smkmp.96225.com,sp.kaola.com,static1.keepcdn.com,www.zhihu.com,*.rixcloudservice.com,*.wikipedia.org, *.zhuishushenqi.com, mi.gdt.qq.com, gw.alicdn.comm, youtubei.googleapis.com, *.kfc.com, dspsdk.abreader.com, fdfs.xmcdn.com, adse.ximalaya.com
ca-passphrase = rixCloudPKI
ca-p12 = MIIEWgIBAzCCBCAGCSqGSIb3DQEHAaCCBBEEggQNMIIECTCCAv8GCSqGSIb3DQEHBqCCAvAwggLsAgEAMIIC5QYJKoZIhvcNAQcBMBwGCiqGSIb3DQEMAQYwDgQIEbxT6Tq17dsCAggAgIICuCzGa3ovYwnv6OIzJLkSKyAFypSmJ8KTBPyai2s1heOTIf3PoC0aSml1Q0blJ2R9tAEJMS3SoM4PjNK6q6nGycAgx1dIUFEQG7DEQebVP0XHHK6uNyRPqgXPrhCXjqZSOLhpcsg4BfLRjf0S0fquZySAi7kn5IXUo1fUey2r/36UkT8imBHPsUSsllryK5dXBQAwJtPYGl7nV50F/LA58ckv5pT+gDS4vVvUAytPfoqTDPCUEMzrZkXu7ZP/6YP+DeUgLXFvEubSkmrEeztJoC2GozClPNtRHfbMzA/jTH1/lOZ1zDdvrNheDLgP8CBv/mawNy4dxrJozfOcdEiWdLAMp8PmcXvaY9sNVlYYP+ztIMA/oaIHEycsOvx1PxMU2i8s/SIZBDszdHgRqKC6fVJxcrv0qtYdUlmfGKWt85LeB7JPXlmfs6ovGrZuc9y2WNnq2cbPmZuKbdxB5j/oM8jA6fLO9Z1MZDEXo42CgU7ZONjK8/bLG5J3wlI4DnC6HYwk3hSUWRBFpjNkRlUhZZWwMsfjBmYG9/hvDF7aGCeBDwm/euWLz9lGuUqRs5F11YhRL2dhOHC2mB4fhsSGbsgOps15fsuUydheYbU12hkGfYQSNsVi0d1GiGIsdiEtrYhXAWnY6DfGPERbhYvwlPSUAvdgWltC/BYgVMM//y3PwCVhcjEfYOK6k3ZNLuIc4Nebk2FPI7u0eXCk0Pi/RiSlOiBO79B2jpEdpyQbEDYAvetEsmaU6M8SZMMHnupNET/Sy+LlpFhRDSRcQndHpBkw166rM+6H3IHewJyYZBNvesltVBuSGtmJx57QI63CgCTUiu/UmWlHKmGuK5pHbMJlkREWJnVYqT3WIoB7MCX19bhLWxfbcLO+pipr8jrrjUF0skOLwg7HxnqHDk6oLyN4eLgn3Kr70zCCAQIGCSqGSIb3DQEHAaCB9ASB8TCB7jCB6wYLKoZIhvcNAQwKAQKggbQwgbEwHAYKKoZIhvcNAQwBAzAOBAgCgEDjD1kMngICCAAEgZCwn6xW0rtwHctlMsJw20caSgWcFTLcNBTgISSri2XLMeJfvygcgFbO7/zT64stk1tVZRktjAX/fELsFp4Xw/UspdVG6CgsRE7QcY+CT8wn6dvusvU2mv3KpI7NwrXmUMsKNbW5N8Qh37WYTCg5mvA7jFAazC+RnKgoMvMVnQbuT1CMJ3in7lPIsPTW3ub0188xJTAjBgkqhkiG9w0BCRUxFgQU8ZGlcfqIeitY4nkiNU7TX5gEi6MwMTAhMAkGBSsOAwIaBQAEFCBiCE2z1g+P8yPQTFy79/Pahq/lBAixZy/UGOLmVQICCAA=



mitm;
}



function get_ssr_hosts($url) {
	if ($url == "") return false;

	$file = fopen ($url, "r");
	if (!$file) {
		echo "<p>请检查url是否正确？url不需要加\"\"\n";
	        exit;
}

	$line = fgets($file);
	//echo $line;
	fclose($file);
	$str = base64_decode($line);
	//echo $str;
	$strarr = explode(PHP_EOL,$str);
	//print_r ($strarr);
	//$strarrcount = count($strarr);
	//echo $strarrcount;

	$i=0;
	foreach ($strarr as $ssr){
		$ssr = str_replace("_","+",$ssr);
		$ssr = str_replace("-","+",$ssr);
		$ssrdecode = base64_decode(substr($ssr,6,strlen($ssr)-6));
		$ssrdecode = str_replace("_","+",$ssrdecode);
		$ssrdecode = str_replace("_","+",$ssrdecode);
		//echo $ssrdecode;
		$hosts[$i] = ssr_tr($ssrdecode);	
		//echo $i;
		//echo ":";
		//echo $ssrdecode;
		//echo PHP_EOL;
		$i++;
	}
	//print_r ($hosts);
	return $hosts;
}


function ssr_tr($ssrdecode){
	        if ($ssrdecode == "") {return false;}
	        $ssrdecodearr = explode(":",$ssrdecode);
		//print_r ($ssrdecodearr);
		$passwd = base64_decode(substr($ssrdecodearr[5],0,strpos($ssrdecodearr[5],"/")));
	        $host = $ssrdecodearr[0];
	        $port = $ssrdecodearr[1];
	        $encrypt = $ssrdecodearr[3];
                $ssrdecodearr[5] = str_replace("-","+",$ssrdecodearr[5]);
		$ssrdecodearr[5] = str_replace("_","+",$ssrdecodearr[5]);
		$name = base64_decode(substr($ssrdecodearr[5],strpos($ssrdecodearr[5],"&remarks=")+strlen("&remarks="),strpos($ssrdecodearr[5],"&group=")-strpos($ssrdecodearr[5],"&remarks=")-strlen("&remarks=")));
		//echo  mb_detect_encoding($name); 
		$name = iconv("UTF-8", "UTF-8//IGNORE", $name);
		//echo $encode;
		$rtv = $name." = ss,".$host.",".$port.",encrypt-method=".$encrypt.",password=".$passwd.",udp-relay=true";
	        return $rtv;
}


?>
